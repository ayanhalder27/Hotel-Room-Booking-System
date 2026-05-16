<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'receptionist') {
    header('location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="receptionist.css">
</head>
<body>

    <!-- HEADER START -->
    <header class="top-header">
        <div class="header-left">
            <h4>Hotel Management System</h4>
        </div>

        <div class="header-right">
            <span>
                Welcome,
                <?php echo $_SESSION['name']; ?>
            </span>
        </div>
    </header>
    <!-- HEADER END -->


<!-- SIDEBAR START -->
    <aside class="sidebar">

        <div class="sidebar-title">
            Receptionist Panel
        </div>

        <ul>
            <li>
                <button onclick="loadPage('home.php')">
                    Dashboard
                </button>
            </li>

            <li>
                <button onclick="loadPage('bookings.php')">
                    Bookings
                </button>
            </li>

            <li>
                <button onclick="loadPage('rooms.php')">
                    Rooms
                </button>
            </li>

            <li>
                <button onclick="loadPage('services.php')">
                    Services
                </button>
            </li>

            <li>
                <button onclick="loadPage('walkin.php')">
                Walk-In Booking
                </button>
            </li>

            <li>
                <button onclick="loadPage('profile.php')">
                    Profile
                </button>
            </li>

            <li>
                <button onclick="loadPage('logout.php')">
                    Logout
                </button>
            </li>
        </ul>

    </aside>
    <!-- SIDEBAR END -->

    <!-- MAIN CONTENT START -->
    <main class="main-content">

        <div id="content-area">

            <!-- Default Dashboard Home -->
            <?php include 'home.php'; ?>

        </div>

    </main>
    <!-- MAIN CONTENT END -->


    <!-- FOOTER START -->
    <footer class="footer">
        Hotel Room Booking System © 2026
    </footer>
    <!-- FOOTER END -->


    <script src="receptionist.js"></script>

</body>
</html>