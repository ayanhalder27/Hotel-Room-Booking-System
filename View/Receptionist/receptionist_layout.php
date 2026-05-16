<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'receptionist') {
    header("Location: ../login.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$receptionistName = $_SESSION['name'] ?? 'Receptionist';
function activeMenu($file, $currentPage) { return $file === $currentPage ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Panel</title>
    <link rel="stylesheet" href="receptionist.css">
</head>
<body>
<div class="rec-wrapper">
    <aside class="rec-sidebar">
        <div class="brand">Hotel Reception<span>Front Desk Panel</span></div>
        <nav>
            <a class="nav-link <?= activeMenu('dashboard.php', $currentPage) ?>" href="dashboard.php">Dashboard</a>
            <a class="nav-link <?= activeMenu('today_checkins.php', $currentPage) ?>" href="today_checkins.php">Today Check-ins</a>
            <a class="nav-link <?= activeMenu('checkin.php', $currentPage) ?>" href="checkin.php">Check In Guest</a>
            <a class="nav-link <?= activeMenu('checkout.php', $currentPage) ?>" href="checkout.php">Check Out Guest</a>
            <a class="nav-link <?= activeMenu('walkin_booking.php', $currentPage) ?>" href="walkin_booking.php">Walk-in Booking</a>
            <a class="nav-link <?= activeMenu('guest_register.php', $currentPage) ?>" href="guest_register.php">Register Guest</a>
            <a class="nav-link <?= activeMenu('payment.php', $currentPage) ?>" href="payment.php">Payments</a>
            <a class="nav-link <?= activeMenu('service_requests.php', $currentPage) ?>" href="service_requests.php">Service Requests</a>
            <a class="nav-link <?= activeMenu('booking_modify.php', $currentPage) ?>" href="booking_modify.php">Modify Booking</a>
            <a class="nav-link <?= activeMenu('room_status.php', $currentPage) ?>" href="room_status.php">Room Status Board</a>
            <a class="nav-link <?= activeMenu('daily_report.php', $currentPage) ?>" href="daily_report.php">Daily Report</a>
            <a class="nav-link logout" href="../logout.php">Logout</a>
        </nav>
    </aside>
    <header class="rec-header">
        <h1><?= $pageTitle ?? 'Receptionist Panel' ?></h1>
        <div class="user-box">Logged in as <strong><?= htmlspecialchars($receptionistName) ?></strong></div>
    </header>
    <main class="rec-main">
        <?php if (isset($contentFile)) { include $contentFile; } ?>
    </main>
    <footer class="rec-footer">Hotel Room Booking System © Receptionist Panel</footer>
</div>
<script src="common.js"></script>
</body>
</html>
