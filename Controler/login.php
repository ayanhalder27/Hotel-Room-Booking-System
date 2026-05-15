<?php 
include("../Model/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $data = db::Fetch("SELECT id, password_hash, role FROM users WHERE email=? OR phone=? OR username=?",$username, $username, $username);

    if($data != null){

        if($password == $data["password_hash"])
        {
            $role = $data["role"]; // store role in variable
            $id = $data["id"];

            // common cookie (optional)
            if(isset($_POST["rememberMe"]))
            {
                setcookie("user_id", $id, time() + (86400 * 30), "/");
                setcookie("role", $role, time() + (86400 * 30), "/");
            }

            // role-based routing
            if($role == "admin"){
                header("Location: ../View/admin.html");
            }
            else if($role == "guest"){
                header("Location: ../View/guest/dashboard.");
            }
            else if($role == "housekeeping"){
                header("Location: ../View/housekeeping.html");
            }
            else if($role == "receptionist"){
                header("Location: ../View/receptionist.html");
            }
            else{
                header("Location: ../View/login.html?error=invalid_role");
            }

            exit();
        }
        else
        {
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