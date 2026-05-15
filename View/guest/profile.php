<div class="row g-4 animate-slide-up">
    <div class="col-lg-4">
        <div class="luxury-card p-4 border-0 shadow-sm text-center h-100 d-flex flex-column justify-content-center align-items-center">
            <div class="position-relative d-inline-block mb-3">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=200" alt="Avatar Asset" class="rounded-circle border border-gold border-3 shadow square-140 object-fit-cover">
                <button class="btn btn-luxury-primary btn-icon-sm position-absolute bottom-0 end-0 rounded-circle" onclick="app.showToast('Triggering image selection window...')"><i class="bi bi-camera"></i></button>
            </div>
            <h5 class="text-navy fw-semibold mb-1">Alexander Mercer</h5>
            <span class="badge badge-gold-outline text-uppercase tracking-wider text-xs mb-3">Diamond VIP Member</span>
            <p class="text-muted text-xs max-w-xs mb-0">Profile verification verified via secure identification tokens active since March 2023.</p>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="luxury-card p-4 border-0 shadow-sm">
            <ul class="nav custom-tabs-luxury mb-4" id="profileTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal Specifics</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">Access & Security Credentials</button>
                </li>
            </ul>

            <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                    <form id="profileIdentityForm" onsubmit="event.preventDefault();">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">First Given Name</label>
                                <input type="text" class="form-control" value="Alexander">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Last Family Name</label>
                                <input type="text" class="form-control" value="Mercer">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Contact Phone Line</label>
                                <input type="tel" class="form-control" value="+1 (555) 019-2834">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Secure Email Anchor</label>
                                <input type="email" class="form-control" value="alex.mercer@horizon.luxury" disabled>
                            </div>
                            <div class="col-12 pt-3 border-top d-flex justify-content-end">
                                <button type="submit" class="btn btn-luxury-primary px-4 py-2" onclick="app.showToast('Profile specific modifications updated.')">Save Modifications</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="security" role="tabpanel">
                    <form id="profileSecurityForm" onsubmit="event.preventDefault();">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Active Secure Password</label>
                                <input type="password" class="form-control" value="••••••••••••" placeholder="Enter original secret phrase">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">New Secret Phrase Block</label>
                                <input type="password" class="form-control" placeholder="Minimum 12 character metrics">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Confirm New Secret Phrase Block</label>
                                <input type="password" class="form-control" placeholder="Recheck secret metrics validation">
                            </div>
                            <div class="col-12 pt-3 border-top d-flex justify-content-end">
                                <button type="submit" class="btn btn-luxury-primary px-4 py-2" onclick="app.showToast('Authentication security phrases reassigned successfully.')">Reassign Password Set</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>