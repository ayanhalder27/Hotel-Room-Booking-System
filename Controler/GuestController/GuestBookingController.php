<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

if (!isset($_SESSION['user'])) { exit; }
$userId = $_SESSION['user']['id'];
$action = $_POST['action'] ?? '';

if ($action === 'create_booking') {
    $rt_id = $_POST['room_type_id'];
    $in = $_POST['checkin'];
    $out = $_POST['checkout'];
    
    $room = db::Fetch("SELECT id, price_per_night FROM room_types WHERE id = ?", $rt_id);
    $days = (strtotime($out) - strtotime($in)) / 86400;
    $total = $room['price_per_night'] * $days;

    $sql = "INSERT INTO bookings (guest_id, room_type_id, checkin_date, checkout_date, total_price, status) VALUES (?, ?, ?, ?, ?, 'pending')";
    $success = db::Execute($sql, $userId, $rt_id, $in, $out, $total);
    
    if ($success) {
        $bid = db::FetchValue("SELECT LAST_INSERT_ID()");
        db::Execute("INSERT INTO billing (booking_id, guest_id, total_amount, payment_status) VALUES (?, ?, ?, 'unpaid')", $bid, $userId, $total);
        echo json_encode(['success' => true, 'booking_id' => $bid]);
    } else {
        echo json_encode(['success' => false]);
    }
}