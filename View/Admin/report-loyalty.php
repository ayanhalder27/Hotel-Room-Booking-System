<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Loyalty Reports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="report-loyalty.css">
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
                <h1 class="page-title" style="display: none;">Loyalty Report</h1> <!-- Displayed only on print -->
                <h1 class="page-title">Analytics & Reports</h1>
                <p class="page-subtitle">Analyze loyalty points, redemptions, and member activity.</p>
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
            <a href="report-occupancy.php" class="report-tab">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                Occupancy Report
            </a>
            <a href="report-loyalty.php" class="report-tab active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                Loyalty Report
            </a>
        </div>

        <!-- Controls Bar -->
        <div class="controls-bar">
            <form action="report-loyalty.php" method="GET" class="filters-group">
                <div class="filter-box">
                    <select name="period" onchange="this.form.submit()">
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                        <option value="this_year">This Year</option>
                        <option value="custom">Custom Range</option>
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

        <!-- Loyalty Summaries (KPIs) -->
        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Points Issued</h3>
                <div class="value text-gold" id="pointsIssuedVal">0</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +12% vs previous period
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Total Points Redeemed</h3>
                <div class="value" id="pointsRedeemedVal">0</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +5% redemption rate
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Active Members</h3>
                <div class="value" id="activeMembersVal">0</div>
                <div class="trend text-success">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    +45 new members this month
                </div>
            </div>
            
            <div class="summary-card">
                <h3>Outstanding Liability</h3>
                <div class="value" id="liabilityVal" style="font-size: 1.5rem; line-height: 1.2; padding-top: 5px; color: var(--danger);">$0.00</div>
                <div class="trend" style="color: var(--text-secondary);">
                    Value of unredeemed points
                </div>
            </div>
        </div>

        <!-- Visual Analytics Section -->
        <div class="analytics-container">
            <!-- Earning Activities Breakdown -->
            <div class="chart-card">
                <h3>Earning Activities Breakdown</h3>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Room Bookings</span>
                        <span class="amount">28,400 pts (63%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 63%; background: #D4AF37;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Dining & Bar</span>
                        <span class="amount">10,800 pts (24%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 24%; background: #4ca1af;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Spa Services</span>
                        <span class="amount">4,500 pts (10%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 10%; background: #64748b;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Promotional Bonuses</span>
                        <span class="amount">1,500 pts (3%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 3%; background: #9b59b6;"></div>
                    </div>
                </div>
            </div>
            
            <!-- Redemption Activities Breakdown -->
            <div class="chart-card">
                <h3>Redemption Activities Breakdown</h3>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Free Nights</span>
                        <span class="amount">12,500 pts (68%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 68%; background: #10b981;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Room Upgrades</span>
                        <span class="amount">3,500 pts (19%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 19%; background: #3b82f6;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Late Checkout / Early Check-in</span>
                        <span class="amount">1,500 pts (8%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 8%; background: #f59e0b;"></div>
                    </div>
                </div>
                
                <div class="breakdown-item">
                    <div class="breakdown-header">
                        <span class="label">Dining Vouchers</span>
                        <span class="amount">1,000 pts (5%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: 5%; background: #8b5cf6;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Transactions Table -->
        <div class="section-header">
            <h2>Recent Loyalty Transactions</h2>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Member Name</th>
                        <th>Transaction Type</th>
                        <th>Description / Source</th>
                        <th>Points Affected</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Oct 20, 2026</td>
                        <td><span class="type-name">Alexander Pierce</span></td>
                        <td><span class="badge earned">Earned</span></td>
                        <td>Checkout - Executive Suite (4 Nights)</td>
                        <td class="points-earned">+ 1,800</td>
                    </tr>
                    <tr>
                        <td>Oct 19, 2026</td>
                        <td><span class="type-name">Sarah Jenkins</span></td>
                        <td><span class="badge redeemed">Redeemed</span></td>
                        <td>Room Upgrade to Deluxe King</td>
                        <td class="points-redeemed">- 500</td>
                    </tr>
                    <tr>
                        <td>Oct 19, 2026</td>
                        <td><span class="type-name">Michael Chen</span></td>
                        <td><span class="badge earned">Earned</span></td>
                        <td>Dining - Luxe Restaurant</td>
                        <td class="points-earned">+ 120</td>
                    </tr>
                    <tr>
                        <td>Oct 18, 2026</td>
                        <td><span class="type-name">Jessica Alba</span></td>
                        <td><span class="badge redeemed">Redeemed</span></td>
                        <td>Free Night - Standard Twin</td>
                        <td class="points-redeemed">- 12,000</td>
                    </tr>
                    <tr>
                        <td>Oct 15, 2026</td>
                        <td><span class="type-name">David Wallace</span></td>
                        <td><span class="badge earned">Earned</span></td>
                        <td>Promotional Bonus (Summer Campaign)</td>
                        <td class="points-earned">+ 500</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script src="report-loyalty.js"></script>
</body>
</html>
