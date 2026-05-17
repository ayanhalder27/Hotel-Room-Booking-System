<section data-page-title="Billing History" data-page-script="billing_history.js">
  <div class="page-intro">
    <span class="eyebrow">Invoices</span>
    <h2>Billing history</h2>
    <p>View all invoices, paid status, discounts, and receipt information.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="card">
    <div class="toolbar">
      <form id="billingFilterForm" class="toolbar-form">
        <input 
          class="input" 
          id="searchInput" 
          name="search" 
          type="text" 
          placeholder="Search booking ID or payment status" 
          aria-label="Search billing records"
        >
        <select class="select" id="paymentFilter" name="status" aria-label="Filter by payment status">
          <option value="">All Payments</option>
          <option value="pending">Pending</option>
          <option value="paid">Paid</option>
        </select>
        <button type="submit" class="btn btn-light" id="refreshBtn">Refresh</button>
      </form>
    </div>

    <div class="table-wrap table-responsive">
      <table>
        <thead>
          <tr>
            <th scope="col">Booking</th>
            <th scope="col">Room</th>
            <th scope="col">Base</th>
            <th scope="col">Extras</th>
            <th scope="col">Discount</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th scope="col">Paid At</th>
          </tr>
        </thead>
        <tbody id="billingTable">
          <tr>
            <td colspan="8" class="empty">Loading bills...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
