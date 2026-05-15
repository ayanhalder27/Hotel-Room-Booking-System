<div class="row g-4 animate-slide-up">
    <div class="col-xl-4 col-lg-5">
        <div class="luxury-card p-4 border-0 shadow-sm h-100">
            <h4 class="brand-serif text-navy mb-4">Deploy Digital Concierge Order</h4>
            <form id="serviceRequestForm" onsubmit="event.preventDefault();">
                <div class="mb-3">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Target Association Stay</label>
                    <select class="form-select">
                        <option value="9941">Suite 3412 (#GHR-2026-9941)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Service Amenity Category</label>
                    <select class="form-select" id="serviceCategorySelector">
                        <option value="dining">Fine Dining In-Room Catering</option>
                        <option value="housekeeping">Sanitary Housekeeping Refresh</option>
                        <option value="valet">Valet Logistic / Chauffeur Service</option>
                        <option value="spa">Spa Wellness Treatment Booking</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Specific Instruction Specifications</label>
                    <textarea class="form-control" rows="5" placeholder="Specify food allergy configurations, preferred arrival delivery times, or extra linen counts..." required></textarea>
                </div>
                <button type="submit" class="btn btn-luxury-primary w-100 py-2-5 text-sm" onclick="app.showToast('Concierge dispatch order transmitted successfully.')">Transmit Request Order</button>
            </form>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="luxury-card p-4 border-0 shadow-sm h-100">
            <h5 class="brand-serif text-navy mb-4">Active Operations Tracking Log</h5>
            <div class="d-flex flex-column gap-3">
                
                <div class="p-3 rounded-3 border d-flex flex-column gap-3 transition-base hover-shadow-sm">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-3">
                            <div class="square-icon bg-navy-light text-gold"><i class="bi bi-egg-fried"></i></div>
                            <div>
                                <h6 class="mb-0 text-navy fw-semibold">Belgian Waffle Breakfast Deck & Coffee Delivery</h6>
                                <small class="text-xs text-muted">Dispatched Code: #SRQ-8821 • Requested for Tomorrow 08:30 AM</small>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-dim px-2 py-1 text-xs">In Kitchen Preparation</span>
                    </div>
                    <div class="bg-smooth p-2.5 rounded text-xs text-muted">
                        <strong>Live Status Update:</strong> Pastry station chefs are assembling your customized order package.
                    </div>
                </div>

                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2 opacity-75">
                    <div class="d-flex align-items-center gap-3">
                        <div class="square-icon bg-light text-muted"><i class="bi bi-wind"></i></div>
                        <div>
                            <h6 class="mb-0 text-muted fw-semibold">Hypoallergenic Down-Pillow Refresh Pack</h6>
                            <small class="text-xs text-muted">Dispatched Code: #SRQ-7712 • Completed Today 11:15 AM</small>
                        </div>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-dim px-2 py-1 text-xs">Fulfilled & Executed</span>
                </div>

            </div>
        </div>
    </div>
</div>