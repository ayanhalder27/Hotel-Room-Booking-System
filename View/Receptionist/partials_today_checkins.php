<h2 class="page-title">Today's Check-in List</h2>
<p class="page-subtitle">Confirmed bookings with check-in date today, sorted by booking time.</p>
<div id="checkinListAlert" class="alert"></div>
<section class="card">
    <div class="toolbar">
        <div class="search-box"><input class="input" id="todayCheckinSearch" placeholder="Search guest name or booking ID" onkeyup="loadTodayCheckins()"></div>
        <button class="btn btn-primary" onclick="loadTodayCheckins()">Refresh</button>
    </div>
    <div class="table-wrap"><table><thead><tr><th>Booking ID</th><th>Guest</th><th>Room Type</th><th>Check-in</th><th>Check-out</th><th>Guests</th><th>Total</th><th>Action</th></tr></thead><tbody id="todayCheckinsTable"><tr><td colspan="8" class="empty">Loading...</td></tr></tbody></table></div>
</section>
<script src="dashboard.js"></script>
