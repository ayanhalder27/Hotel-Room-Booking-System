<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'search');

    // Search active checked-in bookings
    if ($action === 'search') {
        $q = post('q');
        $sql = "
            SELECT 
                b.id,
                u.name AS guest_name,
                r.room_number,
                b.room_id,
                b.checkin_date,
                b.checkout_date,
                COALESCE(bl.payment_status, 'pending') AS payment_status,
                COALESCE(bl.total_amount, 0) AS total_amount
            FROM bookings b
            JOIN users u ON u.id = b.guest_id
            JOIN rooms r ON r.id = b.room_id
            LEFT JOIN billing bl ON bl.booking_id = b.id
            WHERE b.status = 'checked_in'
        ";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR r.room_number LIKE ?)";
            $params = [likeQ($q), likeQ($q), likeQ($q)];
        }

        $sql .= " ORDER BY b.checkout_date";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Checkout process
    if ($action === 'checkout') {
        requiredFields(['booking_id']);

        $bid = (int) post('booking_id');

        db::BeginTransaction();

        $booking = db::Fetch(
            "SELECT id, room_id, status 
             FROM bookings 
             WHERE id=? FOR UPDATE",
            $bid
        );

        if (!$booking || $booking['status'] !== 'checked_in') {
            throw new Exception('Active checked-in booking not found.');
        }

        $paymentStatus = db::FetchValue("SELECT payment_status FROM billing WHERE booking_id=?", $bid);
        if ($paymentStatus !== 'paid') {
            throw new Exception('Bill is not paid. Process payment before checkout.');
        }

        // Update booking and room status
        db::Execute("UPDATE bookings SET status='checked_out' WHERE id=?", $bid);
        db::Execute("UPDATE rooms SET status='dirty' WHERE id=?", (int) $booking['room_id']);

        // Auto-assign housekeeping cleaning task
        $housekeeper = db::FetchValue("SELECT id FROM users WHERE role='housekeeping' AND is_active=1 LIMIT 1");
        if ($housekeeper) {
            db::Execute(
                "INSERT INTO housekeeping_tasks(room_id, assigned_to, task_type, priority, status, notes) 
                 VALUES(?, ?, 'cleaning', 'normal', 'pending', 'Auto cleaning task after checkout')",
                (int) $booking['room_id'],
                (int) $housekeeper
            );
        }

        db::Commit();
        db::JsonResponse(true, 'Guest checked out. Room marked dirty.');
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    try {
        db::Rollback();
    } catch (Exception $x) {
        // ignore rollback errors
    }
    db::JsonResponse(false, $e->getMessage());
}
