<div class="animate-slide-up">
    <div class="luxury-card p-4 border-0 shadow-sm mb-4">
        <form id="roomSearchForm" class="row g-3 align-items-end" onsubmit="event.preventDefault();">
            <div class="col-xl-3 col-md-6">
                <label class="form-label text-xs tracking-wider uppercase text-muted fw-semibold">Check-In Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-gold"><i class="bi bi-calendar-range"></i></span>
                    <input type="date" class="form-control border-start-0" value="2026-06-01">
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <label class="form-label text-xs tracking-wider uppercase text-muted fw-semibold">Check-Out Date</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0 text-gold"><i class="bi bi-calendar-range"></i></span>
                    <input type="date" class="form-control border-start-0" value="2026-06-07">
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <label class="form-label text-xs tracking-wider uppercase text-muted fw-semibold">Guests Allocation</label>
                <select class="form-select">
                    <option value="1">1 Adult</option>
                    <option value="2" selected>2 Adults</option>
                    <option value="4">2 Adults, 2 Children</option>
                    <option value="6">VIP Group Party</option>
                </select>
            </div>
            <div class="col-xl-2 col-md-6">
                <label class="form-label text-xs tracking-wider uppercase text-muted fw-semibold">Tier Category</label>
                <select class="form-select">
                    <option value="">All Tiers</option>
                    <option value="deluxe">Deluxe Collection</option>
                    <option value="executive">Executive Space</option>
                    <option value="presidential">Presidential Reserve</option>
                </select>
            </div>
            <div class="col-xl-2 col-12">
                <button type="button" class="btn btn-luxury-primary w-100 py-2-5" onclick="app.showToast('Filtering premium inventory live...')"><i class="bi bi-sliders me-2"></i> Find Suite</button>
            </div>
        </form>
    </div>

    <div class="alert alert-gold border-0 rounded-3 p-3 mb-4 d-flex align-items-center gap-3">
        <i class="bi bi-info-circle-fill fs-5"></i>
        <div class="text-sm">
            <strong>Summer Solstice Privilege Active:</strong> Comp complimentary airport transfers with all Presidential Reserve bookings during June.
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="row g-4" id="roomResultsContainer">
                
                <div class="col-md-6 col-xl-4">
                    <div class="room-product-card shadow-sm h-100 overflow-hidden d-flex flex-column">
                        <div class="position-relative overflow-hidden group-hover-zoom">
                            <span class="badge position-absolute top-0 end-0 m-3 z-index-2 badge-gold-solid">Only 2 Left</span>
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&q=80&w=600" alt="Room Space Showcase" class="w-100 object-fit-cover height-240">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="brand-serif text-navy mb-0">Deluxe Sanctuary King</h5>
                                    <div class="text-gold text-sm"><i class="bi bi-star-fill"></i> 4.9</div>
                                </div>
                                <p class="text-xs text-muted mb-3">65 m² • Panoramic City View • Signature Marble Bath</p>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="badge badge-gray-pill">Free Wifi</span>
                                    <span class="badge badge-gray-pill">Nespresso Machine</span>
                                    <span class="badge badge-gray-pill">24/7 Butler</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                                <div>
                                    <span class="text-muted text-xs d-block">Price / Night</span>
                                    <span class="fs-4 fw-bold text-navy">$350 <small class="text-xs text-muted fw-normal">USD</small></span>
                                </div>
                                <button class="btn btn-luxury-primary px-3 py-2 text-sm load-view-btn" data-view="room_details">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="room-product-card shadow-sm h-100 overflow-hidden d-flex flex-column">
                        <div class="position-relative overflow-hidden group-hover-zoom">
                            <span class="badge position-absolute top-0 end-0 m-3 z-index-2 bg-success text-white px-2 py-1 rounded-1 text-uppercase text-xs fw-medium tracking-wider">Best Seller</span>
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&q=80&w=600" alt="Room Space Showcase" class="w-100 object-fit-cover height-240">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="brand-serif text-navy mb-0">Horizon Executive Suite</h5>
                                    <div class="text-gold text-sm"><i class="bi bi-star-fill"></i> 5.0</div>
                                </div>
                                <p class="text-xs text-muted mb-3">110 m² • Oceanfront Skyline Horizon • Living Room Lounge</p>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="badge badge-gray-pill">Executive Lounge</span>
                                    <span class="badge badge-gray-pill">Airport Chauffeur</span>
                                    <span class="badge badge-gray-pill">Wine Vault</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                                <div>
                                    <span class="text-muted text-xs d-block">Price / Night</span>
                                    <span class="fs-4 fw-bold text-navy">$620 <small class="text-xs text-muted fw-normal">USD</small></span>
                                </div>
                                <button class="btn btn-luxury-primary px-3 py-2 text-sm load-view-btn" data-view="room_details">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-4">
                    <div class="room-product-card shadow-sm h-100 overflow-hidden d-flex flex-column">
                        <div class="position-relative overflow-hidden group-hover-zoom">
                            <span class="badge position-absolute top-0 end-0 m-3 z-index-2 badge-gold-solid">Presidential Class</span>
                            <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?auto=format&fit=crop&q=80&w=600" alt="Room Space Showcase" class="w-100 object-fit-cover height-240">
                        </div>
                        <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="brand-serif text-navy mb-0">The Horizon Villa Reserve</h5>
                                    <div class="text-gold text-sm"><i class="bi bi-star-fill"></i> 5.0</div>
                                </div>
                                <p class="text-xs text-muted mb-3">280 m² • Private Helipad Access • Infinity Plunge Pool</p>
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="badge badge-gray-pill">Private Pool</span>
                                    <span class="badge badge-gray-pill">Chef on Demand</span>
                                    <span class="badge badge-gray-pill">Helipad</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-3 border-top mt-auto">
                                <div>
                                    <span class="text-muted text-xs d-block">Price / Night</span>
                                    <span class="fs-4 fw-bold text-navy">$1,850 <small class="text-xs text-muted fw-normal">USD</small></span>
                                </div>
                                <button class="btn btn-luxury-primary px-3 py-2 text-sm load-view-btn" data-view="room_details">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>