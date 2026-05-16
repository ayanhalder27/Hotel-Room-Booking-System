<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'search');

    // Search confirmed bookings
    if ($action === 'search') {
        $q = post('q');
        $sql = "
            SELECT 
                b.id,
                b.room_type_id,
                u.name AS guest_name,
                u.national_id,
                rt.name AS room_type,
                b.checkin_date,
                b.checkout_date
            FROM bookings b
            JOIN users u ON u.id = b.guest_id
            JOIN room_types rt ON rt.id = b.room_type_id
            WHERE b.status = 'confirmed'
        ";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ?)";
            $params = [likeQ($q), likeQ($q)];
        }

        $sql .= " ORDER BY b.checkin_date, b.created_at";

        $rows = db::FetchAll($sql, $params);

        // Attach available rooms for each booking
        foreach ($rows as &$row) {
            $row['available_rooms'] = db::FetchAll(
                "SELECT id, room_number, floor 
                 FROM rooms 
                 WHERE room_type_id=? AND status='available' 
                 ORDER BY room_number",
                (int) $row['room_type_id']
            );
        }

        db::JsonResponse(true, 'Loaded', $rows);
    }

    // Perform check-in
    if ($action === 'checkin') {
        requiredFields(['booking_id', 'room_id']);

        $bid = (int) post('booking_id');
        $rid = (int) post('room_id');

        db::BeginTransaction();

        $booking = db::Fetch(
            "SELECT id, status, room_type_id 
             FROM bookings 
             WHERE id=? FOR UPDATE",
            $bid
        );

        if (!$booking || $booking['status'] !== 'confirmed') {
            throw new Exception('Booking is not confirmed or not found.');
        }

        $room = db::Fetch(
            "SELECT id, status, room_type_id 
             FROM rooms 
             WHERE id=? FOR UPDATE",
            $rid
        );

        if (
            !$room ||
            $room['status'] !== 'available' ||
            $room['room_type_id'] != $booking['room_type_id']
        ) {
            throw new Exception('Selected room is not available for this room type.');
        }

        // Update booking and room status
        db::Execute(
            "UPDATE bookings SET room_id=?, status='checked_in' WHERE id=?",
            $rid,
            $bid
        );
        db::Execute("UPDATE rooms SET status='occupied' WHERE id=?", $rid);

        db::Commit();
        db::JsonResponse(true, 'Guest checked in successfully.');
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
