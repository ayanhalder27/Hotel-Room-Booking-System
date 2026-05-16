<h2 class="page-title">Register New Guest</h2>
<p class="page-subtitle">Create a guest profile for walk-in or future booking use.</p>
<div id="guestAlert" class="alert"></div>
<section class="card">
<form id="guestRegisterForm" onsubmit="submitGuestRegister(event)">
<div class="form-grid">
<div class="form-group"><label>Name</label><input class="input" name="name" required></div>
<div class="form-group"><label>Email</label><input class="input" type="email" name="email" required></div>
<div class="form-group"><label>Phone</label><input class="input" name="phone" required></div>
<div class="form-group"><label>Nationality</label><input class="input" name="nationality"></div>
<div class="form-group"><label>ID Number</label><input class="input" name="id_number" required></div>
<div class="form-group"><label>Password</label><input class="input" type="password" name="password" required></div>
<div class="full action-row"><button class="btn btn-success" type="submit">Register Guest</button><button class="btn btn-muted" type="reset">Clear</button></div>
</div>
</form>
</section>
<br>
<section class="card">
<div class="toolbar"><input class="input" id="guestSearch" placeholder="Live search guests" onkeyup="loadGuests()"><button class="btn btn-primary" onclick="loadGuests()">Refresh</button></div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>ID Number</th><th>Status</th></tr></thead><tbody id="guestTable"><tr><td colspan="6" class="empty">Loading...</td></tr></tbody></table></div>
</section>
<script src="walkin.js"></script>
