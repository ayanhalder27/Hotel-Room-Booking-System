<?php
$pageTitle = 'Service Requests';
$contentFile = __DIR__ . '/partials_service_requests.php';
$pageScript = 'service_request.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
