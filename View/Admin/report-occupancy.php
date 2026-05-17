<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Occupancy Reports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="report-occupancy.css">
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
            <button class="nav-item" onclick="window.location.href='../login.html'" style="color: var(--danger);">
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
            <a href="report-loyalty.php" class="report-tab">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Loyalty Report
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
                <div class="value text-gold" id="avgOccupancyVal">0.0%</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +3.2% vs previous period
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Total Nights Booked</h3>
                <div class="value" id="totalNightsVal">0</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +150 nights vs previous
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Avg. Length of Stay</h3>
                <div class="value" id="avgStayVal">0.0 <span style="font-size: 1rem; color: var(--text-secondary); font-family: var(--font-body); font-weight: 400;">Nights</span></div>
                <div class="trend" style="color: var(--text-secondary);">
                    Steady compared to average
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Most Popular Room Type</h3>
                <div class="value" id="popularRoomVal" style="font-size: 1.5rem; line-height: 1.2; padding-top: 5px;">-</div>
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

    <script src="report-occupancy.js"></script>
</body>
</html>
