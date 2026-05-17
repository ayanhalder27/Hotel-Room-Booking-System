<?php
require_once '_guest_common.php';

wrapController(function () {
    $action = reqv('action', 'details');

    switch ($action) {
        /**
         * Room Type Details
         */
        case 'details':
            $roomTypeId = (int)reqv('room_type_id', reqv('id', '0'));
            if ($roomTypeId <= 0) {
                throw new Exception('Room type is required.');
            }

            $capacityCol = roomCapacityColumn();

            // Fetch room type info
            $roomType = db::Fetch(
                "SELECT 
                    id,
                    name,
                    description,
                    price_per_night,
                    $capacityCol AS capacity,
                    thumbnail_path,
                    amenities
                 FROM room_types 
                 WHERE id = ?",
                $roomTypeId
            );

            if (!$roomType) {
                throw new Exception('Room type not found.');
            }

            // Aggregate ratings
            $ratings = db::Fetch(
                "SELECT 
                    ROUND(AVG(overall_rating),1) AS overall,
                    ROUND(AVG(cleanliness_rating),1) AS cleanliness,
                    ROUND(AVG(service_rating),1) AS service,
                    COUNT(*) AS total_reviews
                 FROM reviews r
                 JOIN bookings b ON b.id = r.booking_id
                 WHERE b.room_type_id = ?",
                $roomTypeId
            );

            // Recent reviews
            $reviews = db::FetchAll(
                "SELECT 
                    r.overall_rating,
                    r.cleanliness_rating,
                    r.service_rating,
                    r.review_text,
                    r.admin_reply,
                    r.created_at,
                    u.name AS guest_name
                 FROM reviews r
                 JOIN users u ON u.id = r.guest_id
                 JOIN bookings b ON b.id = r.booking_id
                 WHERE b.room_type_id = ?
                 ORDER BY r.id DESC 
                 LIMIT 10",
                $roomTypeId
            );

            // Seasonal pricing
            $seasonalPricing = db::FetchAll(
                "SELECT 
                    label,
                    start_date,
                    end_date,
                    price_per_night
                 FROM seasonal_pricing 
                 WHERE room_type_id = ?
                 ORDER BY start_date ASC",
                $roomTypeId
            );

            jsonResponse(true, 'Room details loaded.', [
                'room_type'       => $roomType,
                'ratings'         => $ratings,
                'reviews'         => $reviews,
                'seasonal_pricing'=> $seasonalPricing
            ]);
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
