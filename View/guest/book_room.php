<div class="row g-4 animate-slide-up">
    <div class="col-lg-7">
        <div class="luxury-card p-4 border-0 shadow-sm mb-4">
            <h4 class="brand-serif text-navy mb-4">Secure Checkout Guarantee</h4>
            <form id="checkoutBookingForm" onsubmit="event.preventDefault();">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">First Name</label>
                        <input type="text" class="form-control" value="Alexander" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Last Name</label>
                        <input type="text" class="form-control" value="Mercer" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Contact Email</label>
                        <input type="email" class="form-control" value="alex.mercer@horizon.luxury" required>
                    </div>
                    
                    <div class="col-12 my-4">
                        <div class="p-3 rounded-3 bg-navy-light border border-gold-dim d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <i class="bi bi-gem text-gold fs-4"></i>
                                <div>
                                    <h6 class="mb-0 text-navy fw-semibold">Apply Loyalty Balance</h6>
                                    <small class="text-muted text-xs">Use points to claim an additional 10% Diamond discount</small>
                                </div>
                            </div>
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" id="applyPointsToggle" onchange="app.showToast('Loyalty incentive applied successfully!')">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Privilege Voucher Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="HORIZONELITE">
                            <button class="btn btn-luxury-outline text-xs px-3" type="button" onclick="app.showToast('Voucher verification validated.')">Apply</button>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Special Accommodations Notes</label>
                        <textarea class="form-control" rows="4" placeholder="High floor preferences, specific pillow material types, dietary constraints or airport flight arrivals timings..."></textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="luxury-card p-4 border-0 shadow-sm position-sticky top-20">
            <h5 class="brand-serif text-navy mb-3">Reservation Summary</h5>
            <div class="d-flex align-items-center gap-3 mb-4">
                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=150" alt="Selected Suite Thumbnail" class="rounded object-fit-cover square-80">
                <div>
                    <h6 class="text-navy mb-1 fw-semibold">Horizon Executive Suite</h6>
                    <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i> June 1 – June 7, 2026</small>
                    <small class="text-muted d-block"><i class="bi bi-people me-1"></i> 2 Adults allocated</small>
                </div>
            </div>

            <div class="d-flex flex-column gap-2 text-sm border-top border-bottom py-3 mb-4">
                <div class="d-flex justify-content-between text-muted">
                    <span>Base Room Fare</span>
                    <span>$3,720.00</span>
                </div>
                <div class="d-flex justify-content-between text-muted">
                    <span>Taxes & Service Surcharges</span>
                    <span>$430.00</span>
                </div>
                <div class="d-flex justify-content-between text-success">
                    <span>Privilege Discount</span>
                    <span>-$150.00</span>
                </div>
                <hr class="my-1">
                <div class="d-flex justify-content-between text-base fw-bold text-navy">
                    <span>Final Invoiced Bill</span>
                    <span>$4,000.00</span>
                </div>
            </div>

            <button type="button" class="btn btn-luxury-primary w-100 py-3 text-uppercase font-sans tracking-wider text-xs fw-semibold load-view-btn" data-view="booking_confirmation">Authorize & Commit Payment</button>
            <p class="text-center text-muted text-xs mt-3 mb-0"><i class="bi bi-shield-lock-fill me-1"></i> Encrypted end-to-end payment system</p>
        </div>
    </div>
</div>