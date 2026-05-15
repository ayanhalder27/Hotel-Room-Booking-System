<?php
session_start();
include("../Model/db.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["role"] != "housekeeping"){
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

header("Content-Type: application/json");

$action = $_POST["action"] ?? $_GET["action"] ?? "";

if($action == "task_history"){

    $room_id = intval($_POST["room_id"] ?? $_GET["room_id"] ?? 0);

    if($room_id){
        $rows = db::FetchAll(
            "SELECT ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.completed_at, r.room_number
             FROM housekeeping_tasks ht
             JOIN rooms r ON r.id = ht.room_id
             WHERE ht.room_id = ?
             ORDER BY ht.scheduled_date DESC
             LIMIT 100",
            $room_id
        );
    }
    else{
        $rows = db::FetchAll(
            "SELECT ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.completed_at, r.room_number
             FROM housekeeping_tasks ht
             JOIN rooms r ON r.id = ht.room_id
             ORDER BY ht.scheduled_date DESC
             LIMIT 200"
        );
    }

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown history action"]);
?>