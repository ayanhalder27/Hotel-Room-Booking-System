<div class="container-fluid">

    <div class="dashboard-card mb-4">
        <h3>Modify Booking Request</h3>
        <p>Request changes to your booking dates. Receptionist approval is required.</p>
    </div>

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="dashboard-card">

                <form>

                    <div class="mb-3">
                        <label class="form-label">Select Booking</label>

                        <select class="form-select">
                            <option>#BK1021 - Executive Suite</option>
                            <option>#BK1025 - Deluxe Room</option>
                        </select>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Current Check In</label>
                            <input type="text"
                                   class="form-control"
                                   value="18 May 2026"
                                   readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Current Check Out</label>
                            <input type="text"
                                   class="form-control"
                                   value="21 May 2026"
                                   readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">New Check In</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">New Check Out</label>
                            <input type="date" class="form-control">
                        </div>

                    </div>

                    <div class="mt-4 mb-4">

                        <label class="form-label">
                            Reason For Modification
                        </label>

                        <textarea class="form-control"
                                  rows="5"
                                  placeholder="Write your reason..."></textarea>

                    </div>

                    <button class="btn btn-primary-custom">
                        Submit Modification Request
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
