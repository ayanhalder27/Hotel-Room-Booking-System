<?php
session_start();

include("../Model/db.php");

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

            // Session = login proof
            $_SESSION["user_id"] = $data["id"];
            $_SESSION["role"] = $data["role"];

            // Remember me = optional cookie
            if(isset($_POST["rememberMe"])){
                setcookie("id", $data["id"], time() + (86400 * 30), "/");
                setcookie("nextPage", "../View/" . $data["role"] . ".html", time() + (86400 * 30), "/");
            }

            header("Location: ../View/" . $data["role"] . ".html");
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