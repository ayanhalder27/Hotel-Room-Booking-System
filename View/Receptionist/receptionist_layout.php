<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'receptionist') {
    header('Location: ../login.php');
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$pageTitle = $pageTitle ?? 'Receptionist Panel';
$receptionistName = $_SESSION['name'] ?? 'Receptionist';
function activeMenu($file, $currentPage){ return $file === $currentPage ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="stylesheet" href="receptionist.css?v=2">
</head>
<body>
<div class="rec-wrapper">
    <aside class="rec-sidebar">
        <div class="brand">Hotel Reception<span>Front Desk Panel</span></div>
        <nav id="recNav">
            <a class="nav-link <?= activeMenu('dashboard.php',$currentPage) ?>" href="dashboard.php">Dashboard</a>
            <a class="nav-link <?= activeMenu('today_checkins.php',$currentPage) ?>" href="today_checkins.php">Today Check-ins</a>
            <a class="nav-link <?= activeMenu('checkin.php',$currentPage) ?>" href="checkin.php">Check In Guest</a>
            <a class="nav-link <?= activeMenu('checkout.php',$currentPage) ?>" href="checkout.php">Check Out Guest</a>
            <a class="nav-link <?= activeMenu('walkin_booking.php',$currentPage) ?>" href="walkin_booking.php">Walk-in Booking</a>
            <a class="nav-link <?= activeMenu('guest_register.php',$currentPage) ?>" href="guest_register.php">Register Guest</a>
            <a class="nav-link <?= activeMenu('payment.php',$currentPage) ?>" href="payment.php">Payments</a>
            <a class="nav-link <?= activeMenu('service_requests.php',$currentPage) ?>" href="service_requests.php">Service Requests</a>
            <a class="nav-link <?= activeMenu('booking_modify.php',$currentPage) ?>" href="booking_modify.php">Modify Booking</a>
            <a class="nav-link <?= activeMenu('room_status.php',$currentPage) ?>" href="room_status.php">Room Status Board</a>
            <a class="nav-link <?= activeMenu('daily_report.php',$currentPage) ?>" href="daily_report.php">Daily Report</a>
            <a class="nav-link logout" href="../logout.php" data-normal-link="true">Logout</a>
        </nav>
    </aside>
    <header class="rec-header">
        <h1 id="pageHeading"><?= htmlspecialchars($pageTitle) ?></h1>
        <div class="user-box">Logged in as <strong><?= htmlspecialchars($receptionistName) ?></strong></div>
    </header>
    <main class="rec-main" id="appContent">
        <?php if (isset($contentFile)) include $contentFile; ?>
    </main>
    <footer class="rec-footer">Hotel Room Booking System © Receptionist Panel</footer>
</div>
<script src="common.js?v=2"></script>
<?php if (isset($pageScript)): ?><script src="<?= htmlspecialchars($pageScript) ?>?v=2"></script><?php endif; ?>
</body>
</html>
