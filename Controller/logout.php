<?php
session_start();

session_unset();

session_destroy();

setcookie("id", "", time() - 3600, "/");

header("Location: ../View/login.html");
exit();
?>
