<?php
$pageTitle = 'My Profile';
$contentFile = __DIR__ . '/partials_profile.php';
$pageScript = 'profile.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
