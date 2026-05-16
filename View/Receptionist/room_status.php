<?php
$pageTitle = 'Room Status Board';
$contentFile = __DIR__ . '/partials_room_status.php';
$pageScript = 'room_status.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
