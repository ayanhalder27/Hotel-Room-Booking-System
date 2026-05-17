<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Service & Maintenance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="service-requests.css">
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
            <button class="nav-item active" onclick="window.location.href='service-requests.php'">
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
            <button class="nav-item" onclick="window.location.href='report-finance.php'">
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
                <h1 class="page-title">Service & Maintenance</h1>
                <p class="page-subtitle">Manage guest requests, room services, and maintenance tickets.</p>
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

        <!-- Controls Bar -->
        <div class="controls-bar">
            <div class="filters-group">
                <div class="search-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Search by Room or Request ID...">
                </div>
                
                <div class="filter-box">
                    <select name="type_filter">
                        <option value="all">All Request Types</option>
                        <option value="room_service">Room Service</option>
                        <option value="housekeeping">Housekeeping (Laundry, Toiletries, Extra Bed)</option>
                        <option value="maintenance">Maintenance Ticket</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="filter-box">
                    <select name="status_filter">
                        <option value="all">All Statuses</option>
                        <option value="pending">Pending / Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed / Resolved</option>
                    </select>
                </div>
            </div>

            <button class="btn-primary" id="openModalBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                New Request
            </button>
        </div>

        <!-- Requests Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Req ID</th>
                        <th>Room / Guest</th>
                        <th>Type & Description</th>
                        <th>Requested Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="requestsTableBody">
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add/Edit Request Modal -->
    <div class="modal-overlay" id="requestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Create New Request</h2>
                <button class="close-modal" id="closeModalBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form id="requestForm" action="process_service_request.php" method="POST">
                <input type="hidden" id="requestId" name="id">
                
                <div class="form-row">
                    <div class="form-group" style="flex: 1.5;">
                        <label for="requestCategory">Category *</label>
                        <select id="requestCategory" name="category" class="form-control" required onchange="toggleMaintenanceFields(this.value)">
                            <option value="service">Guest Service Request</option>
                            <option value="maintenance">Maintenance Report</option>
                        </select>
                    </div>
                    <div class="form-group" id="serviceTypeWrapper">
                        <label for="serviceType">Service Type *</label>
                        <select id="serviceType" name="service_type" class="form-control">
                            <option value="room_service">Room Service</option>
                            <option value="laundry">Laundry</option>
                            <option value="toiletries">Toiletries</option>
                            <option value="extra_bed">Extra Bed</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group" id="severityWrapper" style="display: none;">
                        <label for="severity">Severity *</label>
                        <select id="severity" name="severity" class="form-control">
                            <option value="low">Low (Routine)</option>
                            <option value="medium">Medium</option>
                            <option value="high">High (Urgent)</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="roomId">Room Number *</label>
                        <select id="roomId" name="room_id" class="form-control" required>
                            <option value="">Select Room...</option>
                            <!-- Populated from rooms table -->
                            <option value="3001">Room 101</option>
                            <option value="3002">Room 102</option>
                            <option value="3003">Room 205</option>
                            <option value="3004">Room 401</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="reportedBy">Guest / Reported By *</label>
                        <select id="reportedBy" name="reported_by" class="form-control" required>
                            <option value="">Select Guest or Staff...</option>
                            <option value="1001">Alexander Pierce (Guest)</option>
                            <option value="1003">Michael Chen (Guest)</option>
                            <option value="1050">Housekeeping Staff</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status *</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="pending">Pending / Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed / Resolved</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description / Details *</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Provide specific details about the request or issue..." required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelModalBtn">Cancel</button>
                    <button type="submit" class="btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Interactive Scripts -->
    <script src="service-requests.js"></script>
</body>
</html>
