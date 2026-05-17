<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    // Handle listing bookings
    $query = "SELECT b.id, b.checkin_date, b.checkout_date, b.num_guests, b.total_price, b.status, b.source, b.created_at, b.special_requests,
        u.name as guest_name, u.phone as guest_phone,
        rt.name as room_type,
        r.room_number
        FROM bookings b
        INNER JOIN users u ON b.guest_id = u.id
        INNER JOIN room_types rt ON b.room_type_id = rt.id
        LEFT JOIN rooms r ON b.room_id = r.id
        ORDER BY b.created_at DESC";
    
    $data = db::FetchAll($query);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $guest_id = $_POST['guest_id'] ?? '';
    $source = $_POST['source'] ?? 'online';
    $room_type_id = $_POST['room_type_id'] ?? '';
    $room_id = empty($_POST['room_id']) ? null : $_POST['room_id'];
    $checkin_date = $_POST['checkin_date'] ?? '';
    $checkout_date = $_POST['checkout_date'] ?? '';
    $num_guests = $_POST['num_guests'] ?? 1;
    $status = $_POST['status'] ?? 'pending';
    $total_price = $_POST['total_price'] ?? 0;
    $special_requests = $_POST['special_requests'] ?? '';

    if ($id) {
        $success = db::Execute("UPDATE bookings SET guest_id=?, source=?, room_type_id=?, room_id=?, checkin_date=?, checkout_date=?, num_guests=?, status=?, total_price=?, special_requests=? WHERE id=?", 
            $guest_id, $source, $room_type_id, $room_id, $checkin_date, $checkout_date, $num_guests, $status, $total_price, $special_requests, $id);
        echo json_encode(['success' => $success]);
    } else {
        $success = db::Execute("INSERT INTO bookings (guest_id, source, room_type_id, room_id, checkin_date, checkout_date, num_guests, status, total_price, special_requests) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", 
            $guest_id, $source, $room_type_id, $room_id, $checkin_date, $checkout_date, $num_guests, $status, $total_price, $special_requests);
        echo json_encode(['success' => $success]);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM bookings WHERE id=?", $id);
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
