<div class="container-fluid">

    <div class="dashboard-card mb-4">
        <h3>Service Requests</h3>
        <p>Request hotel services during your stay and track request status.</p>
    </div>

    <div class="row">

        <!-- Request Form -->
        <div class="col-lg-5 mb-4">

            <div class="dashboard-card">

                <h5 class="mb-4">Create Service Request</h5>

                <form>

                    <div class="mb-3">
                        <label class="form-label">Booking</label>

                        <select class="form-select">
                            <option>#BK1021 - Executive Suite</option>
                            <option>#BK1025 - Deluxe Room</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Service Type</label>

                        <select class="form-select">
                            <option>Extra Bed</option>
                            <option>Toiletries</option>
                            <option>Laundry</option>
                            <option>Room Service</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Description</label>

                        <textarea class="form-control"
                                  rows="5"
                                  placeholder="Write request details..."></textarea>
                    </div>

                    <button class="btn btn-primary-custom w-100">
                        Submit Request
                    </button>

                </form>

            </div>

        </div>

        <!-- Request History -->
        <div class="col-lg-7">

            <div class="dashboard-card">

                <h5 class="mb-4">Recent Requests</h5>

                <div class="table-responsive custom-table">

                    <table class="table align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Service</th>
                                <th>Booking</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>Laundry</td>
                                <td>#BK1021</td>
                                <td>14 May 2026</td>

                                <td>
                                    <span class="badge bg-warning text-dark">
                                        In Progress
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Extra Bed</td>
                                <td>#BK1021</td>
                                <td>13 May 2026</td>

                                <td>
                                    <span class="badge bg-success">
                                        Completed
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
