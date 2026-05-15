<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
        setcookie("nextPage", $_COOKIE["nextPage"], time() - 3600,"/");
        setcookie("id", $_COOKIE["id"], time() -3600,"/");
        header("Location: ../View/login.html");
        exit();
    }
?>