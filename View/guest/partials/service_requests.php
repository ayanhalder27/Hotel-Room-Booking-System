<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-xl-5 col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h4 class="fw-bold text-navy mb-4"><i class="fa-solid fa-bell-concierge text-gold me-2"></i>In-Stay Service Ticket Dispatch</h4>
                
                <form id="serviceRequestForm" onsubmit="App.handleServiceSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Target Active Stay Scope</label>
                        <select class="form-input" id="serviceBookingId">
                            <option value="88412">Active Stay: Room #712 (Deluxe King)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-navy text-uppercase">Service Pipeline Category</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="srvCategory" id="srvBed" value="extra_bed" checked>
                                <label class="btn btn-outline-light text-dark w-100 text-sm border p-2.5 text-start" for="srvBed"><i class="fa-solid fa-bed text-gold me-2"></i> Extra Bedding</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="srvCategory" id="srvToiletries" value="toiletries">
                                <label class="btn btn-outline-light text-dark w-100 text-sm border p-2.5 text-start" for="srvToiletries"><i class="fa-solid fa-pump-soap text-gold me-2"></i> Fresh Amenities</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="srvCategory" id="srvDining" value="room_service">
                                <label class="btn btn-outline-light text-dark w-100 text-sm border p-2.5 text-start" for="srvDining"><i class="fa-solid fa-utensils text-gold me-2"></i> Fine Room Dining</label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="srvCategory" id="srvLaundry" value="laundry">
                                <label class="btn btn-outline-light text-dark w-100 text-sm border p-2.5 text-start" for="srvLaundry"><i class="fa-solid fa-shirt text-gold me-2"></i> Premium Valet</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Bespoke Specifications / Delivery Notes</label>
                        <textarea class="form-input" id="serviceDescription" rows="4" placeholder="Ex: Send 2 bottles of sparkling thermal mineral water along with fresh towels as soon as possible, please." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-navy w-100 py-2.5 fw-bold text-uppercase tracking-wider">Transmit To Front Desk Queue</button>
                </form>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card border-0 shadow-sm p-0 rounded-4 overflow-hidden bg-white">
                <div class="p-4 border-bottom">
                    <h5 class="m-0 text-navy fw-bold">Live Active Pipeline Tracking Center</h5>
                </div>
                
                <div class="p-4 d-flex flex-column gap-3" id="serviceTrackerContainer">
                    
                    <div class="p-3 border rounded-3 bg-white shadow-2xs d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-start gap-3">
                            <div class="p-2.5 bg-gold-subtle text-gold rounded-3 fs-5"><i class="fa-solid fa-utensils"></i></div>
                            <div>
                                <span class="badge bg-navy text-white text-xxs font-monospace px-2 py-0.5 mb-1">TICKET #SR-99120</span>
                                <h6 class="m-0 text-navy fw-bold text-sm">Fine Room Dining Gourmet Package</h6>
                                <p class="text-xs text-muted mt-1 mb-2">"Medium-rare Wagyu Ribeye cut option with truffle fries payload delivery."</p>
                                <span class="text-xxs text-secondary font-monospace"><i class="fa-regular fa-clock me-1"></i>Dispatched Today, 1:45 PM</span>
                            </div>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 text-xxs font-monospace rounded-pill">IN_PROGRESS</span>
                    </div>

                    <div class="p-3 border rounded-3 bg-light opacity-75 d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-start gap-3">
                            <div class="p-2.5 bg-secondary-subtle text-secondary rounded-3 fs-5"><i class="fa-solid fa-pump-soap"></i></div>
                            <div>
                                <span class="badge bg-secondary text-white text-xxs font-monospace px-2 py-0.5 mb-1">TICKET #SR-90114</span>
                                <h6 class="m-0 text-muted fw-bold text-sm">Fresh Amenities & Balenciaga Toiletries</h6>
                                <p class="text-xs text-muted mt-1 mb-2">"Extra aromatic skin oils replenishment requested."</p>
                                <span class="text-xxs text-secondary font-monospace"><i class="fa-regular fa-clock me-1"></i>Resolved May 14, 4:10 PM</span>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 text-xxs font-monospace rounded-pill">COMPLETED</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>