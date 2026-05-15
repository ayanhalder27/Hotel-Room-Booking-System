<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

$userId = $_SESSION['user']['id'] ?? 0;
$action = $_POST['action'] ?? '';

if ($action === 'submit_review') {
    $sql = "INSERT INTO reviews (booking_id, guest_id, overall_rating, review_text) VALUES (?, ?, ?, ?)";
    $success = db::Execute($sql, $_POST['booking_id'], $userId, $_POST['rating'], $_POST['comment']);
    echo json_encode(['success' => $success]);
}