<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm p-4 sticky-lg-top" style="top: 110px; z-index: 10;">
                <h5 class="fw-bold text-navy mb-3"><i class="fa-solid fa-sliders text-gold me-2"></i>Find Your Perfect Stay</h5>
                <hr class="mt-0 mb-4 border-light-subtle">
                
                <form id="roomSearchForm" onsubmit="App.handleSearchSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label text-xs tracking-wider uppercase text-muted fw-bold">Check-In Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar-days"></i></span>
                            <input type="date" class="form-input border-start-0 ps-0" id="searchCheckIn" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs tracking-wider uppercase text-muted fw-bold">Check-Out Date</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-regular fa-calendar-days"></i></span>
                            <input type="date" class="form-input border-start-0 ps-0" id="searchCheckOut" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-xs tracking-wider uppercase text-muted fw-bold">Occupants / Guests</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-user-group"></i></span>
                            <select class="form-input border-start-0 ps-0" id="searchGuests">
                                <option value="1">1 Adult</option>
                                <option value="2" selected>2 Adults</option>
                                <option value="3">3 Adults</option>
                                <option value="4">4 Adults / Family</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-xs tracking-wider uppercase text-muted fw-bold mb-2">Bespoke Suite Amenities</label>
                        <div class="row g-2">
                            <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="amenityWifi" checked><label class="form-check-label text-sm" for="amenityWifi">High-Speed WiFi</label></div></div>
                            <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="amenityAC" checked><label class="form-check-label text-sm" for="amenityAC">Climatized A/C</label></div></div>
                            <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="amenityMiniBar"><label class="form-check-label text-sm" for="amenityMiniBar">Bespoke Mini Bar</label></div></div>
                            <div class="col-6"><div class="form-check"><input class="form-check-input" type="checkbox" id="amenityPool"><label class="form-check-label text-sm" for="amenityPool">Private Pool Access</label></div></div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-navy w-100 py-2.5 fw-bold"><i class="fa-solid fa-magnifying-glass me-2 text-gold"></i>Query Live Availability</button>
                </form>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="alert alert-gold border-0 shadow-2xs p-3 mb-4 d-flex align-items-center gap-3">
                <i class="fa-solid fa-tags text-gold fs-4"></i>
                <div>
                    <h6 class="m-0 fw-bold text-dark">High Season Rate Schedule Enabled</h6>
                    <p class="m-0 text-xs text-secondary">Selected custom operational dates fall during the premium **Eid Luxury Festival**. Base pricing updates live below.</p>
                </div>
            </div>

            <div id="searchResultsContainer" class="d-flex flex-column gap-4">
                
                <div class="card card-room-horizontal border-0 shadow-sm overflow-hidden bg-white">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 position-relative">
                            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80" alt="Deluxe Room" class="w-100 h-100 object-fit-cover">
                            <span class="badge position-absolute top-3 start-3 bg-navy text-white text-xs px-3 py-1.5 shadow-sm">EXCLUSIVE OFFER</span>
                        </div>
                        <div class="col-md-7 d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h4 class="card-title text-navy fw-bold mb-1">Deluxe King Oceanfront Room</h4>
                                    <div class="d-flex align-items-center gap-2 text-muted text-xs">
                                        <span><i class="fa-solid fa-maximize me-1"></i>450 sq ft</span>
                                        <span>•</span>
                                        <span><i class="fa-solid fa-bed me-1"></i>1 King Bed</span>
                                        <span>•</span>
                                        <span><i class="fa-solid fa-user-group me-1"></i>Max 3 Guests</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-gold text-sm"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star-half-stroke"></i></div>
                                    <span class="text-xs text-muted">(142 Premium Reviews)</span>
                                </div>
                            </div>
                            <p class="text-sm text-secondary line-clamp-2">Breathtaking panoramic windows open onto complete vistas of the azure bay. Custom velvet lounge seating and curated Italian stone bath architectures await.</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-wifi text-gold me-1"></i>Ultra WiFi</span>
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-tv text-gold me-1"></i>Smart TV</span>
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-wind text-gold me-1"></i>A/C Lounge</span>
                            </div>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted text-xs d-block">Price Per Night (Base)</span>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <h3 class="m-0 fw-bold font-monospace text-navy">$220.00</h3>
                                        <span class="text-xs text-muted">/ night</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-navy text-sm px-3" onclick="App.loadPartial('room_details')">Explore Spaces</button>
                                    <button class="btn btn-gold text-dark text-sm fw-bold px-4" onclick="App.loadPartial('book_room')">Reserve Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-room-horizontal border-0 shadow-sm overflow-hidden bg-white">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 position-relative">
                            <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80" alt="Executive Suite" class="w-100 h-100 object-fit-cover">
                            <span class="badge position-absolute top-3 start-3 bg-danger text-white text-xs px-3 py-1.5 shadow-sm">ONLY 2 ROOMS LEFT</span>
                        </div>
                        <div class="col-md-7 d-flex flex-column p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h4 class="card-title text-navy fw-bold mb-1">Grand Panoramic Presidential Suite</h4>
                                    <div class="d-flex align-items-center gap-2 text-muted text-xs">
                                        <span><i class="fa-solid fa-maximize me-1"></i>980 sq ft</span>
                                        <span>•</span>
                                        <span><i class="fa-solid fa-bed me-1"></i>2 King Beds</span>
                                        <span>•</span>
                                        <span><i class="fa-solid fa-user-group me-1"></i>Max 5 Guests</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="text-gold text-sm"><i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i> <i class="fa-solid fa-star"></i></div>
                                    <span class="text-xs text-muted">(94 Premium Reviews)</span>
                                </div>
                            </div>
                            <p class="text-sm text-secondary line-clamp-2">The absolute pinnacle of high architectural design, boasting independent grand dining space ceilings, private balcony soaking pools, and 24/7 dedicated butler call pipelines.</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-water text-gold me-1"></i>Private Jacuzzi</span>
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-wine-glass text-gold me-1"></i>Mini-Bar Inc.</span>
                                <span class="badge bg-light text-dark font-monospace text-xs"><i class="fa-solid fa-concierge-bell text-gold me-1"></i>24/7 Butler Line</span>
                            </div>

                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted text-xs d-block">Price Per Night (Base)</span>
                                    <div class="d-flex align-items-baseline gap-1">
                                        <h3 class="m-0 fw-bold font-monospace text-navy">$450.00</h3>
                                        <span class="text-xs text-muted">/ night</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-navy text-sm px-3" onclick="App.loadPartial('room_details')">Explore Spaces</button>
                                    <button class="btn btn-gold text-dark text-sm fw-bold px-4" onclick="App.loadPartial('book_room')">Reserve Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>