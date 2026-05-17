<section data-page-title="Loyalty Points" data-page-script="loyalty.js">
  <div class="page-intro colorful">
    <span class="eyebrow">Rewards</span>
    <h2>Loyalty points</h2>
    <p>View earned, used, and available points for future discounts.</p>
  </div>

  <div id="alertBox" class="alert" role="alert"></div>

  <div class="grid grid-3" id="loyaltyStats">
    <div class="card loading">
      <div class="spinner"></div>
      <p>Loading loyalty points...</p>
    </div>
  </div>

  <div class="card mt-20">
    <div class="section-head">
      <h3>Points History</h3>
      <button class="btn btn-light" id="refreshBtn">Refresh</button>
    </div>
    <div class="table-wrap table-responsive">
      <table>
        <thead>
          <tr>
            <th scope="col">Booking</th>
            <th scope="col">Earned</th>
            <th scope="col">Used</th>
            <th scope="col">Balance</th>
            <th scope="col">Date</th>
          </tr>
        </thead>
        <tbody id="loyaltyTable">
          <tr>
            <td colspan="5" class="empty">Loading...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
