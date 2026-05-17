<?php
$pageTitle = 'My Bookings';
$contentFile = __DIR__ . '/partials_my_bookings.php';
$pageScript = 'my_bookings.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
