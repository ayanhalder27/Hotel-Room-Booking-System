<div class="container-fluid">
    <div class="dashboard-card mb-4">
        <h3>Book Room</h3>
        <p>Confirm your booking details and complete reservation.</p>
    </div>

    <div class="row">

        <!-- Booking Form -->
        <div class="col-lg-8 mb-4">

            <div class="dashboard-card">

                <form>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Check In Date</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Check Out Date</label>
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Number of Guests</label>

                            <select class="form-select">
                                <option>1 Guest</option>
                                <option>2 Guests</option>
                                <option>3 Guests</option>
                                <option>4 Guests</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Payment Method</label>

                            <select class="form-select">
                                <option>Cash</option>
                                <option>Card</option>
                                <option>bKash</option>
                                <option>Nagad</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Special Requests</label>

                            <textarea class="form-control"
                                      rows="4"
                                      placeholder="Write your special requests..."></textarea>
                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- Booking Summary -->
        <div class="col-lg-4">

            <div class="dashboard-card">

                <h4 class="mb-4">Booking Summary</h4>

                <div class="mb-3">

                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                         class="img-fluid rounded"
                         alt="Room">

                </div>

                <h5>Executive Suite</h5>

                <hr>

                <div class="d-flex justify-content-between mb-2">
                    <span>Price Per Night</span>
                    <strong>৳9500</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Total Nights</span>
                    <strong>3</strong>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span>Loyalty Discount</span>
                    <strong>- ৳500</strong>
                </div>

                <hr>

                <div class="d-flex justify-content-between mb-4">
                    <h5>Total Amount</h5>
                    <h5>৳28000</h5>
                </div>

                <button class="btn btn-primary-custom w-100">
                    Confirm Booking
                </button>

            </div>

        </div>

    </div>

</div>
