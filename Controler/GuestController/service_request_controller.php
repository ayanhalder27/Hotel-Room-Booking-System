<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'list');

    switch ($action) {
        /**
         * Active Bookings (eligible for service requests)
         */
        case 'active_bookings':
            $rows = db::FetchAll(
                "SELECT 
                    b.id,
                    rt.name AS room_type,
                    r.room_number
                 FROM bookings b
                 JOIN room_types rt ON rt.id = b.room_type_id
                 LEFT JOIN rooms r ON r.id = b.room_id
                 WHERE b.guest_id = ? 
                   AND b.status = 'checked_in'
                 ORDER BY b.id DESC",
                $guestId
            );

            jsonResponse(true, 'Active bookings loaded.', $rows);
            break;

        /**
         * List Service Requests
         */
        case 'list':
            $search = post('q');
            $sql = "
                SELECT 
                    sr.*,
                    r.room_number,
                    rt.name AS room_type
                FROM service_requests sr
                JOIN bookings b ON b.id = sr.booking_id
                LEFT JOIN rooms r ON r.id = sr.room_id
                LEFT JOIN room_types rt ON rt.id = b.room_type_id
                WHERE sr.guest_id = ?
            ";
            $params = [$guestId];

            if ($search !== '') {
                $sql .= " AND (sr.service_type LIKE ? OR sr.description LIKE ? OR sr.status LIKE ?)";
                $params[] = likeQ($search);
                $params[] = likeQ($search);
                $params[] = likeQ($search);
            }

            $sql .= " ORDER BY sr.id DESC";

            $rows = db::FetchAll($sql, ...$params);
            jsonResponse(true, 'Service requests loaded.', $rows);
            break;

        /**
         * Create Service Request
         */
        case 'create':
            requiredFields(['booking_id','service_type','description']);
            $bookingId = (int)post('booking_id');

            $booking = db::Fetch(
                "SELECT id, guest_id, room_id, status 
                 FROM bookings 
                 WHERE id = ? AND guest_id = ?",
                $bookingId, $guestId
            );

            if (!$booking) {
                throw new Exception('Booking not found.');
            }
            if ($booking['status'] !== 'checked_in') {
                throw new Exception('Service requests are allowed only during active stay.');
            }

            db::Execute(
                "INSERT INTO service_requests 
                    (booking_id, guest_id, room_id, service_type, description, status, requested_at) 
                 VALUES (?, ?, ?, ?, ?, 'pending', NOW())",
                $bookingId,
                $guestId,
                $booking['room_id'],
                post('service_type'),
                post('description')
            );

            jsonResponse(true, 'Service request submitted.');
            break;

        /**
         * Delete Pending Request
         */
        case 'delete':
            requiredFields(['id']);

            db::Execute(
                "DELETE FROM service_requests 
                 WHERE id = ? AND guest_id = ? AND status = 'pending'",
                (int)post('id'),
                $guestId
            );

            jsonResponse(true, 'Pending request deleted.');
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
