<?php
$pageTitle = 'Register Guest';
$contentFile = __DIR__ . '/partials_guest_register.php';
$pageScript = 'guest_register.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
