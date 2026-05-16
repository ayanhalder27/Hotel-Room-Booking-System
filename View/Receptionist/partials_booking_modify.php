<section 
    data-page-title="Modify Booking" 
    data-page-script="booking_modify.js"
>
    <h2 class="page-title">Modify Booking</h2>
    <p class="page-subtitle">
        Search confirmed or active bookings, check availability, and update dates/details.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Booking search and table -->
    <div class="card">
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search booking ID or guest">
            <button 
                class="btn btn-primary" 
                id="refreshBtn">
                Refresh
            </button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Guest</th>
                        <th>Room Type</th>
                        <th>Current Dates</th>
                        <th>Status</th>
                        <th>Modify</th>
                    </tr>
                </thead>
                <tbody id="bookingTable"></tbody>
            </table>
        </div>
    </div>
</section>
