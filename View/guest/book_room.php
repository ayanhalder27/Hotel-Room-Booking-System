<div id="booking-section">

    <div class="dashboard-card">

        <h3 class="mb-4">Book Room</h3>

        <div id="booking-message"></div>

        <form id="booking-form">

            <input type="hidden"
                   name="room_type_id"
                   id="booking_room_type_id">

            <div class="mb-4">

                <h5 id="selected-room-name">
                    No Room Selected
                </h5>

                <p>
                    Price Per Night:
                    ৳<span id="selected-room-price">0</span>
                </p>

            </div>

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">
                        Check In Date
                    </label>

                    <input type="date"
                           class="form-control"
                           name="checkin_date"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Check Out Date
                    </label>

                    <input type="date"
                           class="form-control"
                           name="checkout_date"
                           required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">
                        Number of Guests
                    </label>

                    <input type="number"
                           class="form-control"
                           name="num_guests"
                           min="1"
                           required>
                </div>

                <div class="col-12">

                    <label class="form-label">
                        Special Requests
                    </label>

                    <textarea class="form-control"
                              rows="4"
                              name="special_requests"></textarea>

                </div>

            </div>

            <button type="submit"
                    class="btn btn-primary-custom mt-4">

                Confirm Booking

            </button>

        </form>

    </div>

</div>