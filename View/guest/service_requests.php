<?php
$pageTitle = 'Service Requests';
$contentFile = __DIR__ . '/partials_service_requests.php';
$pageScript = 'service_requests.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
