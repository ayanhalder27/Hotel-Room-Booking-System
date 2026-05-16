<h2 class="page-title">Guest Service Requests</h2>
<p class="page-subtitle">Manage pending and active requests from occupied rooms.</p>
<div id="serviceAlert" class="alert"></div>
<section class="card">
<div class="toolbar"><div class="filter-box"><input class="input" id="serviceSearch" placeholder="Search room, guest, service" onkeyup="loadServiceRequests()"><select class="select" id="serviceStatus" onchange="loadServiceRequests()"><option value="">All Status</option><option value="pending">Pending</option><option value="in_progress">In Progress</option><option value="completed">Completed</option></select></div><button class="btn btn-primary" onclick="loadServiceRequests()">Refresh</button></div>
<div class="table-wrap"><table><thead><tr><th>ID</th><th>Guest</th><th>Room</th><th>Service</th><th>Description</th><th>Status</th><th>Requested</th><th>Action</th></tr></thead><tbody id="serviceTable"><tr><td colspan="8" class="empty">Loading...</td></tr></tbody></table></div>
</section>
<script src="service_request.js"></script>
