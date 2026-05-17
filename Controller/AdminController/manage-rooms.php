<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $data = db::FetchAll("SELECT r.id, r.room_number, rt.name as room_type, rt.id as room_type_id, r.floor, r.status, r.notes 
        FROM rooms r 
        INNER JOIN room_types rt ON r.room_type_id = rt.id ORDER BY r.room_number ASC");
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['room_id'] ?? '';
    $room_number = $_POST['room_number'] ?? '';
    $room_type_id = $_POST['room_type_id'] ?? '';
    $floor = $_POST['floor'] ?? 1;
    $status = $_POST['status'] ?? 'available';
    $notes = $_POST['notes'] ?? '';

    if ($id) {
        $success = db::Execute("UPDATE rooms SET room_number=?, room_type_id=?, floor=?, status=?, notes=? WHERE id=?", 
            $room_number, $room_type_id, $floor, $status, $notes, $id);
        echo json_encode(['success' => $success]);
    } else {
        $success = db::Execute("INSERT INTO rooms (room_number, room_type_id, floor, status, notes) VALUES (?, ?, ?, ?, ?)", 
            $room_number, $room_type_id, $floor, $status, $notes);
        echo json_encode(['success' => $success]);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM rooms WHERE id=?", $id);
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
