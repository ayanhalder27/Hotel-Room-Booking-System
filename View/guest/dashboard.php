<?php
// Main Guest Dashboard Wrapper
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grand Horizon - Luxury Guest Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="guest.css">
</head>
<body class="bg-smooth">

    <div class="dashboard-container">
        <?php include 'sidebar_guest.php'; ?>

        <div class="main-wrapper">
            <?php include 'header.php'; ?>

            <main class="content-canvas" id="mainDynamicContent">
                <div id="dashboardLoader" class="loader-overlay d-none">
                    <div class="spinner-gold"></div>
                </div>
                <div id="viewContainer" class="fade-in">
                    <?php include 'dashboard_home.php'; ?>
                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="appToast" class="toast custom-toast border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i id="toastIcon" class="bi bi-info-circle text-gold fs-5"></i>
                    <span id="toastMessage" class="text-white"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="guest.js"></script>
</body>
</html>