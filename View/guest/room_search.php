<?php
$pageTitle = 'Search Available Rooms';
$contentFile = __DIR__ . '/partials_room_search.php';
$pageScript = 'room_search.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
