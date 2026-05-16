<section 
    data-page-title="Register Guest" 
    data-page-script="guest_register.js"
>
    <h2 class="page-title">Register Guest</h2>
    <p class="page-subtitle">
        Create, search, update, and deactivate guest profiles.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Guest form card -->
    <div class="card">
        <form id="guestForm" class="form-grid">
            <input type="hidden" name="id" id="guestId">

            <div class="form-group">
                <label>Name</label>
                <input class="input" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input class="input" name="email" type="email" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input class="input" name="username" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input class="input" name="phone" required>
            </div>

            <div class="form-group">
                <label>Nationality</label>
                <input class="input" name="nationality" required>
            </div>

            <div class="form-group">
                <label>National ID</label>
                <input class="input" name="national_id" required>
            </div>

            <div class="full">
                <button class="btn btn-success" type="submit">Save Guest</button>
                <button type="button" class="btn btn-muted" id="resetBtn">Clear</button>
            </div>
        </form>
    </div>

    <!-- Guest list card -->
    <div class="card">
        <div class="toolbar">
            <input 
                class="input" 
                id="searchInput" 
                placeholder="Live search guests"
            >
            <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>National ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="guestTable"></tbody>
            </table>
        </div>
    </div>
</section>
