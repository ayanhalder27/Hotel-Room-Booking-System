<?php
require_once __DIR__ . '/dbRec.php';

class Booking extends db {

    public static function getAllBookings() {
        $query = "SELECT b.id, u.name, r.room_number, b.checkin_date, b.checkout_date, b.status
                  FROM bookings b
                  JOIN users u ON b.guest_id = u.id
                  JOIN rooms r ON b.room_id = r.id
                  ORDER BY b.id DESC";
        return self::FetchAll($query);
    }

    public static function searchBooking($search) {
        $search = "%{$search}%";
        $query = "SELECT b.id, u.name, r.room_number, b.checkin_date, b.checkout_date, b.status
                  FROM bookings b
                  JOIN users u ON b.guest_id = u.id
                  JOIN rooms r ON b.room_id = r.id
                  WHERE b.id LIKE ? OR u.name LIKE ? OR r.room_number LIKE ?";
        return self::FetchAll($query, $search, $search, $search);
    }

    public static function checkIn($bookingId) {
        self::Execute("UPDATE bookings SET status='checked_in' WHERE id=?", $bookingId);
        return self::Execute("UPDATE rooms SET status='occupied' WHERE id=(SELECT room_id FROM bookings WHERE id=?)", $bookingId);
    }

    public static function checkOut($bookingId) {
        self::Execute("UPDATE bookings SET status='checked_out' WHERE id=?", $bookingId);
        return self::Execute("UPDATE rooms SET status='dirty' WHERE id=(SELECT room_id FROM bookings WHERE id=?)", $bookingId);
    }

    public static function createWalkinBooking($guestId, $roomId, $checkin, $checkout) {
        // Query isolation matching verified key indexes mapped starting from 3001 upwards
        $room = self::Fetch("SELECT room_type_id FROM rooms WHERE id = ?", $roomId);
        if (!$room) {
            throw new Exception("Operational Interruption: The room identity handle reference '" . htmlspecialchars($roomId) . "' does not match any current active row inside the data store profile.");
        }
        $roomTypeId = $room['room_type_id'];

        // Enforce safe default price allocations to pass SQL checking without breaking the integrity constraint layout
        $basePriceQuery = "SELECT price_per_night FROM room_types WHERE id = ?";
        $typeData = self::Fetch($basePriceQuery, $roomTypeId);
        $totalPriceValue = $typeData ? $typeData['price_per_night'] : 0.00;

        // Structured insert tracking map
        $bookingQuery = "INSERT INTO bookings (guest_id, room_id, room_type_id, checkin_date, checkout_date, num_guests, total_price, special_requests, status, source)
                         VALUES (?, ?, ?, ?, ?, 1, ?, '', 'checked_in', 'walk_in')";
        
        self::Execute($bookingQuery, $guestId, $roomId, $roomTypeId, $checkin, $checkout, $totalPriceValue);

        // Lock room usage constraints immediately matching your platform configuration standards
        return self::Execute("UPDATE rooms SET status='occupied' WHERE id = ?", $roomId);
    }
}
?>