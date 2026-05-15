<div class="container-fluid p-0">
    <div class="card border-0 shadow-sm p-4 rounded-4 max-w-xl mx-auto bg-white" style="max-width: 650px;">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div class="p-3 bg-navy-subtle rounded-3 text-navy fs-4"><i class="fa-solid fa-calendar-minus"></i></div>
            <div>
                <h4 class="m-0 fw-bold text-navy">Request Schedule Modification</h4>
                <p class="m-0 text-muted text-xs">Targets Active Itinerary ID Token: **#GH-2026-88412**</p>
            </div>
        </div>

        <div class="alert alert-light border-0 text-xs text-secondary p-3 mb-4 d-flex gap-2">
            <i class="fa-solid fa-circle-exclamation text-warning mt-0.5 fs-6"></i>
            [cite_start]<span>All framework modifications are piped live directly to front-desk receptionist dashboards for manual verification processing depending on real-time occupancy loads[cite: 61, 85].</span>
        </div>

        <form id="bookingModificationForm" onsubmit="App.handleModificationSubmit(event)">
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label class="form-label text-xs fw-bold text-muted text-uppercase">Current Start Window</label>
                    <input type="text" class="form-input bg-light text-muted" value="May 24, 2026" readonly>
                </div>
                <div class="col-sm-6">
                    <label class="form-label text-xs fw-bold text-muted text-uppercase">Current Departure Target</label>
                    <input type="text" class="form-input bg-light text-muted" value="May 27, 2026" readonly>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <label class="form-label text-xs fw-bold text-navy text-uppercase">Proposed New Check-In</label>
                    <input type="date" class="form-input border-gold-focus" id="modNewCheckIn" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label text-xs fw-bold text-navy text-uppercase">Proposed New Check-Out</label>
                    <input type="date" class="form-input border-gold-focus" id="modNewCheckOut" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-xs fw-bold text-muted text-uppercase">Justification / Reason for Request</label>
                <textarea class="form-input" id="modReason" rows="3" placeholder="Please provide details regarding scheduling changes for front-desk reviews..." required></textarea>
            </div>

            <div class="d-flex gap-3 justify-content-end">
                <button type="button" class="btn btn-light text-sm px-4" onclick="App.loadPartial('my_bookings')">Abort Execution</button>
                <button type="submit" class="btn btn-navy text-sm px-4 fw-bold">Submit Modification Ticket</button>
            </div>
        </form>
    </div>
</div>