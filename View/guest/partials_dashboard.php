<section data-page-title="Guest Dashboard" data-page-script="dashboard.js">
  <div class="hero-card">
    <span class="eyebrow">Guest Portal</span>
    <h2>Plan your stay with comfort</h2>
    <p>Search rooms, manage reservations, request services, view bills, and track loyalty points from one place.</p>
    <a href="room_search.php" class="btn btn-white">Search Rooms</a>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="grid grid-4" id="dashboardStats">
    <div class="card loading">
      <div class="spinner"></div>
      <p>Loading dashboard...</p>
    </div>
  </div>

  <div class="grid grid-2 mt-20">
    <!-- Upcoming Bookings -->
    <div class="card">
      <div class="section-head">
        <div>
          <h3>Upcoming Bookings</h3>
          <p>Your nearest hotel stays</p>
        </div>
        <button class="btn btn-light" id="refreshDashboard">Refresh</button>
      </div>
      <div class="table-wrap table-responsive">
        <table>
          <thead>
            <tr>
              <th scope="col">Booking</th>
              <th scope="col">Room Type</th>
              <th scope="col">Dates</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody id="upcomingTable">
            <tr>
              <td colspan="4" class="empty">Loading...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent Bills -->
    <div class="card">
      <div class="section-head">
        <div>
          <h3>Recent Bills</h3>
          <p>Latest invoices and payment status</p>
        </div>
      </div>
      <div class="table-wrap table-responsive">
        <table>
          <thead>
            <tr>
              <th scope="col">Booking</th>
              <th scope="col">Amount</th>
              <th scope="col">Payment</th>
            </tr>
          </thead>
          <tbody id="billTable">
            <tr>
              <td colspan="3" class="empty">Loading...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
