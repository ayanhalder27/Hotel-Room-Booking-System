<?php
session_start();
include("../../Model/db.php");

if(!isset($_SESSION["user_id"]) || $_SESSION["role"] != "housekeeping"){
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit();
}

header("Content-Type: application/json");

$action = $_POST["action"] ?? $_GET["action"] ?? "";
$supervisor_id = $_SESSION["user_id"];

if($action == "create_task"){

    $room_id = intval($_POST["room_id"] ?? 0);
    $task_type = $_POST["task_type"] ?? "";
    $priority = $_POST["priority"] ?? "normal";
    $notes = trim($_POST["notes"] ?? "");
    $scheduled_date = $_POST["scheduled_date"] ?? date("Y-m-d");

    if(!$room_id || !$task_type){
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit();
    }

    $valid_types = ["cleaning", "inspection", "maintenance"];
    $valid_priority = ["normal", "urgent"];

    if(!in_array($task_type, $valid_types) || !in_array($priority, $valid_priority)){
        echo json_encode(["success" => false, "message" => "Invalid values"]);
        exit();
    }

    $ok = db::Execute(
        "INSERT INTO housekeeping_tasks (room_id, assigned_to, task_type, priority, status, notes, scheduled_date)
         VALUES (?, ?, ?, ?, 'pending', ?, ?)",
        $room_id,
        $supervisor_id,
        $task_type,
        $priority,
        $notes,
        $scheduled_date
    );

    echo json_encode(["success" => (bool)$ok]);
    exit();
}

if($action == "tasks_today"){

    $rows = db::FetchAll(
        "SELECT ht.id, ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.room_id, r.room_number
         FROM housekeeping_tasks ht
         JOIN rooms r ON r.id = ht.room_id
         WHERE DATE(ht.scheduled_date) = CURDATE()
         ORDER BY ht.priority DESC, ht.status ASC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

if($action == "assigned_tasks"){

    $rows = db::FetchAll(
        "SELECT ht.id, ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.room_id, r.room_number
         FROM housekeeping_tasks ht
         JOIN rooms r ON r.id = ht.room_id
         WHERE ht.status != 'done'
         ORDER BY ht.scheduled_date ASC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

if($action == "task_detail"){
    $task_id = intval($_GET["task_id"] ?? 0);

    if(!$task_id){
        echo json_encode(["success" => false, "message" => "Task not found"]);
        exit();
    }

    $task = db::Fetch(
        "SELECT ht.id, ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.room_id, r.room_number
         FROM housekeeping_tasks ht
         JOIN rooms r ON r.id = ht.room_id
         WHERE ht.id = ?",
        $task_id
    );

    echo json_encode(["success" => true, "task" => $task ?: null]);
    exit();
}

if($action == "update_task"){

    $task_id = intval($_POST["task_id"] ?? 0);
    $status = $_POST["status"] ?? "";
    $notes = trim($_POST["notes"] ?? "");
    $room_status = $_POST["room_status"] ?? "";

    $valid_status = ["pending", "in_progress", "done"];

    if(!$task_id || !in_array($status, $valid_status)){
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit();
    }

    $completed_at = null;

    if($status == "done"){
        $completed_at = date("Y-m-d H:i:s");
    }

    $ok = db::Execute(
        "UPDATE housekeeping_tasks SET status=?, notes=?, completed_at=? WHERE id=?",
        $status,
        $notes,
        $completed_at,
        $task_id
    );

    if($ok && $room_status == "" && $status == "in_progress"){
        $room_status = "in_progress";
    }

    if($ok && $room_status == "" && $status == "done"){
        $room_status = "available";
    }

    if($ok && $room_status != ""){

        $valid_room_status = ["available", "dirty", "in_progress", "maintenance", "occupied", "blocked"];

        if(in_array($room_status, $valid_room_status)){

            $task = db::Fetch("SELECT room_id FROM housekeeping_tasks WHERE id=?", $task_id);

            if($task){
                db::Execute("UPDATE rooms SET status=? WHERE id=?", $room_status, $task["room_id"]);
            }
        }
    }

    echo json_encode(["success" => (bool)$ok]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown task action"]);
?>
