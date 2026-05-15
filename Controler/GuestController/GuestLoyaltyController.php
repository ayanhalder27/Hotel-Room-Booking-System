<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

$userId = $_SESSION['user']['id'] ?? 0;

if (($_POST['action'] ?? '') === 'get_loyalty_data') {
    $balance = db::FetchValue("SELECT total_balance FROM loyalty_balances WHERE guest_id = $userId") ?? 0;
    $history = db::FetchAll("SELECT * FROM loyalty_points WHERE guest_id = ? ORDER BY created_at DESC", $userId);
    echo json_encode(['success' => true, 'balance' => $balance, 'history' => $history ?: []]);
}