<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $search = $_GET['search'] ?? '';
    
    $query = "SELECT id, name, email, username, phone, nationality, national_id, role, profile_pic, is_active, created_at 
              FROM users WHERE role IN ('admin', 'receptionist', 'housekeeping')";
    
    $data = db::FetchAll($query);
    
    // Quick filtering in PHP if needed, or we can just fetch all and let JS filter
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $is_active = $_POST['is_active'] ?? 1;
    $role = $_POST['role'] ?? ''; // Only allow updates to role if provided
    
    if ($id) {
        if ($role) {
            $success = db::Execute("UPDATE users SET is_active=?, role=? WHERE id=?", $is_active, $role, $id);
        } else {
            $success = db::Execute("UPDATE users SET is_active=? WHERE id=?", $is_active, $id);
        }
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No ID provided']);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM users WHERE id=?", $id);
            echo json_encode(['success' => $success]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No ID provided']);
    }
    exit;
}
?>
