<section 
    data-page-title="Today Check-ins" 
    data-page-script="today_checkins.js"
>
    <h2 class="page-title">Today Check-ins</h2>
    <p class="page-subtitle">
        Confirmed bookings scheduled to arrive today.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Check-ins card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <div class="search-box">
                <input 
                    class="input" 
                    id="searchInput" 
                    placeholder="Search booking ID, guest name, room type..."
                >
            </div>
            <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Guest</th>
                        <th>Room Type</th>
                        <th>Dates</th>
                        <th>Guests</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="checkinsTable">
                    <tr>
                        <td colspan="7" class="loading">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
