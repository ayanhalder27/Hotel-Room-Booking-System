<?php
session_start();
include("../Model/db.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["role"] != "housekeeping"){
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

header("Content-Type: application/json");

$action = $_GET["action"] ?? "";

if($action == "schedule"){

    $today_checkouts = db::FetchAll(
        "SELECT b.checkout_date, r.room_number, r.status AS room_status, u.name AS guest_name
         FROM bookings b
         JOIN rooms r ON r.id = b.room_id
         JOIN users u ON u.id = b.guest_id
         WHERE b.status = 'checked_in'
         AND DATE(b.checkout_date) = CURDATE()
         ORDER BY b.checkout_date ASC"
    );

    $tomorrow_checkouts = db::FetchAll(
        "SELECT b.checkout_date, r.room_number, r.status AS room_status, u.name AS guest_name
         FROM bookings b
         JOIN rooms r ON r.id = b.room_id
         JOIN users u ON u.id = b.guest_id
         WHERE b.status = 'checked_in'
         AND DATE(b.checkout_date) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
         ORDER BY b.checkout_date ASC"
    );

    $upcoming_checkins = db::FetchAll(
        "SELECT b.checkin_date, r.room_number, r.status AS room_status, u.name AS guest_name
         FROM bookings b
         JOIN rooms r ON r.id = b.room_id
         JOIN users u ON u.id = b.guest_id
         WHERE b.status IN ('confirmed','pending')
         AND DATE(b.checkin_date) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 2 DAY)
         ORDER BY b.checkin_date ASC"
    );

    echo json_encode([
        "success" => true,
        "today_checkouts" => $today_checkouts ?: [],
        "tomorrow_checkouts" => $tomorrow_checkouts ?: [],
        "upcoming_checkins" => $upcoming_checkins ?: []
    ]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown schedule action"]);
?>