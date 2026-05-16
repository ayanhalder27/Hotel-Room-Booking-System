<h2 class="page-title">Front Desk Dashboard</h2>
<p class="page-subtitle">Live overview of arrivals, departures, guests, rooms, service requests, and revenue.</p>
<div id="dashboardAlert" class="alert"></div>
<section class="grid grid-4" id="dashboardStats">
    <div class="card stat-card"><h3>Expected Check-ins</h3><div class="num" id="expectedCheckins">0</div><p>Today confirmed arrivals</p></div>
    <div class="card stat-card"><h3>Expected Check-outs</h3><div class="num" id="expectedCheckouts">0</div><p>Today scheduled departures</p></div>
    <div class="card stat-card"><h3>Checked-in Guests</h3><div class="num" id="checkedInGuests">0</div><p>Currently staying</p></div>
    <div class="card stat-card"><h3>Available Rooms</h3><div class="num" id="availableRooms">0</div><p>Ready for assignment</p></div>
    <div class="card stat-card"><h3>Occupied Rooms</h3><div class="num" id="occupiedRooms">0</div><p>In use now</p></div>
    <div class="card stat-card"><h3>Dirty Rooms</h3><div class="num" id="dirtyRooms">0</div><p>Need housekeeping</p></div>
    <div class="card stat-card"><h3>Pending Requests</h3><div class="num" id="pendingRequests">0</div><p>Guest service queue</p></div>
    <div class="card stat-card"><h3>Revenue Today</h3><div class="num" id="todayRevenue">0</div><p>Collected payments</p></div>
</section>
<br>
<section class="card">
    <div class="toolbar"><h3>Available Rooms by Type</h3><button class="btn btn-primary" onclick="loadDashboard()">Refresh</button></div>
    <div class="table-wrap"><table><thead><tr><th>Room Type</th><th>Available Rooms</th></tr></thead><tbody id="availableByTypeTable"><tr><td colspan="2" class="empty">Loading...</td></tr></tbody></table></div>
</section>
<script src="dashboard.js"></script>
