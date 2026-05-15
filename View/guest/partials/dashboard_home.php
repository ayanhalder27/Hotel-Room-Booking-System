<div class="container-fluid p-0">
    <div class="luxury-hero-banner mb-4">
        <div class="hero-overlay-card">
            <span class="text-uppercase tracking-widest text-gold text-xs fw-semibold mb-2 d-block">Marriott Bonvoy Preferred Partner</span>
            <h2 class="display-6 fw-bold text-white mb-2">Experience Unmatched Opulence</h2>
            <p class="text-white-50 m-0">Manage your seamless booking profiles, select ultra-premium bespoke room services, and view active rewards balance details instantly.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card shadow-sm border-0 bg-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-uppercase text-xs fw-semibold tracking-wider d-block mb-1">Total Nights Spent</span>
                    <h3 class="fw-bold text-navy m-0">14 Nights</h3>
                </div>
                <div class="kpi-icon bg-navy-subtle text-navy"><i class="fa-solid fa-moon"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card shadow-sm border-0 bg-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-uppercase text-xs fw-semibold tracking-wider d-block mb-1">Active Stay Points</span>
                    <h3 class="fw-bold text-gold m-0">4,850 Pts</h3>
                </div>
                <div class="kpi-icon bg-gold-subtle text-gold"><i class="fa-solid fa-crown"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card shadow-sm border-0 bg-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-uppercase text-xs fw-semibold tracking-wider d-block mb-1">Total Active Bookings</span>
                    <h3 class="fw-bold text-success m-0">1 Upcoming</h3>
                </div>
                <div class="kpi-icon bg-success-subtle text-success"><i class="fa-solid fa-receipt"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="kpi-card shadow-sm border-0 bg-white p-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted text-uppercase text-xs fw-semibold tracking-wider d-block mb-1">Total Investment</span>
                    <h3 class="fw-bold text-navy m-0">$2,410.50</h3>
                </div>
                <div class="kpi-icon bg-light text-secondary"><i class="fa-solid fa-wallet"></i></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 h-100">
                <div class="card-header bg-navy text-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fs-6 fw-bold tracking-wider text-uppercase"><i class="fa-solid fa-plane-arrival me-2 text-gold"></i>Upcoming Luxe Stay</h5>
                    <span class="badge bg-gold text-dark font-monospace text-xs">CONFIRMED</span>
                </div>
                <div class="position-relative" style="height: 180px;">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80" alt="Room Sample" class="w-100 h-100 object-fit-cover">
                    <div class="position-absolute bottom-0 start-0 w-100 bg-gradient-dark p-3 text-white">
                        <h4 class="m-0 fs-5">Presidential Executive Suite</h4>
                        <span class="text-xs text-white-50">Room Assigned: #504 (Floor 5)</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center mb-4 border-bottom pb-3 g-2">
                        <div class="col-6 border-end">
                            <span class="text-xs text-muted d-block text-uppercase">Check In</span>
                            <span class="fw-bold text-navy text-md">May 24, 2026</span>
                            <span class="text-xs d-block text-muted">From 3:00 PM</span>
                        </div>
                        <div class="col-6">
                            <span class="text-xs text-muted d-block text-uppercase">Check Out</span>
                            <span class="fw-bold text-navy text-md">May 30, 2026</span>
                            <span class="text-xs d-block text-muted">Before 12:00 PM</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-user-group text-muted"></i>
                            <span class="text-sm">2 Adults, 1 Child</span>
                        </div>
                        <h5 class="m-0 text-gold font-monospace fw-bold">$1,450.00</h5>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-navy text-sm btn-lg border-radius-sm" onclick="App.loadPartial('booking_details')">Manage Complete Itinerary</button>
                        <button class="btn btn-outline-secondary text-sm border-radius-sm" onclick="App.loadPartial('modify_booking')">Modify Request</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="m-0 text-navy fw-bold">Quick Executive Actions</h5>
                </div>
                <div class="row g-3">
                    <div class="col-sm-4">
                        <button class="btn btn-light-gold-hover p-4 w-100 border text-center rounded-3 shadow-2xs transition-all" onclick="App.loadPartial('search_rooms')">
                            <i class="fa-solid fa-bed text-gold fs-3 mb-2 d-block"></i>
                            <span class="fw-semibold text-sm text-navy">Book a New Room</span>
                        </button>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-light-gold-hover p-4 w-100 border text-center rounded-3 shadow-2xs transition-all" onclick="App.loadPartial('service_requests')">
                            <i class="fa-solid fa-bell-concierge text-navy fs-3 mb-2 d-block"></i>
                            <span class="fw-semibold text-sm text-navy">Order Room Service</span>
                        </button>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-light-gold-hover p-4 w-100 border text-center rounded-3 shadow-2xs transition-all" onclick="App.loadPartial('reviews')">
                            <i class="fa-solid fa-pen-to-square text-success fs-3 mb-2 d-block"></i>
                            <span class="fw-semibold text-sm text-navy">Write Stay Review</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 p-0 overflow-hidden">
                <div class="p-4 bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-navy fw-bold">Recent Stays History</h5>
                    <button class="btn btn-link text-gold p-0 text-decoration-none fw-semibold text-sm" onclick="App.loadPartial('my_bookings')">View All</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light text-muted text-uppercase tracking-wider text-xs">
                            <tr>
                                <th class="ps-4">Booking ID</th>
                                <th>Room Type</th>
                                <th>Dates Spent</th>
                                <th>Total Cost</th>
                                <th class="pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 font-monospace fw-bold">#GH-90812</td>
                                <td>Deluxe Oceanfront Suite</td>
                                <td>Jan 12 - Jan 15, 2026</td>
                                <td class="fw-semibold text-navy">$540.00</td>
                                <td class="pe-4"><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 rounded-pill text-xs">CHECKED_OUT</span></td>
                            </tr>
                            <tr>
                                <td class="ps-4 font-monospace fw-bold">#GH-76211</td>
                                <td>Standard Executive King</td>
                                <td>Nov 03 - Nov 05, 2025</td>
                                <td class="fw-semibold text-navy">$310.00</td>
                                <td class="pe-4"><span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5 rounded-pill text-xs">CANCELLED</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>