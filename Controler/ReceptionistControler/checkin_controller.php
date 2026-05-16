<?php
require_once __DIR__ . '/_rec_common.php';

try {
    $action = rec_Controler_action();

    if ($action === 'search') {
        $q = rec_input('q');
        rec_required($q, 'Search text');
        $rows = db::FetchAll("SELECT b.id, b.room_type_id, u.name AS guest_name, u.national_id AS id_number, rt.name AS room_type, b.checkin_date, b.checkout_date, b.status
            FROM bookings b
            JOIN users u ON u.id=b.guest_id
            JOIN room_types rt ON rt.id=b.room_type_id
            WHERE b.status='confirmed' AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR u.phone LIKE ? OR u.national_id LIKE ?)
            ORDER BY b.checkin_date ASC, b.created_at ASC", rec_like($q), rec_like($q), rec_like($q), rec_like($q));
        rec_json(true, 'Booking search completed.', $rows);
    }

    if ($action === 'available_rooms') {
        $roomTypeId = rec_int(rec_input('room_type_id'), 'Room type');
        $rows = db::FetchAll("SELECT id, room_number, floor FROM rooms WHERE room_type_id=? AND status='available' ORDER BY floor, room_number", $roomTypeId);
        rec_json(true, 'Available rooms loaded.', $rows);
    }

    if ($action === 'checkin') {
        $bookingId = rec_int(rec_input('booking_id'), 'Booking ID');
        $roomId = rec_int(rec_input('room_id'), 'Room');
        $idNumber = rec_input('id_number');
        rec_required($idNumber, 'Guest ID number');

        $booking = db::Fetch("SELECT b.*, u.national_id FROM bookings b JOIN users u ON u.id=b.guest_id WHERE b.id=?", $bookingId);
        if (!$booking) throw new Exception('Booking not found.');
        if ($booking['status'] !== 'confirmed') throw new Exception('Only confirmed bookings can be checked in.');
        if ($booking['national_id'] !== $idNumber) throw new Exception('Guest ID verification failed.');

        $room = db::Fetch("SELECT * FROM rooms WHERE id=?", $roomId);
        if (!$room) throw new Exception('Room not found.');
        if ($room['status'] !== 'available') throw new Exception('Selected room is not available.');
        if ((int)$room['room_type_id'] !== (int)$booking['room_type_id']) throw new Exception('Selected room type does not match booking room type.');

        db::BeginTransaction();
        try {
            db::Execute("UPDATE bookings SET room_id=?, status='checked_in' WHERE id=?", $roomId, $bookingId);
            db::Execute("UPDATE rooms SET status='occupied' WHERE id=?", $roomId);
            db::Commit();
        } catch (Exception $e) {
            db::Rollback();
            throw $e;
        }
        rec_json(true, 'Guest checked in successfully.');
    }

    rec_json(false, 'Invalid check-in action.', [], 400);
} catch (Exception $e) {
    rec_json(false, $e->getMessage(), [], 500);
}
?>
