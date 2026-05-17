<?php
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $search = $_GET['search'] ?? '';
    
    $query = "SELECT id, name, email, username, phone, nationality, national_id, profile_pic, is_active, created_at FROM users WHERE role='guest'";
    $params = [];
    
    if ($search) {
        $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
        $searchTerm = "%$search%";
        $params = [$searchTerm, $searchTerm, $searchTerm];
        // Note: db::FetchAll takes query and rest as variadic args
        $data = db::FetchAll($query, ...$params);
    } else {
        $data = db::FetchAll($query);
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $is_active = $_POST['is_active'] ?? 1;

    if ($id) {
        $success = db::Execute("UPDATE users SET is_active=? WHERE id=?", $is_active, $id);
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
