<section 
    data-page-title="Room Status Board" 
    data-page-script="room_status.js"
>
    <h2 class="page-title">Room Status Board</h2>
    <p class="page-subtitle">
        Live room status board with search, filters, and status updates.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Room status card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search room number"
            >
            <select class="select" id="statusFilter">
                <option value="">All Status</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="dirty">Dirty</option>
                <option value="maintenance">Maintenance</option>
                <option value="blocked">Blocked</option>
            </select>
            <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="roomTable"></tbody>
            </table>
        </div>
    </div>
</section>
