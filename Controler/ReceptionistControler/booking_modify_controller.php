<?php
require_once __DIR__ . '/_rec_common.php';

function rec_booking_available($bookingId, $roomTypeId, $checkin, $checkout) {
    $totalRooms = (int)db::FetchValue("SELECT COUNT(*) FROM rooms WHERE room_type_id=? AND status NOT IN ('maintenance','blocked')", $roomTypeId);
    $overlapBookings = (int)db::FetchValue("SELECT COUNT(*) FROM bookings
        WHERE id<>? AND room_type_id=? AND status IN ('confirmed','checked_in')
        AND checkin_date < ? AND checkout_date > ?", $bookingId, $roomTypeId, $checkout, $checkin);
    return max(0, $totalRooms - $overlapBookings);
}

function rec_calculate_price($roomTypeId, $checkin, $checkout) {
    $nights = rec_days_between($checkin, $checkout);
    $roomType = db::Fetch("SELECT price_per_night FROM room_types WHERE id=?", $roomTypeId);
    if (!$roomType) throw new Exception('Room type not found.');
    $seasonal = db::Fetch("SELECT price_per_night FROM seasonal_pricing WHERE room_type_id=? AND ? >= start_date AND ? < end_date ORDER BY id DESC LIMIT 1", $roomTypeId, $checkin, $checkin);
    $price = $seasonal ? (float)$seasonal['price_per_night'] : (float)$roomType['price_per_night'];
    return $price * $nights;
}

try {
    $action = rec_Controler_action();

    if ($action === 'search') {
        $q = rec_input('q');
        rec_required($q, 'Search text');
        $rows = db::FetchAll("SELECT b.id, u.name AS guest_name, rt.name AS room_type, b.room_type_id, b.checkin_date, b.checkout_date, b.num_guests, b.status
            FROM bookings b
            JOIN users u ON u.id=b.guest_id
            JOIN room_types rt ON rt.id=b.room_type_id
            WHERE b.status IN ('pending','confirmed','checked_in') AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR u.phone LIKE ? OR u.national_id LIKE ?)
            ORDER BY b.created_at DESC", rec_like($q), rec_like($q), rec_like($q), rec_like($q));
        rec_json(true, 'Bookings loaded.', $rows);
    }

    if ($action === 'check_availability' || $action === 'update_booking') {
        $bookingId = rec_int(rec_input('booking_id'), 'Booking ID');
        $checkin = rec_date(rec_input('checkin_date'), 'Check-in date');
        $checkout = rec_date(rec_input('checkout_date'), 'Checkout date');
        $numGuests = rec_int(rec_input('num_guests'), 'Number of guests');
        $requestType = rec_input('request_type', 'normal_modify');
        rec_days_between($checkin, $checkout);

        $booking = db::Fetch("SELECT b.*, rt.max_capacity FROM bookings b JOIN room_types rt ON rt.id=b.room_type_id WHERE b.id=?", $bookingId);
        if (!$booking) throw new Exception('Booking not found.');
        if (!in_array($booking['status'], ['pending','confirmed','checked_in'], true)) throw new Exception('This booking cannot be modified.');
        if ($numGuests > (int)$booking['max_capacity']) throw new Exception('Number of guests exceeds room capacity.');

        if ($requestType === 'late_checkout' && $booking['status'] === 'checked_in' && !empty($booking['room_id'])) {
            $conflict = db::FetchValue("SELECT COUNT(*) FROM bookings WHERE id<>? AND room_id=? AND status IN ('confirmed','checked_in') AND checkin_date < ? AND checkout_date > ?", $bookingId, (int)$booking['room_id'], $checkout, $checkin);
            if ((int)$conflict > 0) throw new Exception('Late checkout cannot be approved because the assigned room has another booking conflict.');
        } else {
            $available = rec_booking_available($bookingId, (int)$booking['room_type_id'], $checkin, $checkout);
            if ($available < 1) throw new Exception('No room is available for the selected date range.');
        }

        if ($action === 'check_availability') {
            rec_json(true, 'Room availability confirmed for this modification.');
        }

        $newPrice = rec_calculate_price((int)$booking['room_type_id'], $checkin, $checkout);
        db::BeginTransaction();
        try {
            db::Execute("UPDATE bookings SET checkin_date=?, checkout_date=?, num_guests=?, total_price=? WHERE id=?", $checkin, $checkout, $numGuests, $newPrice, $bookingId);
            db::Execute("UPDATE billing SET base_amount=? WHERE booking_id=? AND payment_status='pending'", $newPrice, $bookingId);
            db::Commit();
        } catch (Exception $e) {
            db::Rollback();
            throw $e;
        }
        rec_json(true, 'Booking updated successfully.', ['new_total_price' => $newPrice]);
    }

    rec_json(false, 'Invalid booking modification action.', [], 400);
} catch (Exception $e) {
    rec_json(false, $e->getMessage(), [], 500);
}
?>
