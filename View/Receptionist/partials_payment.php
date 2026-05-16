<section 
    data-page-title="Payments" 
    data-page-script="payment.js"
>
    <h2 class="page-title">Payments</h2>
    <p class="page-subtitle">
        Search pending bills, redeem loyalty points, mark paid, and generate receipt reference.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Payments card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search booking ID, guest, room"
            >
            <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Guest</th>
                        <th>Base</th>
                        <th>Extras</th>
                        <th>Discount</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="billTable"></tbody>
            </table>
        </div>
    </div>
</section>
