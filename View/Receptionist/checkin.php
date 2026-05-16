<?php
$pageTitle = 'Check In Guest';
$contentFile = __DIR__ . '/partials_checkin.php';
$pageScript = 'checkin.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
