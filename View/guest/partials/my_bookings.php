<div class="container-fluid p-0">
    <div class="card border-0 shadow-2xs p-3 mb-4 bg-white rounded-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <ul class="nav nav-pills custom-luxury-pills mb-0 border-0">
                <li class="nav-item"><button class="nav-link active" id="btnFilterAll" onclick="App.filterBookings('all')">All Bookings</button></li>
                <li class="nav-item"><button class="nav-link" id="btnFilterUpcoming" onclick="App.filterBookings('upcoming')">Upcoming Itineraries</button></li>
                <li class="nav-item"><button class="nav-link" id="btnFilterPast" onclick="App.filterBookings('past')">Historical Stays</button></li>
            </ul>
            <div class="search-box-wrapper position-relative">
                <i class="fa-solid fa-magnifying-glass search-box-icon text-muted"></i>
                <input type="text" class="form-input ps-5 py-1.5 text-sm" placeholder="Search Booking ID / Room...">
            </div>
        </div>
    </div>

    <div class="d-flex flex-column gap-4" id="bookingsMasterListContainer">
        
        <div class="card booking-mega-card border-0 shadow-sm bg-white overflow-hidden rounded-4" data-stay-status="upcoming">
            <div class="p-4 bg-navy text-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-4">
                    <div>
                        <span class="text-white-50 text-xs uppercase d-block tracking-wider font-monospace">Date Placed</span>
                        <span class="text-sm fw-semibold">May 15, 2026</span>
                    </div>
                    <div class="vertical-divider bg-white-20 h-25"></div>
                    <div>
                        <span class="text-white-50 text-xs uppercase d-block tracking-wider font-monospace">Confirmation Identifier</span>
                        <span class="text-sm fw-bold font-monospace text-gold">#GH-2026-88412</span>
                    </div>
                </div>
                <div>
                    <span class="badge bg-gold text-dark px-3 py-1.5 text-xs font-monospace rounded-pill fw-bold">UPCOMING ACTIVE</span>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=400&q=80" alt="Room View" class="w-100 rounded-3 object-fit-cover" style="height: 120px;">
                    </div>
                    <div class="col-md-5">
                        <h4 class="text-navy fw-bold mb-1">Deluxe King Oceanfront Room</h4>
                        <p class="text-muted text-xs mb-3"><i class="fa-solid fa-clock me-2"></i>Duration: **3 Nights** | Occupancy Profile: 2 Adults</p>
                        <div class="row g-2 text-sm border-top pt-2">
                            <div class="col-6"><strong>Check In:</strong> <span class="text-secondary font-monospace">May 24, 2026</span></div>
                            <div class="col-6"><strong>Check Out:</strong> <span class="text-secondary font-monospace">May 27, 2026</span></div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end d-flex flex-column gap-2 border-start-md ps-md-4">
                        <span class="text-xs text-muted d-block">Settled Invoice Value</span>
                        <h3 class="font-monospace text-navy fw-bold m-0 mb-2">$775.50</h3>
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button class="btn btn-outline-navy btn-sm px-3" onclick="App.loadPartial('booking_details')">Full Architecture Ledger</button>
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm text-dark border border-neutral-subtle" type="button" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-md text-sm">
                                    <li><a class="dropdown-item" href="#" onclick="App.loadPartial('modify_booking')"><i class="fa-solid fa-calendar-days text-muted me-2"></i>Request Schedule Shift</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="App.loadPartial('service_requests')"><i class="fa-solid fa-bell-concierge text-muted me-2"></i>Provision In-Stay Needs</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger fw-semibold" href="#" onclick="App.cancelBookingTrigger('#GH-2026-88412')"><i class="fa-solid fa-ban me-2"></i>Terminate Reservation</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card booking-mega-card border-0 shadow-sm bg-white overflow-hidden rounded-4" data-stay-status="past">
            <div class="p-4 bg-light text-secondary d-flex flex-wrap justify-content-between align-items-center gap-3 border-bottom">
                <div class="d-flex align-items-center gap-4">
                    <div>
                        <span class="text-muted text-xs uppercase d-block tracking-wider font-monospace">Date Placed</span>
                        <span class="text-sm fw-semibold">Jan 02, 2026</span>
                    </div>
                    <div class="vertical-divider h-25"></div>
                    <div>
                        <span class="text-muted text-xs uppercase d-block tracking-wider font-monospace">Confirmation Identifier</span>
                        <span class="text-sm fw-bold font-monospace text-navy">#GH-2026-10294</span>
                    </div>
                </div>
                <div>
                    <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5 text-xs font-monospace rounded-pill">COMPLETED HISTORICAL</span>
                </div>
            </div>
            <div class="p-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=400&q=80" alt="Room View" class="w-100 rounded-3 object-fit-cover" style="height: 120px;">
                    </div>
                    <div class="col-md-5">
                        <h4 class="text-navy opacity-75 fw-bold mb-1">Standard Executive King Room</h4>
                        <p class="text-muted text-xs mb-3"><i class="fa-solid fa-clock me-2"></i>Duration: **3 Nights** | Occupancy Profile: 1 Adult</p>
                        <div class="row g-2 text-sm border-top pt-2">
                            <div class="col-6"><strong>Check In:</strong> <span class="text-secondary font-monospace">Jan 12, 2026</span></div>
                            <div class="col-6"><strong>Check Out:</strong> <span class="text-secondary font-monospace">Jan 15, 2026</span></div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end d-flex flex-column gap-2 border-start-md ps-md-4">
                        <span class="text-xs text-muted d-block">Settled Invoice Value</span>
                        <h3 class="font-monospace text-muted fw-bold m-0 mb-2">$540.00</h3>
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                            <button class="btn btn-outline-secondary btn-sm px-3" onclick="App.loadPartial('booking_details')">View Folio</button>
                            <button class="btn btn-navy btn-sm px-3" onclick="App.loadPartial('reviews')"><i class="fa-solid fa-star me-1 text-gold"></i>Write Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>