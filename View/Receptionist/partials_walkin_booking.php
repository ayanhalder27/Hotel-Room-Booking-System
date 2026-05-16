<section 
    data-page-title="Walk-in Booking" 
    data-page-script="walkin.js"
>
    <h2 class="page-title">Walk-in Booking</h2>
    <p class="page-subtitle">
        Create a guest, booking, billing record, and check in immediately using AJAX.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Walk-in booking form card -->
    <div class="card">
        <form id="walkinForm" class="form-grid">
            <div class="form-group">
                <label>Guest Name</label>
                <input class="input" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input class="input" name="email" type="email" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input class="input" name="phone" required>
            </div>

            <div class="form-group">
                <label>National ID</label>
                <input class="input" name="national_id" required>
            </div>

            <div class="form-group">
                <label>Nationality</label>
                <input class="input" name="nationality" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input class="input" name="username" required>
            </div>

            <div class="form-group">
                <label>Check-in Date</label>
                <input class="input" name="checkin_date" type="date" required>
            </div>

            <div class="form-group">
                <label>Check-out Date</label>
                <input class="input" name="checkout_date" type="date" required>
            </div>

            <div class="form-group">
                <label>Guests</label>
                <input 
                    class="input" 
                    name="num_guests" 
                    type="number" 
                    min="1" 
                    value="1" 
                    required
                >
            </div>

            <div class="form-group">
                <label>Room Type</label>
                <select class="select" name="room_type_id" id="roomTypeSelect" required></select>
            </div>

            <div class="form-group">
                <label>Available Room</label>
                <select class="select" name="room_id" id="roomSelect" required></select>
            </div>

            <div class="form-group full">
                <label>Special Requests</label>
                <textarea name="special_requests"></textarea>
            </div>

            <div class="full">
                <button class="btn btn-success" type="submit">
                    Create Walk-in & Check In
                </button>
            </div>
        </form>
    </div>
</section>
