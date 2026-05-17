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

if($action == "get_profile"){

    $user = db::Fetch(
        "SELECT name, email, phone, profile_pic FROM users WHERE id=?",
        $supervisor_id
    );

    echo json_encode(["success" => true, "user" => $user]);
    exit();
}

if($action == "update_profile"){

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $new_password = trim($_POST["new_password"] ?? "");

    if(!$name || !$email){
        echo json_encode(["success" => false, "message" => "Name and email required"]);
        exit();
    }

    if($new_password != ""){
        $ok = db::Execute(
            "UPDATE users SET name=?, email=?, phone=?, password_hash=? WHERE id=?",
            $name,
            $email,
            $phone,
            $new_password,
            $supervisor_id
        );
    }
    else{
        $ok = db::Execute(
            "UPDATE users SET name=?, email=?, phone=? WHERE id=?",
            $name,
            $email,
            $phone,
            $supervisor_id
        );
    }

    echo json_encode(["success" => (bool)$ok]);
    exit();
}

echo json_encode(["success" => false, "message" => "Unknown profile action"]);
?>