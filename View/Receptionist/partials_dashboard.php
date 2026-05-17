<section 
    data-page-title="Receptionist Dashboard" 
    data-page-script="dashboard.js"
>
    <h2 class="page-title">Front Desk Dashboard</h2>
    <p class="page-subtitle">
        Live overview of arrivals, departures, rooms, requests, and revenue.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Dashboard stats grid -->
    <div class="grid grid-4" id="dashboardStats"></div>

    <!-- Available rooms card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <h3>Available Rooms by Type</h3>
            <button class="btn btn-primary" id="refreshDashboard">Refresh</button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Room Type</th>
                        <th>Available Rooms</th>
                    </tr>
                </thead>
                <tbody id="roomTypeTable">
                    <tr>
                        <td colspan="2" class="loading">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
