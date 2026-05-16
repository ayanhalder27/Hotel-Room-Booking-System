<?php
require_once __DIR__ . '/_rec_common.php';

try {
    $action = rec_Controler_action();

    if ($action === 'search') {
        $q = rec_input('q');
        rec_required($q, 'Search text');
        $rows = db::FetchAll("SELECT b.id, u.name AS guest_name, r.room_number, b.checkout_date, COALESCE(bl.payment_status,'pending') AS payment_status, COALESCE(bl.total_amount,0) AS total_amount
            FROM bookings b
            JOIN users u ON u.id=b.guest_id
            LEFT JOIN rooms r ON r.id=b.room_id
            LEFT JOIN billing bl ON bl.booking_id=b.id
            WHERE b.status='checked_in' AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR u.phone LIKE ? OR r.room_number LIKE ?)
            ORDER BY b.checkout_date ASC", rec_like($q), rec_like($q), rec_like($q), rec_like($q));
        rec_json(true, 'Checkout search completed.', $rows);
    }

    if ($action === 'checkout') {
        $bookingId = rec_int(rec_input('booking_id'), 'Booking ID');
        $booking = db::Fetch("SELECT b.*, bl.payment_status FROM bookings b LEFT JOIN billing bl ON bl.booking_id=b.id WHERE b.id=?", $bookingId);
        if (!$booking) throw new Exception('Booking not found.');
        if ($booking['status'] !== 'checked_in') throw new Exception('Only checked-in bookings can be checked out.');
        if (($booking['payment_status'] ?? 'pending') !== 'paid') throw new Exception('Bill is not paid. Please process payment first.');
        if (empty($booking['room_id'])) throw new Exception('No physical room is assigned to this booking.');

        db::BeginTransaction();
        try {
            db::Execute("UPDATE bookings SET status='checked_out' WHERE id=?", $bookingId);
            db::Execute("UPDATE rooms SET status='dirty' WHERE id=?", (int)$booking['room_id']);

            $housekeeper = db::FetchValue("SELECT id FROM users WHERE role='housekeeping' AND is_active=1 ORDER BY id LIMIT 1");
            if ($housekeeper) {
                db::Execute("INSERT INTO housekeeping_tasks (room_id, assigned_to, task_type, priority, status, notes, scheduled_date) VALUES (?, ?, 'cleaning', 'urgent', 'pending', ?, NOW())",
                    (int)$booking['room_id'], (int)$housekeeper, 'Auto-created after receptionist checkout for booking #' . $bookingId);
            }
            db::Commit();
        } catch (Exception $e) {
            db::Rollback();
            throw $e;
        }
        rec_json(true, 'Guest checked out successfully. Room is now dirty.');
    }

    rec_json(false, 'Invalid checkout action.', [], 400);
} catch (Exception $e) {
    rec_json(false, $e->getMessage(), [], 500);
}
?>
