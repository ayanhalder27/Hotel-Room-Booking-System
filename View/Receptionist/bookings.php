<div class="container-fluid">

    <div class="page-title">
        <h2>Booking Management</h2>
    </div>


    <div class="search-section">

        <input
            type="text"
            id="bookingSearch"
            class="form-control"
            placeholder="Search by Booking ID, Guest Name or Room Number"
        >

    </div>


    <div class="table-section">

        <table class="table table-bordered table-hover">

            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Guest Name</th>
                    <th>Room Number</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="bookingTableBody">

                <tr>
                    <td colspan="7" class="text-center">
                        Booking data will load here.
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>