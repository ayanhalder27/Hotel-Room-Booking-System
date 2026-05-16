<h2 class="page-title">Process Guest Payment</h2>
<p class="page-subtitle">View outstanding bill, apply loyalty discount, record payment, and generate receipt.</p>
<div id="paymentAlert" class="alert"></div>
<section class="card">
<div class="toolbar"><input class="input" id="paymentSearch" placeholder="Search booking ID or guest name"><button class="btn btn-primary" onclick="searchBill()">Search Bill</button></div>
<div class="table-wrap"><table><thead><tr><th>Booking</th><th>Guest</th><th>Base</th><th>Extras</th><th>Discount</th><th>Total</th><th>Status</th><th>Action</th></tr></thead><tbody id="billTable"><tr><td colspan="8" class="empty">Search a booking bill.</td></tr></tbody></table></div>
</section>
<br>
<section class="card" id="paymentCard" style="display:none">
<form id="paymentForm" onsubmit="submitPayment(event)">
<input type="hidden" name="billing_id" id="billingId">
<div class="form-grid">
<div class="form-group"><label>Payment Method</label><select class="select" name="payment_method" required><option value="cash">Cash</option><option value="card">Card</option><option value="mobile_banking">Mobile Banking</option><option value="bank_transfer">Bank Transfer</option></select></div>
<div class="form-group"><label>Loyalty Points to Redeem</label><input class="input" type="number" min="0" name="points_used" id="pointsUsed" value="0"></div>
<div class="full action-row"><button class="btn btn-success" type="submit">Mark Paid & Generate Receipt</button><button class="btn btn-muted" type="button" onclick="hidePaymentCard()">Cancel</button></div>
</div>
</form>
</section>
<script src="payment.js"></script>
