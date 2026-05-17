<?php
$pageTitle = 'Receptionist Dashboard';
$contentFile = __DIR__ . '/partials_dashboard.php';
$pageScript = 'dashboard.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
