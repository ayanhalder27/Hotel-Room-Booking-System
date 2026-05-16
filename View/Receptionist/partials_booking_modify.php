<h2 class="page-title">Booking Modification</h2>
<p class="page-subtitle">Change dates or guest count after checking room availability.</p>
<div id="modifyAlert" class="alert"></div>
<section class="card">
<div class="toolbar"><input class="input" id="modifySearch" placeholder="Search booking ID or guest name"><button class="btn btn-primary" onclick="searchBookingForModify()">Search</button></div>
<div class="table-wrap"><table><thead><tr><th>Booking</th><th>Guest</th><th>Room Type</th><th>Check-in</th><th>Check-out</th><th>Guests</th><th>Status</th><th>Action</th></tr></thead><tbody id="modifyTable"><tr><td colspan="8" class="empty">Search a booking to modify.</td></tr></tbody></table></div>
</section>
<br>
<section class="card" id="modifyCard" style="display:none">
<form id="modifyForm" onsubmit="submitBookingModify(event)">
<input type="hidden" id="modifyBookingId" name="booking_id">
<div class="form-grid">
<div class="form-group"><label>New Check-in Date</label><input class="input" type="date" name="checkin_date" id="newCheckinDate" required></div>
<div class="form-group"><label>New Check-out Date</label><input class="input" type="date" name="checkout_date" id="newCheckoutDate" required></div>
<div class="form-group"><label>Number of Guests</label><input class="input" type="number" min="1" name="num_guests" id="newNumGuests" required></div>
<div class="form-group"><label>Request Type</label><select class="select" name="request_type"><option value="normal_modify">Normal Modification</option><option value="early_checkin">Early Check-in</option><option value="late_checkout">Late Checkout</option></select></div>
<div class="full action-row"><button class="btn btn-warning" type="button" onclick="checkModifyAvailability()">Check Availability</button><button class="btn btn-success" type="submit">Update Booking</button></div>
</div>
</form>
</section>
<script src="booking_modify.js"></script>
