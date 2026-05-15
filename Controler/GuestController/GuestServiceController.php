<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

if (!isset($_SESSION['user'])) { exit; }
$userId = $_SESSION['user']['id'];
$action = $_POST['action'] ?? '';

if ($action === 'request_service') {
    $bid = $_POST['booking_id'];
    $type = $_POST['service_type'];
    $desc = $_POST['description'];

    $sql = "INSERT INTO service_requests (booking_id, service_type, description, status) VALUES (?, ?, ?, 'pending')";
    $success = db::Execute($sql, $bid, $type, $desc);
    echo json_encode(['success' => $success, 'message' => $success ? 'Request Sent' : 'Error']);
}