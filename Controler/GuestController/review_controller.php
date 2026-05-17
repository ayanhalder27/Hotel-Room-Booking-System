<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'list');

    switch ($action) {
        /**
         * Completed Bookings (eligible for review)
         */
        case 'completed_bookings':
            $rows = db::FetchAll(
                "SELECT 
                    b.id,
                    rt.name AS room_type,
                    b.checkin_date,
                    b.checkout_date
                 FROM bookings b
                 JOIN room_types rt ON rt.id = b.room_type_id
                 WHERE b.guest_id = ?
                   AND b.status = 'checked_out'
                   AND b.id NOT IN (
                       SELECT booking_id 
                       FROM reviews 
                       WHERE guest_id = ?
                   )
                 ORDER BY b.id DESC",
                $guestId, $guestId
            );

            jsonResponse(true, 'Completed bookings loaded.', $rows);
            break;

        /**
         * List Reviews
         */
        case 'list':
            $rows = db::FetchAll(
                "SELECT 
                    r.*,
                    rt.name AS room_type,
                    b.checkin_date,
                    b.checkout_date
                 FROM reviews r
                 JOIN bookings b ON b.id = r.booking_id
                 JOIN room_types rt ON rt.id = b.room_type_id
                 WHERE r.guest_id = ?
                 ORDER BY r.id DESC",
                $guestId
            );

            jsonResponse(true, 'Reviews loaded.', $rows);
            break;

        /**
         * Create Review
         */
        case 'create':
            requiredFields(['booking_id','overall_rating','cleanliness_rating','service_rating','review_text']);
            $bookingId = (int)post('booking_id');

            $booking = db::Fetch(
                "SELECT id, status 
                 FROM bookings 
                 WHERE id = ? AND guest_id = ?",
                $bookingId, $guestId
            );

            if (!$booking || $booking['status'] !== 'checked_out') {
                throw new Exception('You can review only completed stays.');
            }

            $alreadyReviewed = (int)db::FetchValue(
                "SELECT COUNT(*) 
                 FROM reviews 
                 WHERE booking_id = ? AND guest_id = ?",
                $bookingId, $guestId
            );

            if ($alreadyReviewed > 0) {
                throw new Exception('You already reviewed this booking.');
            }

            db::Execute(
                "INSERT INTO reviews 
                    (booking_id, guest_id, overall_rating, cleanliness_rating, service_rating, review_text, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, NOW())",
                $bookingId,
                $guestId,
                (int)post('overall_rating'),
                (int)post('cleanliness_rating'),
                (int)post('service_rating'),
                post('review_text')
            );

            jsonResponse(true, 'Review submitted.');
            break;

        /**
         * Update Review
         */
        case 'update':
            requiredFields(['id','overall_rating','cleanliness_rating','service_rating','review_text']);

            db::Execute(
                "UPDATE reviews 
                 SET overall_rating = ?, cleanliness_rating = ?, service_rating = ?, review_text = ? 
                 WHERE id = ? AND guest_id = ?",
                (int)post('overall_rating'),
                (int)post('cleanliness_rating'),
                (int)post('service_rating'),
                post('review_text'),
                (int)post('id'),
                $guestId
            );

            jsonResponse(true, 'Review updated.');
            break;

        /**
         * Delete Review
         */
        case 'delete':
            requiredFields(['id']);

            db::Execute(
                "DELETE FROM reviews 
                 WHERE id = ? AND guest_id = ?",
                (int)post('id'),
                $guestId
            );

            jsonResponse(true, 'Review deleted.');
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
