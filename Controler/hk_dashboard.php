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
$supervisor_id = $_SESSION["user_id"];

if($action == "dashboard_stats"){

    $dirty = db::FetchValue("SELECT COUNT(*) FROM rooms WHERE status='dirty'");
    $inspection = db::FetchValue("SELECT COUNT(*) FROM housekeeping_tasks WHERE status='pending' AND task_type='inspection'");
    $maintenance = db::FetchValue("SELECT COUNT(*) FROM maintenance_reports WHERE status != 'resolved'");
    $done_today = db::FetchValue("SELECT COUNT(*) FROM housekeeping_tasks WHERE status='done' AND DATE(completed_at)=CURDATE()");

    echo json_encode([
        "success" => true,
        "dirty" => (int)$dirty,
        "inspection" => (int)$inspection,
        "maintenance" => (int)$maintenance,
        "done_today" => (int)$done_today
    ]);
    exit();
}

if($action == "today_checkouts"){

    $rows = db::FetchAll(
        "SELECT b.checkout_date, r.room_number, u.name AS guest_name
         FROM bookings b
         JOIN rooms r ON r.id = b.room_id
         JOIN users u ON u.id = b.guest_id
         WHERE b.status = 'checked_in'
         AND DATE(b.checkout_date) = CURDATE()
         ORDER BY b.checkout_date ASC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

if($action == "upcoming_checkins"){

    $rows = db::FetchAll(
        "SELECT b.checkin_date, r.room_number, r.status AS room_status, u.name AS guest_name
         FROM bookings b
         JOIN rooms r ON r.id = b.room_id
         JOIN users u ON u.id = b.guest_id
         WHERE b.status IN ('confirmed','pending')
         AND DATE(b.checkin_date) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY)
         ORDER BY b.checkin_date ASC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

if($action == "urgent_tasks"){

    $rows = db::FetchAll(
        "SELECT ht.id, ht.task_type, ht.priority, ht.status, ht.notes, ht.scheduled_date, ht.room_id, r.room_number
         FROM housekeeping_tasks ht
         JOIN rooms r ON r.id = ht.room_id
         WHERE ht.priority = 'urgent'
         AND ht.status != 'done'
         ORDER BY ht.scheduled_date ASC"
    );

    echo json_encode(["success" => true, "rows" => $rows ?: []]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown dashboard action"]);
?>