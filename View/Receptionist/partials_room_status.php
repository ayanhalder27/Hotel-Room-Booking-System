<h2 class="page-title">Room Status Board</h2>
<p class="page-subtitle">Live room status with search and filters.</p>
<div id="roomAlert" class="alert"></div>
<section class="card">
<div class="toolbar"><div class="filter-box"><input class="input" id="roomSearch" placeholder="Search room number" onkeyup="loadRoomStatus()"><select class="select" id="roomStatusFilter" onchange="loadRoomStatus()"><option value="">All Status</option><option value="available">Available</option><option value="occupied">Occupied</option><option value="dirty">Dirty</option><option value="maintenance">Maintenance</option><option value="blocked">Blocked</option></select><select class="select" id="roomTypeFilter" onchange="loadRoomStatus()"><option value="">All Types</option></select></div><button class="btn btn-primary" onclick="loadRoomStatus()">Refresh</button></div>
<div class="table-wrap"><table><thead><tr><th>Room</th><th>Type</th><th>Floor</th><th>Status</th><th>Notes</th></tr></thead><tbody id="roomStatusTable"><tr><td colspan="5" class="empty">Loading...</td></tr></tbody></table></div>
</section>
<script src="room_status.js"></script>
