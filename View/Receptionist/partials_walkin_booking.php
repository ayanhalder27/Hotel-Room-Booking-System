<h2 class="page-title">Walk-in Booking</h2>
<p class="page-subtitle">Register/select guest, find available room, create booking, billing, and check in immediately.</p>
<div id="walkinAlert" class="alert"></div>
<section class="card">
<form id="walkinForm" onsubmit="submitWalkinBooking(event)">
<div class="form-grid">
<div class="form-group"><label>Guest Name</label><input class="input" name="guest_name" id="guestName" required></div>
<div class="form-group"><label>Email</label><input class="input" type="email" name="email" id="guestEmail" required></div>
<div class="form-group"><label>Phone</label><input class="input" name="phone" id="guestPhone" required></div>
<div class="form-group"><label>ID Number</label><input class="input" name="id_number" id="guestIdNumber" required></div>
<div class="form-group"><label>Nationality</label><input class="input" name="nationality" id="nationality"></div>
<div class="form-group"><label>Number of Guests</label><input class="input" type="number" min="1" name="num_guests" id="numGuests" required></div>
<div class="form-group"><label>Check-out Date</label><input class="input" type="date" name="checkout_date" id="checkoutDate" required></div>
<div class="form-group"><label>Room Type</label><select class="select" name="room_type_id" id="roomTypeSelect" onchange="loadAvailableWalkinRooms()" required></select></div>
<div class="form-group"><label>Available Room</label><select class="select" name="room_id" id="walkinRoomSelect" required></select></div>
<div class="form-group"><label>Payment Method</label><select class="select" name="payment_method" id="paymentMethod"><option value="cash">Cash</option><option value="card">Card</option><option value="mobile_banking">Mobile Banking</option><option value="bank_transfer">Bank Transfer</option></select></div>
<div class="full action-row"><button class="btn btn-success" type="submit">Create Walk-in & Check In</button><button class="btn btn-muted" type="reset">Clear</button></div>
</div>
</form>
</section>
<script src="walkin.js"></script>
