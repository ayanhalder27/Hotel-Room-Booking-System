<?php
$pageTitle = 'Today Check-ins';
$contentFile = __DIR__ . '/partials_today_checkins.php';
$pageScript = 'today_checkins.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
