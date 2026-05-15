<div class="container-fluid">

    <!-- Page Header -->
    <div class="dashboard-card mb-4">
        <h3>My Bookings</h3>
        <p>View all your upcoming and previous hotel reservations.</p>
    </div>

    <!-- Upcoming Bookings -->
    <div class="dashboard-card mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Upcoming Bookings</h5>
        </div>

        <div class="table-responsive custom-table">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Room Type</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#BK1021</td>
                        <td>Executive Suite</td>
                        <td>18 May 2026</td>
                        <td>21 May 2026</td>

                        <td>
                            <span class="badge bg-success">
                                Confirmed
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                View Details
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>#BK1025</td>
                        <td>Deluxe Room</td>
                        <td>25 May 2026</td>
                        <td>28 May 2026</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-outline-primary">
                                View Details
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- Past Bookings -->
    <div class="dashboard-card">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Past Bookings</h5>
        </div>

        <div class="table-responsive custom-table">

            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Room Type</th>
                        <th>Stay Duration</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Review</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>#BK1001</td>
                        <td>Premium Suite</td>
                        <td>10 Apr - 13 Apr</td>
                        <td>৳28,000</td>

                        <td>
                            <span class="badge bg-secondary">
                                Completed
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-primary-custom">
                                Write Review
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>#BK1002</td>
                        <td>Standard Room</td>
                        <td>01 Mar - 03 Mar</td>
                        <td>৳12,000</td>

                        <td>
                            <span class="badge bg-danger">
                                Cancelled
                            </span>
                        </td>

                        <td>
                            --
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>
