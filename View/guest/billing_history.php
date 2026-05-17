<?php
$pageTitle = 'Billing History';
$contentFile = __DIR__ . '/partials_billing_history.php';
$pageScript = 'billing_history.js';
if (isset($_GET['partial'])) { include $contentFile; exit(); }
include 'guest_layout.php';
?>
