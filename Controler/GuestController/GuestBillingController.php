<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

$userId = $_SESSION['user']['id'] ?? 0;

if (($_POST['action'] ?? '') === 'get_invoices') {
    $sql = "SELECT bl.*, rt.name as room_name FROM billing bl 
            JOIN bookings b ON bl.booking_id = b.id 
            JOIN room_types rt ON b.room_type_id = rt.id WHERE bl.guest_id = ?";
    $data = db::FetchAll($sql, $userId);
    echo json_encode(['success' => true, 'data' => $data ?: []]);
}