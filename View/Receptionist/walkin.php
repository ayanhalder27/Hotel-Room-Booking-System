<div class="container-fluid">

    <div class="page-title">
        <h2>Walk-In Booking</h2>
    </div>


    <div class="table-section">

        <form id="walkinForm">

            <div class="row">


                <!-- GUEST NAME -->
                <div class="col-md-6 mb-3">

                    <label>Guest Name</label>

                    <input
                        type="text"
                        name="guest_name"
                        class="form-control"
                        placeholder="Enter guest name"
                        required
                    >

                </div>



                <!-- EMAIL -->
                <div class="col-md-6 mb-3">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter email"
                        required
                    >

                </div>



                <!-- PHONE -->
                <div class="col-md-6 mb-3">

                    <label>Phone</label>

                    <input
                        type="text"
                        name="phone"
                        class="form-control"
                        placeholder="Enter phone number"
                        required
                    >

                </div>



                <!-- ROOM -->
                <div class="col-md-6 mb-3">

                    <label>Select Room</label>

                    <select
                        name="room_id"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Select Room
                        </option>

                        <option value="3001">
                            Room 101
                        </option>

                        <option value="3002">
                            Room 102
                        </option>

                        <option value="3003">
                            Room 201
                        </option>

                        <option value="3004">
                            Room 202
                        </option>

                        <option value="3005">
                            Room 301
                        </option>

                    </select>

                </div>



                <!-- CHECKIN -->
                <div class="col-md-6 mb-3">

                    <label>Check-In Date</label>

                    <input
                        type="date"
                        name="checkin_date"
                        class="form-control"
                        required
                    >

                </div>



                <!-- CHECKOUT -->
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



            <!-- BUTTON -->
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