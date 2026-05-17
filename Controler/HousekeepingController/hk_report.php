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

if($action == "daily_report"){

    $rows = db::FetchAll(
        "SELECT ht.task_type, ht.priority, ht.status, ht.notes, ht.completed_at, r.room_number
         FROM housekeeping_tasks ht
         JOIN rooms r ON r.id = ht.room_id
         WHERE DATE(ht.scheduled_date) = CURDATE()
         ORDER BY ht.status ASC, ht.priority DESC"
    );

    $all = $rows ?: [];

    $done = 0;
    $pending = 0;

    foreach($all as $row){
        if($row["status"] == "done"){
            $done++;
        }
        else{
            $pending++;
        }
    }

    $ready = db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='available'");

    echo json_encode([
        "success" => true,
        "total" => count($all),
        "done" => $done,
        "pending" => $pending,
        "ready" => (int)$ready,
        "rows" => $all
    ]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown report action"]);
?>
