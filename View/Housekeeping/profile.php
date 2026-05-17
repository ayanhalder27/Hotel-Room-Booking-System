<?php
session_start();
include_once("../../Model/db.php");

if(!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != "housekeeping"){
    header("Location: ../../View/login.html");
    exit();
}

$sidebarUser = db::Fetch("SELECT name, email FROM users WHERE id=?", $_SESSION["user_id"]);
$sidebarName = $sidebarUser["name"] ?? "Supervisor";
$sidebarEmail = $sidebarUser["email"] ?? "housekeeping@luxestay.com";
$sidebarInitial = strtoupper(substr($sidebarName, 0, 1));
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay — Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  
    <link rel="stylesheet" href="hk-common.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 21h18"></path>
                <path d="M5 21V7l8-4v18"></path>
                <path d="M19 21V11l-6-3"></path>
                <path d="M9 9v.01"></path>
                <path d="M9 13v.01"></path>
                <path d="M9 17v.01"></path>
            </svg>
        </div>

        <div class="brand-text">
            <span class="brand-name">LuxeStay</span>
            <span class="brand-role">Housekeeping</span>
        </div>
    </div>

 <nav class="sidebar-nav">
    <a href="dashboard.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
        </svg>
        Dashboard
    </a>

    <a href="rooms.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        Room Status Board
    </a>

    <a href="tasks.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 11l3 3L22 4"></path>
            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
        </svg>
        Tasks
    </a>

    <a href="maintenance.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
        </svg>
        Maintenance
    </a>

    <a href="schedule.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        Schedule
    </a>

    <a href="report.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="18" y1="20" x2="18" y2="10"></line>
            <line x1="12" y1="20" x2="12" y2="4"></line>
            <line x1="6" y1="20" x2="6" y2="14"></line>
        </svg>
        Daily Report
    </a>

    <a href="history.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        History
    </a>

    <a href="profile.php" class="nav-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
        Profile
    </a>
</nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar" id="sidebarAvatar"><?php echo htmlspecialchars($sidebarInitial); ?></div>
            <div>
                <div class="user-name" id="sidebarName"><?php echo htmlspecialchars($sidebarName); ?></div>
                <div class="user-email" id="sidebarEmail"><?php echo htmlspecialchars($sidebarEmail); ?></div>
            </div>
        </div>

        <a href="../../Controller/logout.php" class="logout-btn" title="Logout">
            Logout
        </a>
    </div>
</aside>

<!-- Top Bar -->
<div class="topbar">
    <button class="menu-toggle" onclick="toggleSidebar()">
        ☰
    </button>

    <div class="topbar-title">Profile</div>

    <div class="topbar-actions">
        <div class="topbar-date" id="topbarDate"></div>
    </div>
</div>

<main class="main-content">
    <section class="section active">
        <div class="section-header">
            <h2>My Profile</h2>
            <p>Manage your account information</p>
        </div>

        <div class="card" style="max-width:600px">
            <form class="form-grid" id="profileForm" enctype="multipart/form-data">
                <div class="form-group full-width center">
                    <div class="avatar-upload">
                        <div class="avatar-preview" id="avatarPreview">S</div>
                        <label class="avatar-btn" for="profilePicInput">Change picture</label>
                        <input type="file" name="profile_pic" id="profilePicInput" accept="image/jpeg,image/png,image/webp">
                    </div>
                </div>

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" id="profileName" placeholder="Your name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="profileEmail" placeholder="your@email.com" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" id="profilePhone" placeholder="+880...">
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" placeholder="Leave blank to keep current">
                </div>

                <div class="form-group full-width">
                    <button type="submit" name="update_profile" class="btn-primary">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<div class="toast-container" id="toastBox"></div>

<script src="hk-shared.js"></script>
<script src="profile.js"></script>

</body>
</html>
