<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = "SELECT sr.id, sr.booking_id, sr.service_type, sr.description, sr.status, sr.requested_at, sr.completed_at,
        u.name as guest_name, r.room_number 
        FROM service_requests sr
        INNER JOIN users u ON sr.guest_id = u.id
        LEFT JOIN rooms r ON sr.room_id = r.id
        ORDER BY sr.requested_at DESC";
    
    $data = db::FetchAll($query);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? 'pending';
    
    if ($id) {
        $completed_at = ($status === 'completed') ? date('Y-m-d H:i:s') : null;
        if ($completed_at) {
            $success = db::Execute("UPDATE service_requests SET status=?, completed_at=? WHERE id=?", $status, $completed_at, $id);
        } else {
            $success = db::Execute("UPDATE service_requests SET status=?, completed_at=NULL WHERE id=?", $status, $id);
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
            $success = db::Execute("DELETE FROM service_requests WHERE id=?", $id);
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
