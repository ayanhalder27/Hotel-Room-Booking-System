<?php
$pageTitle = 'Loyalty Points';
$contentFile = __DIR__ . '/partials_loyalty.php';
$pageScript = 'loyalty.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
