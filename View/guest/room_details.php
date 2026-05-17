<?php
$pageTitle = 'Room Details';
$contentFile = __DIR__ . '/partials_room_details.php';
$pageScript = 'room_details.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
