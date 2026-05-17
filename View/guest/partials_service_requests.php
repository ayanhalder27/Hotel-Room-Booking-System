<section data-page-title="Service Requests" data-page-script="service_requests.js">
  <div class="page-intro">
    <span class="eyebrow">In-stay help</span>
    <h2>Service requests</h2>
    <p>Create and track requests for active stays.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="grid grid-2">
    <!-- Create Request -->
    <div class="card">
      <h3>Create Request</h3>
      <form id="requestForm" class="form-grid one">
        <div class="form-group">
          <label for="activeBookingSelect">Active Booking</label>
          <select class="select" name="booking_id" id="activeBookingSelect" required>
            <option value="">Loading active bookings...</option>
          </select>
        </div>
        <div class="form-group">
          <label for="serviceType">Service Type</label>
          <select class="select" id="serviceType" name="service_type" required>
            <option value="extra_bed">Extra Bed</option>
            <option value="toiletries">Toiletries</option>
            <option value="laundry">Laundry</option>
            <option value="room_service">Room Service</option>
            <option value="other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="input" id="description" name="description" rows="4" required></textarea>
        </div>
        <button class="btn btn-gradient" type="submit">Submit Request</button>
      </form>
    </div>

    <!-- My Requests -->
    <div class="card">
      <div class="section-head">
        <div>
          <h3>My Requests</h3>
          <p>Track current and past requests</p>
        </div>
        <button class="btn btn-light" id="refreshBtn">Refresh</button>
      </div>
      <div class="table-wrap table-responsive">
        <table>
          <thead>
            <tr>
              <th scope="col">Booking</th>
              <th scope="col">Type</th>
              <th scope="col">Description</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody id="requestTable">
            <tr>
              <td colspan="4" class="empty">Loading...</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
