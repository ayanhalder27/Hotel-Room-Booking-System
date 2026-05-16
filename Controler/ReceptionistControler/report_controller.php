<?php
require_once __DIR__ . '/_rec_common.php';

try {
    if (rec_Controler_action() !== 'daily_report') rec_json(false, 'Invalid report action.', [], 400);
    $date = rec_date(rec_input('date', date('Y-m-d')), 'Report date');

    $data = [
        'arrivals' => (int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkin_date=? AND status IN ('confirmed','checked_in','checked_out')", $date),
        'departures' => (int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE checkout_date=? AND status IN ('checked_in','checked_out')", $date),
        'walkins' => (int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE DATE(created_at)=? AND source='walk_in'", $date),
        'revenue' => (float)db::FetchValue("SELECT COALESCE(SUM(total_amount),0) FROM billing WHERE payment_status='paid' AND DATE(paid_at)=?", $date),
        'occupied_rooms' => (int)db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='occupied'"),
        'available_rooms' => (int)db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='available'"),
        'dirty_rooms' => (int)db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='dirty'"),
        'maintenance_rooms' => (int)db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='maintenance'"),
        'pending_service_requests' => (int)db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE status='pending'"),
        'completed_service_requests' => (int)db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE status='completed' AND DATE(completed_at)=?", $date),
        'pending_bills' => (int)db::FetchValue("SELECT COUNT(*) FROM billing WHERE payment_status='pending'"),
        'paid_bills_today' => (int)db::FetchValue("SELECT COUNT(*) FROM billing WHERE payment_status='paid' AND DATE(paid_at)=?", $date)
    ];
    rec_json(true, 'Daily report generated.', $data);
} catch (Exception $e) {
    rec_json(false, $e->getMessage(), [], 500);
}
?>
