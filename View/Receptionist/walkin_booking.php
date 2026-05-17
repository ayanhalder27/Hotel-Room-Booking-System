<?php
$pageTitle = 'Walk-in Booking';
$contentFile = __DIR__ . '/partials_walkin_booking.php';
$pageScript = 'walkin.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
