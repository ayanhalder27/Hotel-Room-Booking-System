
<div class="container-fluid">

    <!-- Page Title -->
    <div class="dashboard-card mb-4">
        <h3>Search Rooms</h3>
        <p>Find available rooms based on your stay dates and guest count.</p>
    </div>

    <!-- Search Form -->
    <div class="dashboard-card mb-4">

        <form>

            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Check In</label>
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Check Out</label>
                    <input type="date" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Guests</label>

                    <select class="form-select">
                        <option>1 Guest</option>
                        <option>2 Guests</option>
                        <option>3 Guests</option>
                        <option>4 Guests</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary-custom w-100">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        Search Rooms
                    </button>
                </div>

            </div>

        </form>

    </div>

    <!-- Seasonal Notice -->
    <div class="alert alert-warning mb-4">
        <strong>Seasonal Pricing Notice:</strong>
        Holiday pricing may apply during selected dates.
    </div>

    <!-- Search Results -->
    <div class="row">

        <!-- Room Card -->
        <div class="col-lg-4 mb-4">

            <div class="dashboard-card h-100">

                <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945"
                     class="img-fluid rounded mb-3"
                     alt="Room">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Deluxe Room</h5>

                    <span class="badge bg-success">
                        Available
                    </span>
                </div>

                <p class="mb-2">
                    Spacious deluxe room with modern facilities and city view.
                </p>

                <p class="mb-2">
                    <strong>Capacity:</strong> 2 Guests
                </p>

                <p class="mb-3">
                    <strong>Price:</strong> ৳5500 / night
                </p>

                <div class="mb-3">

                    <span class="badge bg-light text-dark">WiFi</span>
                    <span class="badge bg-light text-dark">AC</span>
                    <span class="badge bg-light text-dark">Breakfast</span>

                </div>

                <div class="d-flex gap-2">

                    <button class="btn btn-outline-primary w-50">
                        View Details
                    </button>

                    <button class="btn btn-primary-custom w-50">
                        Book Now
                    </button>

                </div>

            </div>

        </div>

        <!-- Room Card -->
        <div class="col-lg-4 mb-4">

            <div class="dashboard-card h-100">

                <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd"
                     class="img-fluid rounded mb-3"
                     alt="Room">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Executive Suite</h5>

                    <span class="badge bg-success">
                        Available
                    </span>
                </div>

                <p class="mb-2">
                    Premium suite with luxury interior and balcony.
                </p>

                <p class="mb-2">
                    <strong>Capacity:</strong> 4 Guests
                </p>

                <p class="mb-3">
                    <strong>Price:</strong> ৳9500 / night
                </p>

                <div class="mb-3">

                    <span class="badge bg-light text-dark">WiFi</span>
                    <span class="badge bg-light text-dark">Pool</span>
                    <span class="badge bg-light text-dark">Breakfast</span>

                </div>

                <div class="d-flex gap-2">

                    <button class="btn btn-outline-primary w-50">
                        View Details
                    </button>

                    <button class="btn btn-primary-custom w-50">
                        Book Now
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
