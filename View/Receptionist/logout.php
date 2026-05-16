<?php
session_start();
// DESTROY ALL SESSION DATA
session_unset();
session_destroy();
// DESTROY COOKIES
if(isset($_COOKIE['email'])){
    setcookie('email','',time() - 3600,'/' );
}
if(isset($_COOKIE['password'])){
    setcookie('password','',time() - 3600,'/');
}
if(isset($_COOKIE['role'])){
    setcookie('role','',time() - 3600,'/');
}
// REDIRECT TO LOGIN PAGE
header("Location: ../index.php");
exit();
?>