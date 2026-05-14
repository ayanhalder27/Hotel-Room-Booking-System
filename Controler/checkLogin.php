<?php
if(isset($_COOKIE["nextPage"])){
    setcookie("nextPage", $_COOKIE["nextPage"], time() + (86400 * 30),"/");
    setcookie("id", $_COOKIE["id"], time() + (86400 * 30),"/");
    header("Location: ".($_COOKIE["nextPage"] ?? "../View/login.html"));
    exit();
}
else{
    header("Location: ../View/login.html");
    exit();
}
?>