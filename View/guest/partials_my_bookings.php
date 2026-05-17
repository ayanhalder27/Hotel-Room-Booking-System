<section data-page-title="My Bookings" data-page-script="my_bookings.js">
  <div class="page-intro">
    <span class="eyebrow">Reservations</span>
    <h2>My bookings</h2>
    <p>View upcoming and past bookings, cancel allowed bookings, or request date modification.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="card">
    <div class="toolbar">
      <input class="input" id="searchInput" 
             placeholder="Search booking ID, room type, or status" 
             aria-label="Search bookings">
      <select class="select" id="statusFilter" aria-label="Filter by status">
        <option value="">All Status</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="checked_in">Checked In</option>
        <option value="checked_out">Checked Out</option>
        <option value="cancelled">Cancelled</option>
      </select>
      <button class="btn btn-light" id="refreshBtn">Refresh</button>
    </div>

    <div class="table-wrap table-responsive">
      <table>
        <thead>
          <tr>
            <th scope="col">Booking</th>
            <th scope="col">Room Type</th>
            <th scope="col">Dates</th>
            <th scope="col">Guests</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody id="bookingTable">
          <tr>
            <td colspan="7" class="empty">Loading bookings...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
