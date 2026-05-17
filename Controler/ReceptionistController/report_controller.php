<?php
require_once '_rec_common.php';

try {
    $data = [
        // Guest flow
        'arrivals'          => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkin_date = CURDATE() AND status IN('confirmed','checked_in')"),
        'departures'        => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkout_date = CURDATE() AND status IN('checked_in','checked_out')"),
        'walkins'           => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE source = 'walk_in' AND DATE(created_at) = CURDATE()"),

        // Revenue
        'revenue'           => db::FetchValue("SELECT COALESCE(SUM(total_amount),0) FROM billing WHERE payment_status = 'paid' AND DATE(paid_at) = CURDATE()"),

        // Room status
        'occupied'          => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'occupied'"),
        'available'         => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'available'"),
        'dirty'             => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'dirty'"),

        // Service requests
        'pending_requests'  => db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE status = 'pending'")
    ];

    db::JsonResponse(true, 'Report loaded', $data);

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
