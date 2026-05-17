<?php
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = "SELECT r.id, r.overall_rating as rating, r.review_text as comment, r.status, r.created_at, u.name as guest_name, rm.room_number
              FROM reviews r
              INNER JOIN users u ON r.guest_id = u.id
              INNER JOIN bookings b ON r.booking_id = b.id
              LEFT JOIN rooms rm ON b.room_id = rm.id
              ORDER BY r.created_at DESC";
    
    $data = db::FetchAll($query);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $status = $_POST['status'] ?? '';
    
    if ($id && $status) {
        $success = db::Execute("UPDATE reviews SET status=? WHERE id=?", $status, $id);
        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing ID or status']);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM reviews WHERE id=?", $id);
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
