<h2 class="page-title">Check In Guest</h2>
<p class="page-subtitle">Search booking, verify guest ID, assign room, and check guest in.</p>
<div id="checkinAlert" class="alert"></div>
<section class="card">
    <div class="toolbar"><input class="input" id="checkinSearch" placeholder="Search by booking ID or guest name"><button class="btn btn-primary" onclick="searchCheckinBooking()">Search</button></div>
    <div class="table-wrap"><table><thead><tr><th>Booking ID</th><th>Guest</th><th>ID Number</th><th>Room Type</th><th>Dates</th><th>Status</th><th>Action</th></tr></thead><tbody id="checkinBookingTable"><tr><td colspan="7" class="empty">Search a confirmed booking to check in.</td></tr></tbody></table></div>
</section>
<br>
<section class="card" id="assignRoomCard" style="display:none">
    <h3>Assign Physical Room</h3><br>
    <form id="checkinForm" onsubmit="submitCheckin(event)">
        <input type="hidden" id="bookingId" name="booking_id">
        <div class="form-grid">
            <div class="form-group"><label>Verify Guest ID Number</label><input class="input" id="verifyIdNumber" name="id_number" required></div>
            <div class="form-group"><label>Available Room</label><select class="select" id="availableRoomSelect" name="room_id" required></select></div>
            <div class="full action-row"><button class="btn btn-success" type="submit">Confirm Check-in</button><button class="btn btn-muted" type="button" onclick="resetCheckinForm()">Cancel</button></div>
        </div>
    </form>
</section>
<script src="checkin.js"></script>
