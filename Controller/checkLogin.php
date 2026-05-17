<?php
session_start();

include("../Model/db.php");

function getRolePage($role){
    if($role == "housekeeping"){
        return "../View/Housekeeping/hk_dashboard.php";
    }

    return "../View/" . $role . ".html";
}

function sendJsonResponse($authenticated, $role = ""){
    header("Content-Type: application/json");
    echo json_encode([
        "authenticated" => $authenticated,
        "role" => $role
    ]);
    exit();
}

if(isset($_SESSION["user_id"]) && isset($_SESSION["role"])){
    if(isset($_GET["format"]) && $_GET["format"] == "json"){
        sendJsonResponse(true, $_SESSION["role"]);
    }

    header("Location: " . getRolePage($_SESSION["role"]));
    exit();
}

if(isset($_COOKIE["id"])){
    $data = db::Fetch(
        "select id, role from users where id=?",
        $_COOKIE["id"]
    );

    if($data != Null){
        $_SESSION["user_id"] = $data["id"];
        $_SESSION["role"] = $data["role"];

        if(isset($_GET["format"]) && $_GET["format"] == "json"){
            sendJsonResponse(true, $data["role"]);
        }

        header("Location: " . getRolePage($data["role"]));
        exit();
    }
}

if(isset($_GET["format"]) && $_GET["format"] == "json"){
    sendJsonResponse(false);
}

header("Location: ../View/login.html");
exit();
?>
