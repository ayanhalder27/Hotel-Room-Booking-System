<?php
session_start();
include("../../Model/db.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["role"] != "housekeeping"){
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

header("Content-Type: application/json");

$action = $_GET["action"] ?? "";

if($action == "room_board"){

    $rooms = db::FetchAll(
        "SELECT r.id, r.room_number, r.floor, r.status, rt.name AS type_name
         FROM rooms r
         LEFT JOIN room_types rt ON rt.id = r.room_type_id
         ORDER BY r.floor ASC, r.room_number ASC"
    );

    echo json_encode(["success" => true, "rooms" => $rooms ?: []]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown room action"]);
?>