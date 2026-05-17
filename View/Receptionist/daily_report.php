<?php
$pageTitle = 'Daily Report';
$contentFile = __DIR__ . '/partials_daily_report.php';
$pageScript = 'report.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
