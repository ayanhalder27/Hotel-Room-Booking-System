<form id="room-search-form">

    <div class="row g-3">

        <div class="col-md-4">
            <label class="form-label">Check In</label>

            <input type="date"
                   class="form-control"
                   id="checkin_date"
                   required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Check Out</label>

            <input type="date"
                   class="form-control"
                   id="checkout_date"
                   required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Guests</label>

            <input type="number"
                   class="form-control"
                   id="guests"
                   min="1"
                   required>
        </div>

    </div>

    <button type="submit" class="btn btn-primary-custom mt-4">
        Search Rooms
    </button>

</form>


<!-- AJAX RESULTS -->

<div id="room-results" class="mt-5"></div>