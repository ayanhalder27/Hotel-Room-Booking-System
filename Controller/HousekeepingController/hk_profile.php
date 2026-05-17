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
    $profile_pic = null;

    if(!$name || !$email){
        echo json_encode(["success" => false, "message" => "Name and email required"]);
        exit();
    }

    if(isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] != UPLOAD_ERR_NO_FILE){
        if($_FILES["profile_pic"]["error"] != UPLOAD_ERR_OK){
            echo json_encode(["success" => false, "message" => "Profile picture upload failed"]);
            exit();
        }

        $allowed_types = [
            "image/jpeg" => "jpg",
            "image/png" => "png",
            "image/webp" => "webp"
        ];

        $file_type = mime_content_type($_FILES["profile_pic"]["tmp_name"]);

        if(!isset($allowed_types[$file_type])){
            echo json_encode(["success" => false, "message" => "Only JPG, PNG, or WEBP images allowed"]);
            exit();
        }

        $upload_dir = "../../Resources/uploads/profiles/";

        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0777, true);
        }

        $file_name = "housekeeping_" . $supervisor_id . "_" . time() . "." . $allowed_types[$file_type];
        $target_path = $upload_dir . $file_name;

        if(!move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_path)){
            echo json_encode(["success" => false, "message" => "Could not save profile picture"]);
            exit();
        }

        $profile_pic = "Resources/uploads/profiles/" . $file_name;
    }

    if($new_password != "" && $profile_pic != null){
        $ok = db::Execute(
            "UPDATE users SET name=?, email=?, phone=?, password_hash=?, profile_pic=? WHERE id=?",
            $name,
            $email,
            $phone,
            $new_password,
            $profile_pic,
            $supervisor_id
        );
    }
    else if($new_password != ""){
        $ok = db::Execute(
            "UPDATE users SET name=?, email=?, phone=?, password_hash=? WHERE id=?",
            $name,
            $email,
            $phone,
            $new_password,
            $supervisor_id
        );
    }
    else if($profile_pic != null){
        $ok = db::Execute(
            "UPDATE users SET name=?, email=?, phone=?, profile_pic=? WHERE id=?",
            $name,
            $email,
            $phone,
            $profile_pic,
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
