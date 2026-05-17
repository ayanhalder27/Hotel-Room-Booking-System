<?php
session_start();

include("../Model/db.php");

function getRolePage($role){
    if($role == "housekeeping"){
        return "../View/Housekeeping/hk_dashboard.php";
    }

    return "../View/" . $role . ".html";
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $data = db::Fetch(
        "select id, password_hash, role from users where email=? or phone=? or username=?",
        $username,
        $username,
        $username
    );

    if($data != Null){

        if($password == $data["password_hash"]){

            $_SESSION["user_id"] = $data["id"];
            $_SESSION["role"] = $data["role"];

            if(isset($_POST["rememberMe"])){
                setcookie("id", $data["id"], time() + (86400 * 30), "/");
            }
            else{
                setcookie("id", "", time() - 3600, "/");
            }

            header("Location: " . getRolePage($data["role"]));
            exit();
        }
        else{
            header("Location: ../View/login.html?error=incorrect_password");
            exit();
        }
    }
    else{
        header("Location: ../View/login.html?error=user_not_found");
        exit();
    }
}
?>
