<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'guest') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']); exit;
}

$userId = $_SESSION['user']['id'];
$action = $_POST['action'] ?? '';

if ($action === 'load_dashboard') {
    $stats = [
        'upcoming_bookings' => db::FetchValue("SELECT COUNT(*) FROM bookings WHERE guest_id = $userId AND checkin_date >= CURDATE() AND status != 'cancelled'"),
        'total_spent' => db::FetchValue("SELECT SUM(total_amount) FROM billing WHERE guest_id = $userId AND payment_status = 'paid'") ?? 0,
        'loyalty_points' => db::FetchValue("SELECT total_balance FROM loyalty_balances WHERE guest_id = $userId") ?? 0,
        'pending_services' => db::FetchValue("SELECT COUNT(*) FROM service_requests sr JOIN bookings b ON sr.booking_id = b.id WHERE b.guest_id = $userId AND sr.status = 'pending'")
    ];

    $announcements = db::FetchAll("SELECT title, content, created_at FROM announcements WHERE expires_at > NOW() OR expires_at IS NULL ORDER BY created_at DESC LIMIT 5");

    echo json_encode(['success' => true, 'stats' => $stats, 'announcements' => $announcements ?: []]);
} 