<h2 class="page-title">Check Out Guest</h2>
<p class="page-subtitle">Search checked-in guest, confirm bill status, then checkout and mark room dirty.</p>
<div id="checkoutAlert" class="alert"></div>
<section class="card">
    <div class="toolbar"><input class="input" id="checkoutSearch" placeholder="Search by room number, guest name, or booking ID"><button class="btn btn-primary" onclick="searchCheckoutBooking()">Search</button></div>
    <div class="table-wrap"><table><thead><tr><th>Booking ID</th><th>Guest</th><th>Room</th><th>Check-out</th><th>Bill Status</th><th>Total</th><th>Action</th></tr></thead><tbody id="checkoutTable"><tr><td colspan="7" class="empty">Search a checked-in guest.</td></tr></tbody></table></div>
</section>
<script src="checkout.js"></script>
