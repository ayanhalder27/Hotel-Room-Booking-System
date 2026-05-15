<div class="row g-4 animate-slide-up">
    <div class="col-12 d-flex align-items-center gap-3 mb-2">
        <button class="btn btn-luxury-outline btn-sm load-view-btn" data-view="my_bookings"><i class="bi bi-arrow-left"></i></button>
        <h3 class="brand-serif text-navy mb-0">Adjust Schedule Parameters: #GHR-2026-9941</h3>
    </div>

    <div class="col-lg-8">
        <div class="luxury-card p-4 border-0 shadow-sm">
            <div class="alert alert-warning border-0 text-sm mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Schedule updates depend heavily on real-time availability. Additional structural seasonal rate differences may apply.
            </div>

            <form id="modifyBookingForm" onsubmit="event.preventDefault();">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Adjusted Checked-In Date Target</label>
                        <input type="date" class="form-control" value="2026-06-03">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Adjusted Checked-Out Date Target</label>
                        <input type="date" class="form-control" value="2026-06-09">
                    </div>
                    <div class="col-12">
                        <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Core Reasons or Rationales for Parameters Adjustment</label>
                        <textarea class="form-control" rows="4" placeholder="Please clarify specific timeline shift constraints to optimize front desk concierge execution approval workflows..." required></textarea>
                    </div>
                    <div class="col-12 pt-2 border-top d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-luxury-outline px-4 load-view-btn" data-view="my_bookings">Cancel</button>
                        <button type="submit" class="btn btn-luxury-primary px-4" onclick="app.showToast('Modification parameters submitted to operations desk execution queues.')">Transmit Modification Query</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="luxury-card p-4 border-0 shadow-sm bg-navy text-white">
            <h5 class="brand-serif text-gold mb-3">Active Scope Blueprint</h5>
            <div class="text-sm d-flex flex-column gap-3 opacity-90">
                <div>
                    <span class="text-white-50 text-xs d-block tracking-wider uppercase">Active In-Use Plan</span>
                    <span class="fw-medium">June 1 – June 7, 2026</span>
                </div>
                <div>
                    <span class="text-white-50 text-xs d-block tracking-wider uppercase">Assigned Space Unit</span>
                    <span class="fw-medium">Horizon Executive Suite</span>
                </div>
                <hr class="border-white-50 my-1">
                <p class="text-xs mb-0 text-white-50"><i class="bi bi-info-circle me-1"></i> Reception operations typically audit adjustment requests within 30 minutes.</p>
            </div>
        </div>
    </div>
</div>