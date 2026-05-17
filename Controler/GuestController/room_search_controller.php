<?php
require_once '_guest_common.php';

wrapController(function () {
    $action = reqv('action', 'search');

    switch ($action) {
        /**
         * Search Available Room Types
         */
        case 'search':
            $checkin  = post('checkin_date');
            $checkout = post('checkout_date');
            $guests   = (int)post('num_guests', '1');

            // Validate input
            validDateRange($checkin, $checkout);
            if ($guests < 1) {
                throw new Exception('Guest number must be valid.');
            }

            $capacityCol = roomCapacityColumn();

            // Fetch room types that can accommodate the guest count
            $roomTypes = db::FetchAll(
                "SELECT 
                    id,
                    name,
                    description,
                    price_per_night,
                    $capacityCol AS capacity,
                    thumbnail_path,
                    amenities
                 FROM room_types 
                 WHERE $capacityCol >= ? 
                 ORDER BY price_per_night ASC",
                $guests
            );

            $results = [];
            $nights  = nightsBetween($checkin, $checkout);

            foreach ($roomTypes as $type) {
                $available = availableRoomCount((int)$type['id'], $checkin, $checkout);
                if ($available <= 0) {
                    continue;
                }

                $seasonal = seasonalPrice((int)$type['id'], $checkin, $checkout);

                $type['available_rooms'] = $available;
                $type['nightly_price']   = $seasonal['price'];
                $type['nights']          = $nights;
                $type['estimated_total'] = $seasonal['price'] * $nights;
                $type['seasonal_notice'] = $seasonal['seasonal']
                    ? ($seasonal['seasonal']['label'] . ' price applied')
                    : '';

                $results[] = $type;
            }

            jsonResponse(true, 'Available room types loaded.', $results);
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
