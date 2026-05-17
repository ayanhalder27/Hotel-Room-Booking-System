<?php
$pageTitle = 'Modify Booking';
$contentFile = __DIR__ . '/partials_booking_modify.php';
$pageScript = 'booking_modify.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
