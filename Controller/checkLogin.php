<?php
if(isset($_COOKIE["nextPage"])){
    setcookie("role", $_COOKIE["role"], time() + (86400 * 30), "/");
    setcookie("user_id", $_COOKIE["user_id"], time() + (86400 * 30),"/");
    $role = $_COOKIE["role"];
    if($role == "admin") {
        header("Location: ../View/Admin/dashboard.php");
    }
    else if ($role == "guest") {
        header("Location: ../View/guest/dashboard.php");
    }
    else if ($role == "housekeeping") {
        header("Location: ../View/housekeeping/dashboard.php");
    }
    else if ($role == "receptionist") {
        header("Location: ../View/Receptionist/dashboard.php");
    }
    else {
        header("Location: ../View/login.html?error=invalid_role");
    }
    exit();
}
else{
    header("Location: ../View/login.html");
    exit();
}
?>