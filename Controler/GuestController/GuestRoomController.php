<?php
session_start();
header('Content-Type: application/json');
require_once('../../Model/db.php');

$action = $_POST['action'] ?? '';

if ($action === 'search_rooms') {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guests = (int)$_POST['guests'];

    // Find room types that have at least one physical room not booked in those dates
    $query = "SELECT rt.* FROM room_types rt WHERE rt.max_capacity >= ? AND rt.id IN (
                SELECT r.room_type_id FROM rooms r WHERE r.status = 'available' AND r.id NOT IN (
                    SELECT b.room_id FROM bookings b WHERE b.status != 'cancelled' 
                    AND NOT (b.checkout_date <= ? OR b.checkin_date >= ?)
                )
              )";
    
    $rooms = db::FetchAll($query, $guests, $checkin, $checkout);
    echo json_encode(['success' => true, 'rooms' => $rooms ?: []]);
}