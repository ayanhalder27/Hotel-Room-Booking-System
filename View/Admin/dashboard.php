<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #121212;
            --panel-bg: rgba(25, 25, 25, 0.7);
            --gold: #D4AF37;
            --gold-hover: #F3E5AB;
            --text-primary: #ffffff;
            --text-secondary: #aaaaaa;
            --border-color: rgba(255, 255, 255, 0.08);
            --danger: #ef4444;
            --success: #22c55e;
            --warning: #f59e0b;
            --info: #3b82f6;
            --font-body: 'Montserrat', sans-serif;
            --font-heading: 'Playfair Display', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-dark);
            color: var(--text-primary);
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar Navigation --- */
        .sidebar {
            width: 280px;
            background: var(--panel-bg);
            backdrop-filter: blur(15px);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .brand {
            padding: 2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-icon {
            color: var(--gold);
        }

        .brand-text {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: 1px;
        }

        .nav-menu {
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            overflow-y: auto;
            flex-grow: 1;
        }

        .nav-menu::-webkit-scrollbar {
            width: 5px;
        }
        .nav-menu::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 5px;
        }

        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 1px;
            margin: 1rem 0 0.5rem 0.8rem;
            font-weight: 600;
        }

        .nav-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            background: transparent;
            border: none;
            border-radius: 8px;
            color: var(--text-secondary);
            font-family: var(--font-body);
            font-size: 0.95rem;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
        }

        .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.03);
            color: var(--text-primary);
        }

        .nav-item.active {
            background-color: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            font-weight: 500;
            border-right: 3px solid var(--gold);
            border-radius: 8px 0 0 8px;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: 280px;
            flex-grow: 1;
            padding: 2rem 3rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            width: calc(100% - 280px);
        }

        /* --- Topbar --- */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .page-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 500;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--panel-bg);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: border-color 0.2s;
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            border-color: var(--text-secondary);
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .greeting {
            display: flex;
            flex-direction: column;
        }

        .greeting-text {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* --- Metrics Grid --- */
        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .metric-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            border-color: rgba(212, 175, 55, 0.3);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
        }

        .card-value {
            font-family: var(--font-heading);
            font-size: 2.2rem;
            font-weight: 600;
        }

        .trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .text-success { color: var(--success); }
        .text-danger { color: var(--danger); }
        .text-warning { color: var(--warning); }

        .progress-container {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
            overflow: hidden;
            margin-top: auto;
        }

        .progress-bar {
            height: 100%;
            background: var(--gold);
            width: 0%;
            transition: width 1s cubic-bezier(0.1, 0.5, 0.1, 1);
        }

        /* Room Status Split Bar */
        .room-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }
        .stat-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-secondary);
        }
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        /* --- Quick Actions / Tables --- */
        .section-header {
            font-family: var(--font-heading);
            font-size: 1.3rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-view-all {
            background: transparent;
            color: var(--gold);
            border: none;
            font-family: var(--font-body);
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .btn-view-all:hover {
            color: var(--gold-hover);
            text-decoration: underline;
        }

        .table-container {
            background-color: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th, td {
            padding: 1.2rem;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        td {
            font-size: 0.95rem;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.confirmed { background: rgba(34, 197, 94, 0.1); color: var(--success); border: 1px solid rgba(34, 197, 94, 0.2); }
        .badge.pending { background: rgba(245, 158, 11, 0.1); color: var(--warning); border: 1px solid rgba(245, 158, 11, 0.2); }
        .badge.checked-in { background: rgba(59, 130, 246, 0.1); color: var(--info); border: 1px solid rgba(59, 130, 246, 0.2); }
    </style>
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:24px; height:24px;">
                    <path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-3"></path><path d="M9 9v.01"></path><path d="M9 13v.01"></path><path d="M9 17v.01"></path>
                </svg>
            </div>
            <div class="brand-text">LuxeStay</div>
        </div>

        <nav class="nav-menu">
            <div class="nav-category">Main</div>
            <button class="nav-item active" onclick="window.location.href='dashboard.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="7" height="9" rx="1"></rect><rect x="14" y="3" width="7" height="5" rx="1"></rect><rect x="14" y="12" width="7" height="9" rx="1"></rect><rect x="3" y="16" width="7" height="5" rx="1"></rect></svg>
                Dashboard
            </button>

            <div class="nav-category">Accommodations</div>
            <button class="nav-item" onclick="window.location.href='manage-rooms.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Manage Rooms
            </button>
            <button class="nav-item" onclick="window.location.href='manage-room-types.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                Room Types
            </button>
            <button class="nav-item" onclick="window.location.href='seasonal-pricing.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                Seasonal Pricing
            </button>

            <div class="nav-category">Operations</div>
            <button class="nav-item" onclick="window.location.href='manage-bookings.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                All Bookings
            </button>
            <button class="nav-item" onclick="window.location.href='service-requests.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                Service & Maintenance
            </button>

            <div class="nav-category">Users & Relations</div>
            <button class="nav-item" onclick="window.location.href='manage-guests.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                Manage Guests
            </button>
            <button class="nav-item" onclick="window.location.href='manage-staff.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                Manage Staff
            </button>
            <button class="nav-item" onclick="window.location.href='manage-reviews.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Guest Reviews
            </button>
            <button class="nav-item" onclick="window.location.href='announcements.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                Announcements
            </button>

            <div class="nav-category">Analytics</div>
            <button class="nav-item" onclick="window.location.href='reports.php'">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                Reports
            </button>
        </nav>

        <div style="padding: 1.5rem 1rem; border-top: 1px solid var(--border-color);">
            <button class="nav-item" onclick="window.location.href='logout.php'" style="color: var(--danger);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Logout
            </button>
        </div>
    </aside>

    <!-- Main Dashboard Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="topbar">
            <h1 class="page-title">Overview</h1>

            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=Admin+User&background=D4AF37&color=000" alt="Admin Profile" class="avatar">
                <div class="greeting">
                    <span class="greeting-text">Welcome back,</span>
                    <span class="user-name">System Admin</span>
                </div>
                <svg viewBox="0 0 24 24" fill="none" stroke="var(--text-secondary)" stroke-width="2" width="16" height="16" style="margin-left: 4px;">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </div>
        </header>

        <!-- KPI Metrics Grid -->
        <div class="metrics-grid">
            
            <!-- Occupancy Rate Card -->
            <div class="metric-card">
                <div class="card-header">
                    <span class="card-title">Current Occupancy</span>
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="card-value" id="occupancyVal">82%</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +5% from last week
                </div>
                <div class="progress-container">
                    <div class="progress-bar" id="occupancyBar" data-width="82%"></div>
                </div>
            </div>

            <!-- Today's Revenue Card -->
            <div class="metric-card">
                <div class="card-header">
                    <span class="card-title">Today's Revenue</span>
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>
                <div class="card-value">$8,450</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +12% vs yesterday
                </div>
            </div>

            <!-- Rooms Status Card -->
            <div class="metric-card">
                <div class="card-header">
                    <span class="card-title">Rooms Status</span>
                    <div class="card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="card-value">123 <span style="font-size: 1rem; color: var(--text-secondary); font-weight: 400; font-family: var(--font-body);">/ 150</span></div>
                
                <div style="margin-top: auto;">
                    <div class="room-stats">
                        <div class="stat-label">
                            <div class="dot" style="background: var(--gold);"></div> Occupied (123)
                        </div>
                        <div class="stat-label">
                            <div class="dot" style="background: var(--success);"></div> Available (27)
                        </div>
                    </div>
                    <div class="progress-container" style="height: 8px; display: flex; background: transparent; gap: 2px;">
                        <div style="flex-basis: 82%; background: var(--gold); border-radius: 4px;"></div>
                        <div style="flex-basis: 18%; background: var(--success); border-radius: 4px;"></div>
                    </div>
                </div>
            </div>

            <!-- Maintenance & Reviews Card (Combined for layout balance) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                
                <!-- Active Maintenance -->
                <div class="metric-card" style="padding: 1.2rem;">
                    <div class="card-header" style="margin-bottom: 0.5rem;">
                        <span class="card-title">Maintenance</span>
                        <div class="card-icon" style="width:30px; height:30px; background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="card-value" style="font-size: 1.8rem;">4</div>
                    <div class="trend text-danger" style="margin-top: auto; font-size: 0.8rem;">Active Issues</div>
                </div>

                <!-- Pending Reviews -->
                <div class="metric-card" style="padding: 1.2rem;">
                    <div class="card-header" style="margin-bottom: 0.5rem;">
                        <span class="card-title">Reviews</span>
                        <div class="card-icon" style="width:30px; height:30px; background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                            </svg>
                        </div>
                    </div>
                    <div class="card-value" style="font-size: 1.8rem;">9</div>
                    <div class="trend text-warning" style="margin-top: auto; font-size: 0.8rem;">Awaiting Reply</div>
                </div>
            </div>

        </div>

        <!-- Recent Bookings Quick View -->
        <div>
            <div class="section-header">
                <h2>Recent Bookings</h2>
                <button class="btn-view-all" onclick="window.location.href='manage-bookings.php'">View All Bookings <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
            </div>
            
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Room Type</th>
                            <th>Check-in / Check-out</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div style="font-weight: 500;">Alexander Pierce</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">ID: #BKG-4012</div>
                            </td>
                            <td>Executive Suite</td>
                            <td>Oct 24, 2026 - Oct 28, 2026</td>
                            <td style="font-family: var(--font-heading); font-weight: 600;">$1,800.00</td>
                            <td><span class="badge confirmed">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 500;">Sarah Jenkins</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">ID: #BKG-4013</div>
                            </td>
                            <td>Deluxe King</td>
                            <td>Oct 25, 2026 - Oct 27, 2026</td>
                            <td style="font-family: var(--font-heading); font-weight: 600;">$500.00</td>
                            <td><span class="badge pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-weight: 500;">Michael Chen</div>
                                <div style="font-size: 0.85rem; color: var(--text-secondary);">ID: #BKG-4014</div>
                            </td>
                            <td>Standard Twin</td>
                            <td>Oct 22, 2026 - Oct 25, 2026</td>
                            <td style="font-family: var(--font-heading); font-weight: 600;">$450.00</td>
                            <td><span class="badge checked-in">Checked In</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <script>
        // Simple script to animate the progress bars on load
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const bar = document.getElementById('occupancyBar');
                if(bar) {
                    bar.style.width = bar.getAttribute('data-width');
                }
            }, 300); // Slight delay for visual effect
        });
    </script>
</body>
</html>