<div class="container-fluid">

    <!-- Welcome Section -->
    <div class="dashboard-card mb-4">
        <h3>Welcome Back, Niloy 👋</h3>
        <p>
            Manage your bookings, services, loyalty points and hotel activities from your dashboard.
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="row">

        <div class="col-md-4">
            <div class="summary-card">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>3</h3>
                <p>Total Bookings</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="summary-card">
                <i class="fa-solid fa-gift"></i>
                <h3>250</h3>
                <p>Loyalty Points</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="summary-card">
                <i class="fa-solid fa-bell-concierge"></i>
                <h3>2</h3>
                <p>Pending Services</p>
            </div>
        </div>

    </div>

    <!-- Recent Booking Table -->
    <div class="dashboard-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Recent Bookings</h5>

            <button class="btn btn-primary-custom">
                View All
            </button>
        </div>

        <div class="table-responsive custom-table">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Room</th>
                        <th>Check In</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#BK1021</td>
                        <td>Deluxe Room</td>
                        <td>18 May 2026</td>
                        <td>
                            <span class="badge bg-success">
                                Confirmed
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td>#BK1022</td>
                        <td>Suite Room</td>
                        <td>25 May 2026</td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>
