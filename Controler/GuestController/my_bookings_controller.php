<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'list');

    switch ($action) {
        /**
         * List Bookings
         */
        case 'list':
            $filter = post('filter', 'all');
            $search = post('q');

            $sql = "
                SELECT 
                    b.id,
                    rt.name AS room_type,
                    r.room_number,
                    b.checkin_date,
                    b.checkout_date,
                    b.num_guests,
                    b.total_price,
                    b.status,
                    b.created_at
                FROM bookings b
                JOIN room_types rt ON rt.id = b.room_type_id
                LEFT JOIN rooms r ON r.id = b.room_id
                WHERE b.guest_id = ?
            ";
            $params = [$guestId];

            // Apply filter
            if ($filter === 'upcoming') {
                $sql .= " AND b.status IN ('pending','confirmed') AND b.checkin_date >= CURDATE()";
            } elseif ($filter === 'past') {
                $sql .= " AND (b.status IN ('checked_out','cancelled') OR b.checkout_date < CURDATE())";
            } elseif ($filter !== 'all' && $filter !== '') {
                $sql .= " AND b.status = ?";
                $params[] = $filter;
            }

            // Apply search
            if ($search !== '') {
                $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR rt.name LIKE ? OR b.status LIKE ?)";
                $params[] = likeQ($search);
                $params[] = likeQ($search);
                $params[] = likeQ($search);
            }

            $sql .= " ORDER BY b.id DESC";

            $rows = db::FetchAll($sql, ...$params);
            jsonResponse(true, 'Bookings loaded.', $rows);
            break;

        /**
         * Booking Details
         */
        case 'details':
            $bookingId = (int)post('booking_id');
            if (!$bookingId || !guestOwnsBooking($bookingId, $guestId)) {
                throw new Exception('Booking not found.');
            }

            $booking = db::Fetch(
                "SELECT 
                    b.*,
                    rt.name AS room_type,
                    rt.description,
                    r.room_number,
                    r.floor
                 FROM bookings b
                 JOIN room_types rt ON rt.id = b.room_type_id
                 LEFT JOIN rooms r ON r.id = b.room_id
                 WHERE b.id = ? AND b.guest_id = ?",
                $bookingId, $guestId
            );

            $bill = db::Fetch("SELECT * FROM billing WHERE booking_id = ?", $bookingId);
            $requests = db::FetchAll("SELECT * FROM service_requests WHERE booking_id = ? ORDER BY id DESC", $bookingId);

            jsonResponse(true, 'Booking details loaded.', [
                'booking'         => $booking,
                'billing'         => $bill,
                'service_requests'=> $requests
            ]);
            break;

        /**
         * Cancel Booking
         */
        case 'cancel':
            requiredFields(['booking_id']);
            $bookingId = (int)post('booking_id');

            $booking = db::Fetch(
                "SELECT id, status, checkin_date 
                 FROM bookings 
                 WHERE id = ? AND guest_id = ?",
                $bookingId, $guestId
            );

            if (!$booking) {
                throw new Exception('Booking not found.');
            }
            if (!in_array($booking['status'], ['pending','confirmed'])) {
                throw new Exception('Only pending or confirmed bookings can be cancelled.');
            }
            if (strtotime($booking['checkin_date']) <= strtotime(date('Y-m-d'))) {
                throw new Exception('Same-day or past bookings cannot be cancelled.');
            }

            db::Execute("UPDATE bookings SET status = 'cancelled' WHERE id = ? AND guest_id = ?", $bookingId, $guestId);
            jsonResponse(true, 'Booking cancelled successfully.');
            break;

        /**
         * Request Modification
         */
        case 'request_modification':
            requiredFields(['booking_id','new_checkin_date','new_checkout_date']);
            $bookingId = (int)post('booking_id');

            validDateRange(post('new_checkin_date'), post('new_checkout_date'));

            if (!guestOwnsBooking($bookingId, $guestId)) {
                throw new Exception('Booking not found.');
            }

            db::Execute(
                "INSERT INTO service_requests 
                    (booking_id, guest_id, room_id, service_type, description, status, requested_at) 
                 SELECT 
                    id, guest_id, room_id, 'other', ?, 'pending', NOW() 
                 FROM bookings 
                 WHERE id = ? AND guest_id = ?",
                'Booking modification requested: ' . post('new_checkin_date') . ' to ' . post('new_checkout_date') . '. ' . post('notes'),
                $bookingId, $guestId
            );

            jsonResponse(true, 'Modification request sent to receptionist.');
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
