<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    if (request_action() !== 'summary') send_json(false, 'Invalid action.');
    $today = date('Y-m-d');

    $data = [
        'expected_checkins' => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkin_date=? AND status='confirmed'", $today),
        'expected_checkouts' => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkout_date=? AND status='checked_in'", $today),
        'checked_in_guests' => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE status='checked_in'"),
        'available_rooms' => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='available'"),
        'occupied_rooms' => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='occupied'"),
        'dirty_rooms' => db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='dirty'"),
        'pending_requests' => db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE status='pending'"),
        'today_revenue' => money(db::FetchValue("SELECT COALESCE(SUM(total_amount),0) FROM billing WHERE payment_status='paid' AND DATE(paid_at)=?", $today)),
        'available_by_type' => db::FetchAll("SELECT rt.name, COUNT(r.id) AS total FROM room_types rt LEFT JOIN rooms r ON r.room_type_id=rt.id AND r.status='available' GROUP BY rt.id, rt.name ORDER BY rt.name")
    ];
    send_json(true, 'Dashboard loaded successfully.', $data);
} catch (Exception $e) { send_json(false, $e->getMessage()); }
