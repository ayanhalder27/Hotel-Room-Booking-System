<?php
$pageTitle = 'Payments';
$contentFile = __DIR__ . '/partials_payment.php';
$pageScript = 'payment.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
