<section data-page-title="Search Available Rooms" data-page-script="room_search.js">
  <div class="page-intro colorful">
    <span class="eyebrow">Find your stay</span>
    <h2>Search available rooms</h2>
    <p>Choose your dates and number of guests. Results update instantly through AJAX.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="card search-panel">
    <form id="roomSearchForm" class="form-grid form-grid-4">
      <div class="form-group">
        <label for="checkinDate">Check-in Date</label>
        <input class="input" id="checkinDate" type="date" name="checkin_date" required>
      </div>
      <div class="form-group">
        <label for="checkoutDate">Check-out Date</label>
        <input class="input" id="checkoutDate" type="date" name="checkout_date" required>
      </div>
      <div class="form-group">
        <label for="numGuests">Guests</label>
        <input class="input" id="numGuests" type="number" name="num_guests" min="1" value="1" required>
      </div>
      <div class="form-group align-end">
        <button class="btn btn-gradient w-100" type="submit">Search Rooms</button>
      </div>
    </form>
  </div>

  <div class="room-grid" id="roomResults">
    <div class="empty-card">
      <div class="spinner"></div>
      <p>Enter dates to search available room types.</p>
    </div>
  </div>
</section>
