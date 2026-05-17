<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'stats');

    switch ($action) {
        /**
         * Guest Dashboard Stats
         */
        case 'stats':
            // Collect summary statistics
            $stats = [
                'upcoming_bookings' => (int)db::FetchValue(
                    "SELECT COUNT(*) 
                     FROM bookings 
                     WHERE guest_id = ? 
                       AND status IN ('pending','confirmed') 
                       AND checkin_date >= CURDATE()",
                    $guestId
                ),
                'active_stays' => (int)db::FetchValue(
                    "SELECT COUNT(*) 
                     FROM bookings 
                     WHERE guest_id = ? 
                       AND status = 'checked_in'",
                    $guestId
                ),
                'completed_stays' => (int)db::FetchValue(
                    "SELECT COUNT(*) 
                     FROM bookings 
                     WHERE guest_id = ? 
                       AND status = 'checked_out'",
                    $guestId
                ),
                'pending_requests' => (int)db::FetchValue(
                    "SELECT COUNT(*) 
                     FROM service_requests 
                     WHERE guest_id = ? 
                       AND status IN ('pending','in_progress')",
                    $guestId
                ),
                'loyalty_balance' => (int)db::FetchValue(
                    "SELECT COALESCE(balance,0) 
                     FROM loyalty_points 
                     WHERE guest_id = ? 
                     ORDER BY id DESC LIMIT 1",
                    $guestId
                ),
                'unpaid_bills' => (int)db::FetchValue(
                    "SELECT COUNT(*) 
                     FROM billing 
                     WHERE booking_id IN (
                         SELECT id FROM bookings WHERE guest_id = ?
                     ) 
                       AND payment_status IN ('pending','unpaid')",
                    $guestId
                )
            ];

            // Fetch recent bookings
            $recentBookings = db::FetchAll(
                "SELECT 
                    b.id,
                    rt.name AS room_type,
                    b.checkin_date,
                    b.checkout_date,
                    b.status,
                    b.total_price
                 FROM bookings b
                 JOIN room_types rt ON rt.id = b.room_type_id
                 WHERE b.guest_id = ?
                 ORDER BY b.id DESC 
                 LIMIT 6",
                $guestId
            );

            jsonResponse(true, 'Dashboard loaded.', [
                'stats'           => $stats,
                'recent_bookings' => $recentBookings
            ]);
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
