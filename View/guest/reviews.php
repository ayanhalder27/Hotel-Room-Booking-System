<?php
$pageTitle = 'My Reviews';
$contentFile = __DIR__ . '/partials_reviews.php';
$pageScript = 'reviews.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
