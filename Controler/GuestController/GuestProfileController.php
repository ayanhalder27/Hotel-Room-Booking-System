<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

if (!isset($_SESSION['user'])) { echo json_encode(['success' => false]); exit; }
$userId = $_SESSION['user']['id'];
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'get_profile':
        $user = db::Fetch("SELECT name, email, phone, nationality, national_id FROM users WHERE id = ?", $userId);
        echo json_encode(['success' => true, 'data' => $user]);
        break;
    case 'update_profile':
        $success = db::Execute("UPDATE users SET name = ?, phone = ?, nationality = ? WHERE id = ?", $_POST['name'], $_POST['phone'], $_POST['nationality'], $userId);
        if($success) $_SESSION['user']['name'] = $_POST['name'];
        echo json_encode(['success' => $success, 'message' => $success ? 'Profile Updated' : 'Update Failed']);
        break;
}