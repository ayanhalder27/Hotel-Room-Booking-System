<div class="container-fluid p-0">
    <button class="btn btn-link text-decoration-none text-navy p-0 mb-4 fw-bold" onclick="App.loadPartial('my_bookings')">
        <i class="fa-solid fa-arrow-left-long me-2"></i> Return to Your List View
    </button>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h4 class="m-0 text-navy fw-bold">Folio Audit Matrix Log #GH-2026-88412</h4>
                    <span class="badge bg-gold text-dark px-3 py-1.5 font-monospace text-xs rounded-pill">VERIFIED IMMUTABLE</span>
                </div>

                <div class="booking-timeline-wrapper py-3 mb-5 position-relative">
                    <div class="progress timeline-progress-backline position-absolute top-50 start-0 translate-middle-y w-100" style="height: 4px; z-index: 1;"><div class="progress-bar bg-gold" style="width: 25%"></div></div>
                    <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                        <div class="text-center timeline-node active">
                            <div class="node-circle rounded-circle bg-navy text-white mx-auto d-flex align-items-center justify-content-center border border-4 border-white shadow-sm mb-2" style="width: 36px; height: 36px;"><i class="fa-solid fa-check text-xs"></i></div>
                            <span class="text-xs fw-bold text-navy d-block">Reservation Formed</span>
                            <span class="text-xxs text-muted font-monospace">May 15, 1:59 PM</span>
                        </div>
                        <div class="text-center timeline-node">
                            <div class="node-circle rounded-circle bg-white text-muted mx-auto d-flex align-items-center justify-content-center border border-4 border-light shadow-sm mb-2" style="width: 36px; height: 36px;"><i class="fa-solid fa-key text-xs"></i></div>
                            <span class="text-xs fw-semibold text-muted d-block">Checked Arrived</span>
                            <span class="text-xxs text-muted font-monospace">Pending Check-in</span>
                        </div>
                        <div class="text-center timeline-node">
                            <div class="node-circle rounded-circle bg-white text-muted mx-auto d-flex align-items-center justify-content-center border border-4 border-light shadow-sm mb-2" style="width: 36px; height: 36px;"><i class="fa-solid fa-door-closed text-xs"></i></div>
                            <span class="text-xs fw-semibold text-muted d-block">In-Stay Active</span>
                            <span class="text-xxs text-muted font-monospace">-</span>
                        </div>
                        <div class="text-center timeline-node">
                            <div class="node-circle rounded-circle bg-white text-muted mx-auto d-flex align-items-center justify-content-center border border-4 border-light shadow-sm mb-2" style="width: 36px; height: 36px;"><i class="fa-solid fa-circle-dollar-to-slot text-xs"></i></div>
                            <span class="text-xs fw-semibold text-muted d-block">Settled Complete</span>
                            <span class="text-xxs text-muted font-monospace">-</span>
                        </div>
                    </div>
                </div>

                <h5 class="text-navy fw-bold mb-3">Room Deployment Space Properties</h5>
                <div class="row border rounded-3 p-3 g-3 bg-light-subtle mb-4">
                    <div class="col-sm-4"><strong>Assigned Class:</strong> <span class="text-secondary d-block text-sm">Deluxe King Oceanfront</span></div>
                    <div class="col-sm-4"><strong>Target Floor Mapping:</strong> <span class="text-secondary d-block text-sm">Floor 7 (Room #712)</span></div>
                    <div class="col-sm-4"><strong>Capacity Limit:</strong> <span class="text-secondary d-block text-sm">3 Adults Max Allowed</span></div>
                </div>

                <h5 class="text-navy fw-bold mb-3">Concierge Log Notes File</h5>
                <div class="p-3 border rounded-3 bg-light text-secondary text-sm italic mb-0">
                    "Guest requests an optimization swap for higher-tier panoramic ocean floor views if available at target checklist processing windows. Hypoallergenic micro-fiber bedding arrays requested."
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mb-4">
                <h5 class="text-navy fw-bold mb-3">Financial Allocation Ledger</h5>
                <div class="d-flex flex-column gap-2 text-sm border-bottom pb-3 mb-3">
                    <div class="d-flex justify-content-between"><span class="text-muted">Room Aggregates Base:</span> <span class="font-monospace fw-semibold">$660.00</span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Holiday Surcharge Index:</span> <span class="font-monospace fw-semibold">+$45.00</span></div>
                    <div class="d-flex justify-content-between"><span class="text-muted">Resort Governance Tax:</span> <span class="font-monospace fw-semibold">+$70.50</span></div>
                </div>
                <div class="d-flex justify-content-between align-items-baseline mb-4">
                    <span class="fw-bold text-navy text-xs text-uppercase tracking-wide">Gross Amount:</span>
                    <h3 class="m-0 font-monospace fw-bold text-gold">$775.50</h3>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-navy text-sm py-2" onclick="App.loadPartial('service_requests')"><i class="fa-solid fa-concierge-bell me-2"></i>Order Room Services</button>
                    <button class="btn btn-outline-danger text-sm py-2" onclick="App.cancelBookingTrigger('#GH-2026-88412')">Cancel This Reservation</button>
                </div>
            </div>
        </div>
    </div>
</div>