<?php include '../layout/header.php'; ?>
<?php include '../layout/sidebar_guest.php'; ?>

<main class="main-body-content">
    <header class="top-navbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link d-lg-none p-0 text-dark" id="mobileSidebarToggle">
                <i class="fa-solid fa-bars-staggered fs-4"></i>
            </button>
            <h4 class="m-0 page-context-title fw-semibold text-navy">Welcome Back</h4>
        </div>
        
        <div class="navbar-actions-panel">
            <div class="announcement-pill d-none d-md-flex align-items-center" onclick="App.loadPartial('dashboard_home')">
                <i class="fa-solid fa-bullhorn text-gold me-2"></i>
                <span class="text-truncate" style="max-width: 250px;">Complimentary Wine Tasting Tonight at 7 PM!</span>
            </div>
            
            <div class="dropdown">
                <button class="btn notification-bell-btn position-relative" type="button" data-bs-toggle="dropdown">
                    <i class="fa-regular fa-bell"></i>
                    <span class="position-absolute top-1 start-75 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow-lg notification-dropdown p-0">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">Notifications</h6>
                        <a href="#" class="text-xs text-gold">Mark read</a>
                    </div>
                    <div class="notification-list" style="max-height: 250px; overflow-y: auto;">
                        <a href="#" class="dropdown-item p-3 border-bottom border-light">
                            <p class="mb-1 text-sm text-wrap">Your booking for **Deluxe Suite Room #402** has been confirmed.</p>
                            <span class="text-muted text-xs">2 hours ago</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="vertical-divider"></div>
            
            <div class="user-profile-menu dropdown" onclick="App.loadPartial('profile')">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" alt="Guest Profile Image" class="avatar-circle">
                <div class="d-none d-sm-block text-start">
                    <span class="d-block fw-semibold text-sm lh-1">Sarah Jenkins</span>
                    <span class="badge-tier-gold text-xs"><i class="fa-solid fa-crown me-1"></i>Gold Elite Member</span>
                </div>
            </div>
        </div>
    </header>

    <div id="dynamic-view-stage" class="content-stage-fade mt-4">
        </div>
</main>

<?php include '../layout/footer.php'; ?>
