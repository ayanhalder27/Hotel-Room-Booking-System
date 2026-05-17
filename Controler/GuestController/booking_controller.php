<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'create');

    switch ($action) {
        /**
         * Create a new booking.
         */
        case 'create':
            requiredFields(['room_type_id', 'checkin_date', 'checkout_date', 'num_guests']);

            $roomTypeId = (int)post('room_type_id');
            $checkin    = post('checkin_date');
            $checkout   = post('checkout_date');
            $numGuests  = (int)post('num_guests');

            validDateRange($checkin, $checkout);

            // Validate room type and capacity
            $capacityCol = roomCapacityColumn();
            $roomType = db::Fetch(
                "SELECT id, name, price_per_night, $capacityCol AS capacity 
                 FROM room_types 
                 WHERE id = ?",
                $roomTypeId
            );

            if (!$roomType) {
                throw new Exception('Room type not found.');
            }
            if ($numGuests > (int)$roomType['capacity']) {
                throw new Exception('Guest count exceeds room capacity.');
            }

            // Check availability
            if (availableRoomCount($roomTypeId, $checkin, $checkout) <= 0) {
                throw new Exception('No available room for selected dates.');
            }

            // Calculate price
            $nights = nightsBetween($checkin, $checkout);
            $price  = seasonalPrice($roomTypeId, $checkin, $checkout);
            $total  = $price['price'] * $nights;

            // Insert booking
            db::BeginTransaction();
            $columns = ['guest_id', 'room_id', 'room_type_id', 'checkin_date', 'checkout_date', 'num_guests', 'total_price', 'status'];
            $placeholders = ['?', '?', '?', '?', '?', '?', '?', '?'];
            $values = [$guestId, null, $roomTypeId, $checkin, $checkout, $numGuests, $total, 'pending'];

            if (bookingSourceColumnExists()) {
                $columns[] = 'source';
                $placeholders[] = '?';
                $values[] = 'online';
            }

            if (bookingSpecialRequestColumnExists()) {
                $columns[] = 'special_requests';
                $placeholders[] = '?';
                $values[] = post('special_requests');
            }

            if (columnExists('bookings', 'created_at')) {
                $columns[] = 'created_at';
                $placeholders[] = 'NOW()';
            }

            db::Execute(
                'INSERT INTO bookings (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')',
                ...$values
            );
            $bookingId = db::InsertId();

            // Insert billing
            if (billingGuestColumnExists()) {
                db::Execute(
                    "INSERT INTO billing (booking_id, guest_id, base_amount, extras_amount, discount_amount, total_amount, payment_status) 
                     VALUES (?, ?, ?, 0, 0, ?, 'pending')",
                    $bookingId, $guestId, $total, $total
                );
            } else {
                db::Execute(
                    "INSERT INTO billing (booking_id, base_amount, extras_amount, discount_amount, total_amount, payment_status) 
                     VALUES (?, ?, 0, 0, ?, 'pending')",
                    $bookingId, $total, $total
                );
            }

            db::Commit();

            jsonResponse(true, 'Booking created successfully.', [
                'booking_id'   => $bookingId,
                'room_type'    => $roomType['name'],
                'checkin_date' => $checkin,
                'checkout_date'=> $checkout,
                'total_price'  => $total
            ]);
            break;

        /**
         * Load booking confirmation.
         */
        case 'confirmation':
            $bookingId = (int)reqv('booking_id', '0');
            if ($bookingId <= 0 || !guestOwnsBooking($bookingId, $guestId)) {
                throw new Exception('Booking not found.');
            }

            $booking = db::Fetch(
                "SELECT 
                    b.id,
                    b.checkin_date,
                    b.checkout_date,
                    b.num_guests,
                    b.total_price,
                    b.status,
                    rt.name AS room_type
                 FROM bookings b
                 JOIN room_types rt ON rt.id = b.room_type_id
                 WHERE b.id = ? AND b.guest_id = ?",
                $bookingId, $guestId
            );

            jsonResponse(true, 'Booking confirmation loaded.', $booking);
            break;

        /**
         * Default case for invalid actions.
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
