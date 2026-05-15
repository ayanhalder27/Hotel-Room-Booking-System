<div class="animate-slide-up">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="brand-serif text-navy mb-0">Your Reserved Histories & Journeys</h3>
        <button class="btn btn-luxury-primary text-sm load-view-btn" data-view="search_rooms"><i class="bi bi-plus-lg me-1"></i> New Reservation Space</button>
    </div>

    <ul class="nav custom-tabs-luxury mb-4" id="bookingTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab">Active & Upcoming Plans</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab">Historical Archival Logs</button>
        </li>
    </ul>

    <div class="tab-content" id="bookingTabContent">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
            <div class="d-flex flex-column gap-4">
                
                <div class="luxury-card p-4 border-0 shadow-sm">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=300" alt="Room Space" class="img-fluid rounded-3 object-fit-cover w-100 height-140">
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="badge badge-gold-solid text-xs">Confirmed</span>
                                <span class="text-xs text-muted fw-mono">ID Reference: #GHR-2026-9941</span>
                            </div>
                            <h5 class="text-navy fw-semibold mb-1">Horizon Executive Suite</h5>
                            <p class="text-muted text-xs mb-2"><i class="bi bi-calendar3 me-1"></i> June 1, 2026 – June 7, 2026 • 6 Nights allocation</p>
                            <span class="text-sm fw-medium text-gold">$4,000.00 Total Bill</span>
                        </div>
                        <div class="col-md-3 text-md-end d-flex flex-md-column gap-2 justify-content-start w-xs-100">
                            <button class="btn btn-luxury-primary text-xs w-100 py-2 load-view-btn" data-view="booking_details">Examine Details</button>
                            <button class="btn btn-luxury-outline text-xs w-100 py-2 load-view-btn" data-view="modify_booking">Modify Plan</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="past" role="tabpanel">
            <div class="luxury-card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table custom-luxury-table align-middle m-0">
                        <thead>
                            <tr>
                                <th>Reserved Suite</th>
                                <th>Timeline Span</th>
                                <th>Total Settlement</th>
                                <th>Status Metric</th>
                                <th>Receipt Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-navy">Grand Horizon Studio Room</td>
                                <td class="text-muted text-sm">Jan 12 – Jan 15, 2026</td>
                                <td class="text-navy fw-medium">$1,050.00</td>
                                <td><span class="badge bg-secondary-subtle text-secondary px-2 py-1">Archived History</span></td>
                                <td><button class="btn btn-link text-gold text-xs p-0 load-view-btn" data-view="billing"><i class="bi bi-download me-1"></i> Get Receipt</button></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-navy">Ocean Deluxe Suite</td>
                                <td class="text-muted text-sm">Nov 04 – Nov 10, 2025</td>
                                <td class="text-navy fw-medium">$3,100.00</td>
                                <td><span class="badge bg-secondary-subtle text-secondary px-2 py-1">Archived History</span></td>
                                <td><button class="btn btn-link text-gold text-xs p-0 load-view-btn" data-view="billing"><i class="bi bi-download me-1"></i> Get Receipt</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>