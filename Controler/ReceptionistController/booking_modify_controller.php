<?php
require_once __DIR__ . "/../../Model/dbRec.php";

try {
    $action = post('action', 'list');

    // List confirmed or checked-in bookings
    if ($action === 'list') {
        $q = post('q');
        $sql = "
            SELECT 
                b.id,
                u.name AS guest_name,
                rt.name AS room_type,
                b.room_type_id,
                b.room_id,
                b.checkin_date,
                b.checkout_date,
                b.status
            FROM bookings b
            JOIN users u ON u.id = b.guest_id
            JOIN room_types rt ON rt.id = b.room_type_id
            WHERE b.status IN ('confirmed','checked_in')
        ";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ?)";
            $params = [likeQ($q), likeQ($q)];
        }

        $sql .= " ORDER BY b.checkin_date DESC LIMIT 100";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Update booking dates
    if ($action === 'update_dates') {
        requiredFields(['booking_id','checkin_date','checkout_date']);
        validDateRange(post('checkin_date'), post('checkout_date'));

        $bid = (int) post('booking_id');

        db::BeginTransaction();

        $booking = db::Fetch("SELECT * FROM bookings WHERE id=? FOR UPDATE", $bid);
        if (!$booking) {
            throw new Exception('Booking not found.');
        }

        // Check for conflicts if room is assigned
        if ($booking['room_id']) {
            $conflict = db::FetchValue(
                "SELECT COUNT(*) 
                 FROM bookings 
                 WHERE id<>? 
                   AND room_id=? 
                   AND status IN('confirmed','checked_in') 
                   AND ? < checkout_date 
                   AND ? > checkin_date",
                $bid,
                (int) $booking['room_id'],
                post('checkin_date'),
                post('checkout_date')
            );

            if ($conflict > 0) {
                throw new Exception('Selected date conflicts with another booking for this room.');
            }
        }

        // Calculate nights and total price
        $nights = (strtotime(post('checkout_date')) - strtotime(post('checkin_date'))) / 86400;
        $price = (float) db::FetchValue("SELECT price_per_night FROM room_types WHERE id=?", (int) $booking['room_type_id']);
        $total = $price * $nights;

        // Update booking and billing
        db::Execute(
            "UPDATE bookings SET checkin_date=?, checkout_date=?, total_price=? WHERE id=?",
            post('checkin_date'),
            post('checkout_date'),
            $total,
            $bid
        );
        db::Execute("UPDATE billing SET base_amount=? WHERE booking_id=?", $total, $bid);

        db::Commit();
        db::JsonResponse(true, 'Booking dates updated.');
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
