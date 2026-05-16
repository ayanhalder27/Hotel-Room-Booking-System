<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LuxeStay - Manage Room Types</title>
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

        .search-box { position: relative; }
        .search-box input {
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 0.9rem;
            min-width: 300px;
        }
        .search-box input:focus { outline: none; border-color: var(--gold); }
        .search-box svg {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            width: 16px;
            height: 16px;
        }

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

        .type-thumbnail {
            width: 60px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .type-name {
            font-family: var(--font-heading);
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gold);
        }

        .amenities-list {
            display: flex;
            gap: 0.4rem;
            flex-wrap: wrap;
            max-width: 250px;
        }

        .amenity-tag {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-color);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .amenity-tag svg { width: 12px; height: 12px; }

        .room-count-badge {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            padding: 0.3rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(212, 175, 55, 0.2);
            display: inline-block;
            white-space: nowrap;
        }

        .description-cell {
            max-width: 200px;
            color: var(--text-secondary);
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .btn-icon:hover { color: var(--text-primary); border-color: var(--text-primary); }
        .btn-icon.delete:hover { color: var(--danger); border-color: var(--danger); background: rgba(239, 68, 68, 0.1); }

        /* --- Modal Styles --- */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active { opacity: 1; visibility: visible; }

        .modal-content {
            background: #1a1a1a;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 100%;
            max-width: 700px;
            padding: 2rem;
            transform: translateY(-20px);
            transition: all 0.3s ease;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal-content { transform: translateY(0); }

        .modal-content::-webkit-scrollbar { width: 6px; }
        .modal-content::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 6px; }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        .modal-header h2 { font-family: var(--font-heading); color: var(--gold); font-size: 1.5rem; }
        
        .close-modal {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-modal:hover { color: var(--danger); }

        .form-group { margin-bottom: 1.2rem; }
        .form-row { display: flex; gap: 1rem; }
        .form-row .form-group { flex: 1; }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .form-control {
            width: 100%;
            padding: 0.8rem;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: var(--font-body);
        }
        .form-control:focus { outline: none; border-color: var(--gold); }
        textarea.form-control { resize: vertical; min-height: 80px; }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
        .file-upload-wrapper:hover {
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.05);
        }
        .file-upload-wrapper input[type="file"] {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0; cursor: pointer;
        }
        .file-upload-icon {
            color: var(--gold);
            margin-bottom: 0.5rem;
        }
        .file-upload-text {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Checkbox Grid */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 0.8rem;
            background: rgba(0,0,0,0.2);
            padding: 1rem;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-primary);
            cursor: pointer;
        }
        .checkbox-label input[type="checkbox"] {
            accent-color: var(--gold);
            width: 16px; height: 16px;
        }

        .modal-footer {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .btn-secondary {
            background: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 0.8rem 1.5rem;
            border-radius: 6px;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-secondary:hover { background: rgba(255, 255, 255, 0.05); }

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
            <button class="nav-item active" onclick="window.location.href='manage-room-types.php'">
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

    <!-- Main Content Area -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="topbar">
            <div class="page-title-group">
                <h1 class="page-title">Manage Room Types</h1>
                <p class="page-subtitle">Define categories, base pricing, capacities, and amenities.</p>
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
            <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" placeholder="Search by Type Name...">
            </div>

            <button class="btn-primary" id="openModalBtn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add New Room Type
            </button>
        </div>

        <!-- Room Types Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Type Name</th>
                        <th>Base Price / Night</th>
                        <th>Capacity</th>
                        <th>Key Amenities</th>
                        <th>Description</th>
                        <th>Total Rooms</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&q=80&w=150&h=100" alt="Twin" class="type-thumbnail"></td>
                        <td class="type-name">Standard Twin</td>
                        <td>$150.00</td>
                        <td>2 Adults, 1 Child</td>
                        <td>
                            <div class="amenities-list">
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg> Wi-Fi</span>
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg> TV</span>
                            </div>
                        </td>
                        <td class="description-cell">A comfortable room with two twin beds and essential amenities.</td>
                        <td><span class="room-count-badge">24 Rooms</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                                <button class="btn-icon delete" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1582719478250-c89404bb8a0e?auto=format&fit=crop&q=80&w=150&h=100" alt="King" class="type-thumbnail"></td>
                        <td class="type-name">Deluxe King</td>
                        <td>$250.00</td>
                        <td>2 Adults</td>
                        <td>
                            <div class="amenities-list">
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"></path><path d="M1.42 9a16 16 0 0 1 21.16 0"></path><path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path><line x1="12" y1="20" x2="12.01" y2="20"></line></svg> Wi-Fi</span>
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg> Bathtub</span>
                            </div>
                        </td>
                        <td class="description-cell">A spacious room with a king-sized bed and modern luxury bathroom.</td>
                        <td><span class="room-count-badge">15 Rooms</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                                <button class="btn-icon delete" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&q=80&w=150&h=100" alt="Suite" class="type-thumbnail"></td>
                        <td class="type-name">Executive Suite</td>
                        <td>$450.00</td>
                        <td>4 Adults</td>
                        <td>
                            <div class="amenities-list">
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="15" rx="2" ry="2"></rect><polyline points="17 2 12 7 7 2"></polyline></svg> TV</span>
                                <span class="amenity-tag"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg> Bathtub</span>
                                <span class="amenity-tag" style="background: rgba(212,175,55,0.1); color: var(--gold);">+4 more</span>
                            </div>
                        </td>
                        <td class="description-cell">Elegant suite with a separate living area, premium amenities, and exclusive services.</td>
                        <td><span class="room-count-badge">5 Rooms</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                                <button class="btn-icon delete" title="Delete"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Add/Edit Room Type Modal -->
    <div class="modal-overlay" id="typeModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Room Type</h2>
                <button class="close-modal" id="closeModalBtn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form id="typeForm" action="process_room_type.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="typeId" name="type_id">
                
                <div class="form-group">
                    <label for="typeName">Type Name *</label>
                    <input type="text" id="typeName" name="name" class="form-control" placeholder="e.g., Presidential Suite" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="basePrice">Base Price / Night ($) *</label>
                        <input type="number" id="basePrice" name="price_per_night" class="form-control" min="0" step="0.01" placeholder="0.00" required>
                    </div>
                    <div class="form-group">
                        <label for="maxCapacity">Max Guests Capacity *</label>
                        <input type="number" id="maxCapacity" name="max_capacity" class="form-control" min="1" placeholder="e.g., 2" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" placeholder="Brief description of the room type for the booking page..."></textarea>
                </div>

                <div class="form-group">
                    <label>Thumbnail Image</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*">
                        <div class="file-upload-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </div>
                        <div class="file-upload-text">Drag & drop an image or click to browse</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 5px;" id="fileNameDisplay">Supports JPG, PNG (Max 2MB)</div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Included Amenities</label>
                    <div class="checkbox-grid">
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="wifi"> Free Wi-Fi</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="tv"> Smart TV</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="ac"> Air Conditioning</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="minibar"> Minibar</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="bathtub"> Bathtub</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="balcony"> Balcony</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="safe"> In-room Safe</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="coffee"> Coffee Maker</label>
                        <label class="checkbox-label"><input type="checkbox" name="amenities[]" value="service"> 24/7 Room Service</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelModalBtn">Cancel</button>
                    <button type="submit" class="btn-primary">Save Room Type</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Interactive Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('typeModal');
            const openBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const fileInput = document.getElementById('thumbnail');
            const fileNameDisplay = document.getElementById('fileNameDisplay');

            // Handle file input display
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    fileNameDisplay.innerText = "Selected: " + this.files[0].name;
                    fileNameDisplay.style.color = "var(--gold)";
                } else {
                    fileNameDisplay.innerText = "Supports JPG, PNG (Max 2MB)";
                    fileNameDisplay.style.color = "var(--text-secondary)";
                }
            });

            // Open modal
            openBtn.addEventListener('click', () => {
                document.getElementById('modalTitle').innerText = 'Add New Room Type';
                document.getElementById('typeForm').reset();
                fileNameDisplay.innerText = "Supports JPG, PNG (Max 2MB)";
                fileNameDisplay.style.color = "var(--text-secondary)";
                modal.classList.add('active');
            });

            // Close modal functions
            const closeModal = () => {
                modal.classList.remove('active');
            };

            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);

            // Close modal if clicking outside the content box
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Mock functionality for Edit buttons
            const editButtons = document.querySelectorAll('.btn-icon[title="Edit"]');
            editButtons.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.getElementById('modalTitle').innerText = 'Edit Room Type';
                    
                    const row = e.target.closest('tr');
                    const typeName = row.querySelector('.type-name').innerText;
                    
                    document.getElementById('typeName').value = typeName;
                    
                    modal.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>