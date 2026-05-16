<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST["logout"])) {
            setcookie("nextPage", $_COOKIE["nextPage"], time() - 3600,"/");
            setcookie("id", $_COOKIE["id"], time() - 3600,"/");
            header("Location: ../View/login.html");
            exit();
        }
        elseif (isset($_POST["profile"])) {
            // header("Location: ../View/profile.html");
            // exit();
        }
        elseif (isset($_POST["rooms"])) {
            header("Location: ../View/rooms.html");
            exit();
        }
        elseif (isset($_POST["roomTypes"])) {
            header("Location: ../View/room_types.html");
            exit();
        }
    }
?>