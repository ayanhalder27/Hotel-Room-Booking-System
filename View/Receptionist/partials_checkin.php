<section 
    data-page-title="Check In Guest" 
    data-page-script="checkin.js"
>
    <h2 class="page-title">Check In Guest</h2>
    <p class="page-subtitle">
        Search confirmed bookings, verify ID, assign an available physical room, and check the guest in.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Guest check-in card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search by booking ID or guest name"
            >
            <button 
                class="btn btn-primary" 
                id="searchBtn"
            >
                Search
            </button>
        </div>

        <!-- Table -->
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Booking</th>
                        <th>Guest</th>
                        <th>ID No</th>
                        <th>Room Type</th>
                        <th>Dates</th>
                        <th>Available Room</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bookingTable">
                    <tr>
                        <td colspan="7" class="empty">
                            Search or wait for data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
