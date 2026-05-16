<?php
$pageTitle = 'Check Out Guest';
$contentFile = __DIR__ . '/partials_checkout.php';
$pageScript = 'checkout.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'receptionist_layout.php';
?>
