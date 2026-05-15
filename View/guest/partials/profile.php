<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm p-4 text-center rounded-4 bg-white">
                <div class="position-relative d-inline-block mx-auto mb-3">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80" alt="Avatar Huge" class="rounded-circle border border-4 border-white shadow img-thumbnail" style="width: 140px; height: 140px; object-fit: cover;">
                    <button class="btn btn-navy btn-sm rounded-circle position-absolute bottom-0 end-0 p-2 border border-2 border-white shadow-sm" type="button" onclick="document.getElementById('avatarFileInput').click()"><i class="fa-solid fa-camera text-xs text-gold"></i></button>
                    <input type="file" id="avatarFileInput" class="d-none" accept="image/*" onchange="App.handleAvatarUpload(this)">
                </div>
                <h5 class="text-navy fw-bold m-0">Sarah Jenkins</h5>
                <span class="text-muted text-xs font-monospace d-block mb-3">System Identity Token: #USR-990812</span>
                <span class="badge bg-gold text-dark font-monospace text-xs px-3 py-1.5 rounded-pill fw-bold"><i class="fa-solid fa-crown me-1"></i>GOLD ELITE PRIVILEGES</span>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white mb-4">
                <h5 class="text-navy fw-bold mb-4"><i class="fa-solid fa-id-card text-gold me-2"></i>Personal Master Identity File</h5>
                
                <form id="profileIdentityForm" onsubmit="App.handleProfileUpdate(event)">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase">Full Legal Appellation</label>
                            <input type="text" class="form-input" value="Sarah Jenkins" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase">Phone Linkage Contact</label>
                            <input type="text" class="form-input" value="+1 (555) 019-2834" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase">Declared Nationality</label>
                            <input type="text" class="form-input" value="American" required>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-muted text-uppercase">Passport / Government ID Number</label>
                            <input type="text" class="form-input" value="A-990812-X" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-navy text-sm px-4 fw-bold">Commit Information Changes</button>
                </form>
            </div>

            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h5 class="text-navy fw-bold mb-4"><i class="fa-solid fa-shield-halved text-danger me-2"></i>Account Security Parameters</h5>
                
                <form id="profileSecurityForm" onsubmit="App.handlePasswordChange(event)">
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Current Secret Key Token</label>
                        <input type="password" class="form-input" required placeholder="••••••••••••">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-navy text-uppercase">Proposed New Key Passphrase</label>
                            <input type="password" class="form-input" required placeholder="Enter strong new key">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-xs fw-bold text-navy text-uppercase">Re-Verify Key Passphrase</label>
                            <input type="password" class="form-input" required placeholder="Repeat target key">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-navy text-sm px-4 fw-bold">Rotate Security Credentials</button>
                </form>
            </div>
        </div>
    </div>
</div>