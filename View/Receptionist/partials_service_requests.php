<section 
    data-page-title="Service Requests" 
    data-page-script="service_request.js"
>
    <h2 class="page-title">Service Requests</h2>
    <p class="page-subtitle">
        Live manage pending, in-progress, and completed guest service requests.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Service requests card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search guest, room, type"
            >
            <select class="select" id="statusFilter">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
            <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="requestTable"></tbody>
            </table>
        </div>
    </div>
</section>
