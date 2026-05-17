<?php
require_once '_rec_common.php';

try {
    $data = [
        // Booking stats
        'expected_checkins'   => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkin_date = CURDATE() AND status = 'confirmed'"),
        'expected_checkouts'  => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkout_date = CURDATE() AND status = 'checked_in'"),
        'checked_in_guests'   => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE status = 'checked_in'"),

        // Room stats
        'available_rooms'     => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'available'"),
        'occupied_rooms'      => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'occupied'"),
        'dirty_rooms'         => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status = 'dirty'"),

        // Service requests
        'pending_requests'    => db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE status = 'pending'"),

        // Revenue
        'revenue_today'       => db::FetchValue("SELECT COALESCE(SUM(total_amount),0) FROM billing WHERE payment_status = 'paid' AND DATE(paid_at) = CURDATE()"),

        // Rooms grouped by type
        'rooms_by_type'       => db::FetchAll("
            SELECT rt.name, COUNT(r.id) AS available_rooms
            FROM room_types rt
            LEFT JOIN rooms r 
              ON r.room_type_id = rt.id 
             AND r.status = 'available'
            GROUP BY rt.id, rt.name
            ORDER BY rt.name
        ")
    ];

    db::JsonResponse(true, 'Dashboard loaded', $data);

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
