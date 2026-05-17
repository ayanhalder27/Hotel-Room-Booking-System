<?php 
// 1. MUST START SESSION AT THE ABSOLUTE TOP
session_start();

include("../Model/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    // Added 'name' to the query so the dashboard can welcome the user by name
    $data = db::Fetch("SELECT id, name, email, password_hash, role FROM users WHERE email=? OR phone=? OR username=?", $username, $username, $username);

    if ($data != null) {
        if ($password == $data["password_hash"]) {
            
            // 2. SAVE THE EMAIL TO THE SESSION HERE:
            $_SESSION['user_id'] = $data["id"];
            $_SESSION['role']    = $data["role"];
            $_SESSION['name']    = $data["name"]; 
            $_SESSION['email']   = $data["email"];

            $role = $data["role"];
            $id = $data["id"];

            // Optional: Remember Me Cookies
            if (isset($_POST["rememberMe"])) {
                setcookie("user_id", $id, time() + (86400 * 30), "/");
                setcookie("role", $role, time() + (86400 * 30), "/");
            }

            // 3. ROLE-BASED ROUTING
            if ($role == "admin") {
                header("Location: ../View/Admin/dashboard.php");
            }
            else if ($role == "guest") {
                header("Location: ../View/guest/dashboard.php");
            }
            else if ($role == "housekeeping") {
                header("Location: ../View/Housekeeping/dashboard.php");
            }
            else if ($role == "receptionist") {
                header("Location: ../View/Receptionist/dashboard.php");
            }
            else {
                header("Location: ../View/login.html?error=invalid_role");
            }
            exit();
        } 
        else {
            header("Location: ../View/login.html?error=incorrect_password");
            exit();
        }
    } 
    else {
        header("Location: ../View/login.html?error=user_not_found");
        exit();
    }
}
?>