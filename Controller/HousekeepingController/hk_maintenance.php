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

if($action == "log_maintenance"){

    $room_id = intval($_POST["room_id"] ?? 0);
    $description = trim($_POST["description"] ?? "");
    $severity = $_POST["severity"] ?? "low";

    if(!$room_id || !$description){
        echo json_encode(["success" => false, "message" => "Missing required fields"]);
        exit();
    }

    $valid_severity = ["low", "medium", "high"];

    if(!in_array($severity, $valid_severity)){
        echo json_encode(["success" => false, "message" => "Invalid severity"]);
        exit();
    }

    $ok = db::Execute(
        "INSERT INTO maintenance_reports (room_id, reported_by, description, severity, status, reported_at)
         VALUES (?, ?, ?, ?, 'open', NOW())",
        $room_id,
        $supervisor_id,
        $description,
        $severity
    );

    if($ok){
        db::Execute("UPDATE rooms SET status='maintenance' WHERE id=?", $room_id);
    }

    echo json_encode(["success" => (bool)$ok]);
    exit();
}

if($action == "maintenance_reports"){

    $rows = db::FetchAll(
        "SELECT mr.id, mr.description, mr.severity, mr.status, mr.reported_at, r.room_number
         FROM maintenance_reports mr
         JOIN rooms r ON r.id = mr.room_id
         ORDER BY FIELD(mr.severity,'high','medium','low'), mr.reported_at DESC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

if($action == "update_maintenance"){

    $report_id = intval($_POST["report_id"] ?? 0);
    $status = $_POST["status"] ?? "";

    $valid_status = ["open", "in_progress", "resolved"];

    if(!$report_id || !in_array($status, $valid_status)){
        echo json_encode(["success" => false, "message" => "Invalid input"]);
        exit();
    }

    $resolved_at = null;

    if($status == "resolved"){
        $resolved_at = date("Y-m-d H:i:s");
    }

    $ok = db::Execute(
        "UPDATE maintenance_reports SET status=?, resolved_at=? WHERE id=?",
        $status,
        $resolved_at,
        $report_id
    );

    if($ok && $status == "resolved"){

        $report = db::Fetch("SELECT room_id FROM maintenance_reports WHERE id=?", $report_id);

        if($report){
            db::Execute("UPDATE rooms SET status='available' WHERE id=?", $report["room_id"]);
        }
    }

    echo json_encode(["success" => (bool)$ok]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown maintenance action"]);
?>