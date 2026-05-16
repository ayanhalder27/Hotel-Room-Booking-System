<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Occupancy Reports</title>
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
            --purple: #8b5cf6;
            --font-body: 'Montserrat', sans-serif;
            --font-heading: 'Playfair Display', serif;
            --input-bg: rgba(255, 255, 255, 0.05);
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

        .brand-icon { color: var(--gold); }

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

        .nav-menu::-webkit-scrollbar { width: 5px; }
        .nav-menu::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 5px; }

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

        .nav-item svg { width: 18px; height: 18px; }
        .nav-item:hover { background-color: rgba(255, 255, 255, 0.03); color: var(--text-primary); }

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

        .page-title-group .page-title {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 500;
        }
        
        .page-title-group .page-subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-top: 0.5rem;
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
        .user-profile:hover { border-color: var(--text-secondary); }
        .avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
        .greeting { display: flex; flex-direction: column; }
        .greeting-text { font-size: 0.75rem; color: var(--text-secondary); }
        .user-name { font-size: 0.9rem; font-weight: 500; }

        /* --- Controls Bar --- */
        .controls-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filters-group {
            display: flex;
            gap: 1rem;
            flex: 1;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-box { position: relative; }
        
        .filter-box select, .filter-box input[type="month"] {
            padding: 0.8rem 1rem 0.8rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 0.9rem;
            min-width: 150px;
            color-scheme: dark;
        }

        .filter-box select {
            cursor: pointer;
            appearance: none;
            padding-right: 2.5rem;
        }

        .filter-box select option {
            background: var(--bg-dark);
            color: var(--text-primary);
        }
        
        .filter-box::after {
            content: '▼';
            font-size: 0.7rem;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }
        
        .filter-box input[type="month"]::after { content: none; }

        .filter-box select:focus, .filter-box input[type="month"]:focus { outline: none; border-color: var(--gold); }

        .btn-primary {
            background: var(--gold);
            color: var(--bg-dark);
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-family: var(--font-body);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover { background: var(--gold-hover); transform: translateY(-2px); }
        
        .btn-outline {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-family: var(--font-body);
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-outline:hover { background: rgba(255,255,255,0.05); }

        /* --- Report Type Navigation (Sub-menu) --- */
        .report-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: -1rem;
        }
        .report-tab {
            padding: 0.8rem 1.5rem;
            background: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .report-tab:hover {
            color: var(--text-primary);
            background: rgba(255,255,255,0.05);
        }
        .report-tab.active {
            color: var(--gold);
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.05);
        }

        /* --- Financial Summaries --- */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        .summary-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .summary-card h3 {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-card .value {
            font-family: var(--font-heading);
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
        }
        .summary-card .trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .text-success { color: var(--success); }
        .text-gold { color: var(--gold); }
        
        /* --- Analytics Section --- */
        .analytics-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }
        
        @media (max-width: 1024px) {
            .analytics-container { grid-template-columns: 1fr; }
        }

        .chart-card {
            background-color: var(--panel-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
        }
        
        .chart-card h3 {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }
        
        /* Custom Progress Bars for Breakdowns */
        .breakdown-item {
            margin-bottom: 1.2rem;
        }
        .breakdown-header {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }
        .breakdown-header .label { color: var(--text-primary); }
        .breakdown-header .amount { font-weight: 600; color: var(--gold); }
        
        .progress-track {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
        }

        /* --- Table --- */
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
            vertical-align: middle;
        }

        th {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: var(--text-secondary);
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        td { font-size: 0.95rem; }
        tbody tr:hover { background: rgba(255, 255, 255, 0.02); }

        .type-name {
            font-family: var(--font-heading);
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .rate-cell {
            font-family: var(--font-heading);
            font-weight: 600;
            color: var(--gold);
            font-size: 1.1rem;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .section-header h2 {
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 500;
        }

        /* --- Print Styles --- */
        @media print {
            .sidebar, .topbar, .controls-bar, .report-tabs, .btn-primary, .btn-outline { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            body { background: #ffffff !important; color: #000000 !important; }
            
            .summary-card, .chart-card, .table-container { 
                background: #ffffff !important; 
                border: 1px solid #dddddd !important; 
                box-shadow: none !important; 
                page-break-inside: avoid;
            }
            
            * { color: #000000 !important; }
            .text-secondary { color: #555555 !important; }
            .gold, .rate-cell, .amount { color: #000000 !important; font-weight: bold !important; }
            .progress-track { background: #eeeeee !important; }
            
            h1.page-title { display: block !important; margin-bottom: 2rem !important; }
        }

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
            <button class="nav-item" onclick="window.location.href='dashboard.php'">
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
            <button class="nav-item active" onclick="window.location.href='report-finance.php'">
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

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="topbar">
            <div class="page-title-group">
                <h1 class="page-title" style="display: none;">Occupancy Report</h1> <!-- Displayed only on print -->
                <h1 class="page-title">Analytics & Reports</h1>
                <p class="page-subtitle">Analyze hotel occupancy, bookings, and revenue.</p>
            </div>

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

        <!-- Report Tabs -->
        <div class="report-tabs">
            <a href="report-finance.php" class="report-tab">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                Financial Report
            </a>
            <a href="report-occupancy.php" class="report-tab active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Occupancy Report
            </a>
        </div>

        <!-- Controls Bar -->
        <div class="controls-bar">
            <form action="report-occupancy.php" method="GET" class="filters-group">
                <div class="filter-box">
                    <select name="period" onchange="this.form.submit()">
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Month</option>
                    </select>
                </div>
                
                <span style="color: var(--text-secondary); font-size: 0.9rem;">or select month</span>
                
                <div class="filter-box">
                    <input type="month" name="custom_month" title="Select Month">
                </div>
                
                <button type="submit" class="btn-outline" style="padding: 0.8rem 1rem;">Update</button>
            </form>
            
            <button class="btn-primary" onclick="window.print()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                Export HTML / Print
            </button>
        </div>

        <!-- Occupancy Summaries (KPIs) -->
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Average Occupancy Rate</h3>
                <div class="value text-gold">78.4%</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +3.2% vs previous period
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Total Nights Booked</h3>
                <div class="value">1,240</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +150 nights vs previous
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Avg. Length of Stay</h3>
                <div class="value">3.2 <span style="font-size: 1rem; color: var(--text-secondary); font-family: var(--font-body); font-weight: 400;">Nights</span></div>
                <div class="trend" style="color: var(--text-secondary);">
                    Steady compared to average
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Most Popular Room Type</h3>
                <div class="value" style="font-size: 1.5rem; line-height: 1.2; padding-top: 5px;">Deluxe King</div>
                <div class="trend text-success">
                    42% of total bookings
                </div>
            </div>
        </div>

        <!-- Visual Analytics Section -->
        <div class="analytics-container">
            <!-- Occupancy by Room Type -->
            <div class="chart-card">
                <h3>Occupancy Rate by Room Type</h3>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Deluxe King</span>
                        <span class="amount">85% Occupied</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 85%; background: #D4AF37;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Standard Twin</span>
                        <span class="amount">75% Occupied</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 75%; background: #4ca1af;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Executive Suite</span>
                        <span class="amount">60% Occupied</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 60%; background: #64748b;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Presidential Suite</span>
                        <span class="amount">45% Occupied</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 45%; background: #9b59b6;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Peak Booking Months -->
            <div class="chart-card">
                <h3>Peak Booking Months (Trailing 6 Months)</h3>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">October</span>
                        <span class="amount">92%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 92%; background: #10b981;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">September</span>
                        <span class="amount">88%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 88%; background: #3b82f6;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">August</span>
                        <span class="amount">76%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 76%; background: #f59e0b;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">July</span>
                        <span class="amount">65%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 65%; background: #8b5cf6;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown Table -->
        <div class="section-header">
            <h2>Detailed Room Occupancy</h2>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Total Rooms</th>
                        <th>Nights Available</th>
                        <th>Nights Booked</th>
                        <th>Occupancy Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="type-name">Standard Twin</span></td>
                        <td>24 Rooms</td>
                        <td>720 Nights</td>
                        <td>540 Nights</td>
                        <td class="rate-cell">75.0%</td>
                    </tr>
                    <tr>
                        <td><span class="type-name">Deluxe King</span></td>
                        <td>15 Rooms</td>
                        <td>450 Nights</td>
                        <td>382 Nights</td>
                        <td class="rate-cell" style="color: var(--success);">84.8%</td>
                    </tr>
                    <tr>
                        <td><span class="type-name">Executive Suite</span></td>
                        <td>5 Rooms</td>
                        <td>150 Nights</td>
                        <td>90 Nights</td>
                        <td class="rate-cell">60.0%</td>
                    </tr>
                    <tr>
                        <td><span class="type-name">Presidential Suite</span></td>
                        <td>2 Rooms</td>
                        <td>60 Nights</td>
                        <td>27 Nights</td>
                        <td class="rate-cell" style="color: var(--warning);">45.0%</td>
                    </tr>
                    <tr style="background: rgba(255,255,255,0.03); border-top: 2px solid var(--border-color);">
                        <td><span class="type-name" style="color: var(--gold);">Overall</span></td>
                        <td><strong>46 Rooms</strong></td>
                        <td><strong>1,380 Nights</strong></td>
                        <td><strong>1,039 Nights</strong></td>
                        <td class="rate-cell"><strong>75.3%</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>