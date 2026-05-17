<?php
$pageTitle = 'Booking Details';
$contentFile = __DIR__ . '/partials_booking_details.php';
$pageScript = 'booking_details.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
