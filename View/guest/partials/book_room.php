<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <h4 class="fw-bold text-navy mb-4"><i class="fa-solid fa-shield-check text-success me-2"></i>Secure Luxury Reservation Portal</h4>
                
                <form id="secureBookingForm" onsubmit="App.handleBookingConfirm(event)">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase tracking-wide">Primary Guest Registrant</label>
                            <input type="text" class="form-input bg-light" value="Sarah Jenkins" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase tracking-wide">Linked Email Endpoint</label>
                            <input type="email" class="form-input bg-light" value="sarah.j@enterprise.com" readonly>
                        </div>
                    </div>

                    <h5 class="text-navy fw-bold mb-3">Special Concierge Requests & Preferences</h5>
                    <div class="mb-4">
                        <textarea class="form-input" id="bookingNotes" rows="4" placeholder="Ex: Requesting high-floor assignments, specific feather-free pillows, early arrival tracking notifications, etc."></textarea>
                    </div>

                    <h5 class="text-navy fw-bold mb-3">Enterprise Loyalty Point Redemptions</h5>
                    <div class="p-3 bg-gold-subtle rounded-3 border border-gold-subtle d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-crown text-gold fs-4"></i>
                            <div>
                                <h6 class="m-0 fw-bold text-dark">Apply 4,000 Points Balance Balance</h6>
                                <p class="m-0 text-xs text-secondary">Instantly shave off **$40.00 USD** from your outstanding totals.</p>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-gold-switch" type="checkbox" id="redeemPointsSwitch" onchange="App.toggleLoyaltyDiscount(this)">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-navy btn-lg py-3 fw-bold tracking-wider text-uppercase"><i class="fa-solid fa-lock text-gold me-2"></i>Authorize Secure Reservation Ledger</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-4 sticky-lg-top" style="top: 110px;">
                <h5 class="text-navy fw-bold mb-3">Billing Invoice Statement</h5>
                
                <div class="d-flex gap-3 align-items-center bg-light p-3 rounded-3 mb-4">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=150&q=80" alt="Thumbnail" class="rounded object-fit-cover" style="width: 70px; height: 70px;">
                    <div>
                        <h6 class="m-0 fw-bold text-navy">Deluxe King Oceanfront</h6>
                        <span class="text-xs text-muted">Stay Duration: **3 Nights**</span>
                    </div>
                </div>

                <div class="d-flex flex-column gap-2 border-bottom pb-3 text-sm">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Base Nightly Rate ($220.00 × 3)</span>
                        <span class="font-monospace fw-semibold text-navy">$660.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Seasonal Holiday Surcharge Matrix</span>
                        <span class="font-monospace fw-semibold text-navy">+$45.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Resort Governance VAT Taxes (10%)</span>
                        <span class="font-monospace fw-semibold text-navy">+$70.50</span>
                    </div>
                    <div class="d-flex justify-content-between text-danger d-none" id="loyaltyDiscountRow">
                        <span>Loyalty Points Redemption Benefit</span>
                        <span class="font-monospace fw-bold">-$40.00</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-baseline mt-3 mb-4">
                    <h5 class="m-0 fw-bold text-navy text-uppercase tracking-wider">Total Booking Invoice:</h5>
                    <h3 class="m-0 fw-bold font-monospace text-gold" id="finalBookingTotal">$775.50</h3>
                </div>

                <div class="alert alert-light border-0 text-xs text-muted mb-0 d-flex gap-2">
                    <i class="fa-solid fa-circle-info text-navy mt-0.5"></i>
                    <span>By authorizing transactions, you accept the formal automated guest cancellation liability protocols of Grand Horizon Resorts & Spas.</span>
                </div>
            </div>
        </div>
    </div>
</div>