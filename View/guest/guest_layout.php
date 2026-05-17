<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'guest') {
    header("Location: ../login.php");
    exit();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$guestName = $_SESSION['name'] ?? 'Guest';
function activeMenu($file, $currentPage) { return $file === $currentPage ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Guest Panel') ?></title>
    <link rel="stylesheet" href="guest.css">
</head>
<body>
<div class="guest-wrapper">
    <aside class="guest-sidebar">
        <div class="brand"><div class="brand-icon">H</div><div><strong>Hotel Guest</strong><span>Booking Portal</span></div></div>
        <nav class="guest-nav">
            <a class="nav-link <?= activeMenu('dashboard.php', $currentPage) ?>" href="dashboard.php">Dashboard</a>
            <a class="nav-link <?= activeMenu('room_search.php', $currentPage) ?>" href="room_search.php">Search Rooms</a>
            <a class="nav-link <?= activeMenu('my_bookings.php', $currentPage) ?>" href="my_bookings.php">My Bookings</a>
            <a class="nav-link <?= activeMenu('service_requests.php', $currentPage) ?>" href="service_requests.php">Service Requests</a>
            <a class="nav-link <?= activeMenu('reviews.php', $currentPage) ?>" href="reviews.php">Reviews</a>
            <a class="nav-link <?= activeMenu('loyalty.php', $currentPage) ?>" href="loyalty.php">Loyalty Points</a>
            <a class="nav-link <?= activeMenu('billing_history.php', $currentPage) ?>" href="billing_history.php">Billing History</a>
            <a class="nav-link <?= activeMenu('profile.php', $currentPage) ?>" href="profile.php">Profile</a>
            <a class="nav-link logout" data-normal-link="true" href="../../Controler/logout.php">Logout</a>
        </nav>
    </aside>
    <header class="guest-header">
        <div><h1 id="pageHeading"><?= htmlspecialchars($pageTitle ?? 'Guest Panel') ?></h1><p>Welcome back, <?= htmlspecialchars($guestName) ?>. Enjoy your stay with us.</p></div>
        <a class="btn btn-gradient" href="room_search.php">Book a Room</a>
    </header>
    <main class="guest-main" id="appContent"><?php if (isset($contentFile)) { include $contentFile; } ?></main>
    <footer class="guest-footer">Hotel Room Booking System © Guest Portal</footer>
</div>
<script src="common.js"></script>
<?php if (isset($pageScript)): ?><script src="<?= htmlspecialchars($pageScript) ?>"></script><?php endif; ?>
</body>
</html>
