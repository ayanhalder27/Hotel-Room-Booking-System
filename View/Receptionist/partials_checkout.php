<section 
    data-page-title="Check Out Guest" 
    data-page-script="checkout.js"
>
    <h2 class="page-title">Check Out Guest</h2>
    <p class="page-subtitle">
        Search active stays, confirm payment, then checkout and mark room dirty.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Guest checkout card -->
    <div class="card">
        <!-- Toolbar -->
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Search by room number, guest name, or booking ID"
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
                        <th>Room</th>
                        <th>Dates</th>
                        <th>Bill Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="checkoutTable">
                    <tr>
                        <td colspan="7" class="empty">
                            Loading...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
