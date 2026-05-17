<?php
$pageTitle = 'Book Room';
$contentFile = __DIR__ . '/partials_book_room.php';
$pageScript = 'book_room.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
