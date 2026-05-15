<div class="container-fluid">

    <div class="dashboard-card mb-4">
        <h3>Reviews & Ratings</h3>
        <p>Share your hotel experience and manage your reviews.</p>
    </div>

    <!-- Review Form -->
    <div class="dashboard-card mb-4">

        <h5 class="mb-4">Write Review</h5>

        <form>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Booking</label>

                    <select class="form-select">
                        <option>#BK1001 - Executive Suite</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Overall Rating</label>

                    <select class="form-select">
                        <option>5 Star</option>
                        <option>4 Star</option>
                        <option>3 Star</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Cleanliness Rating</label>

                    <select class="form-select">
                        <option>5 Star</option>
                        <option>4 Star</option>
                        <option>3 Star</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Service Rating</label>

                    <select class="form-select">
                        <option>5 Star</option>
                        <option>4 Star</option>
                        <option>3 Star</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Review</label>

                    <textarea class="form-control"
                              rows="5"
                              placeholder="Write your review..."></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary-custom">
                        Submit Review
                    </button>
                </div>

            </div>

        </form>

    </div>

    <!-- Review History -->
    <div class="dashboard-card">

        <h5 class="mb-4">My Reviews</h5>

        <div class="mb-4 border-bottom pb-4">

            <div class="d-flex justify-content-between mb-2">

                <h5>Executive Suite</h5>

                <span class="badge bg-success">
                    5 Star
                </span>

            </div>

            <p class="text-muted">
                Stayed on 10 Apr 2026
            </p>

            <p>
                Excellent room quality and very professional hotel service.
            </p>

            <div class="d-flex gap-2">

                <button class="btn btn-sm btn-outline-primary">
                    Edit
                </button>

                <button class="btn btn-sm btn-outline-danger">
                    Delete
                </button>

            </div>

        </div>

    </div>

</div>
