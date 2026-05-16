<div class="container-fluid">

    <div class="page-title">
        <h2>Walk-In Booking</h2>
    </div>


    <div class="table-section">

        <form id="walkinForm">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Guest Name</label>

                    <input
                        type="text"
                        name="guest_name"
                        class="form-control"
                        required
                    >
                </div>


                <div class="col-md-6 mb-3">
                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required
                    >
                </div>


                <div class="col-md-6 mb-3">
                    <label>Phone</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        required
                    >
                </div>


                <div class="col-md-6 mb-3">
                    <label>Room ID</label>

                    <input
                        type="number"
                        name="room_id"
                        class="form-control"
                        required
                    >
                </div>


                <div class="col-md-6 mb-3">
                    <label>Check-In Date</label>

                    <input
                        type="date"
                        name="checkin_date"
                        class="form-control"
                        required
                    >
                </div>


                <div class="col-md-6 mb-3">
                    <label>Check-Out Date</label>

                    <input
                        type="date"
                        name="checkout_date"
                        class="form-control"
                        required
                    >
                </div>

            </div>


            <button
                type="button"
                class="btn btn-primary"
                onclick="createWalkinBooking()"
            >
                Create Booking
            </button>

        </form>

    </div>

</div>