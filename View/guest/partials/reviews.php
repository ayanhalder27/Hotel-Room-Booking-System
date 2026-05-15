<div class="container-fluid p-0">
    <div class="row g-4">
        <div class="col-xl-5 col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h4 class="fw-bold text-navy mb-4"><i class="fa-solid fa-star-half-stroke text-gold me-2"></i>Publish Guest Experience Review</h4>
                
                <form id="guestReviewForm" onsubmit="App.handleReviewSubmit(event)">
                    <div class="mb-3">
                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Select Completed Stay Frame</label>
                        <select class="form-input" id="reviewBookingScope">
                            <option value="10294">Stay: Room #402 (Standard Executive King)</option>
                        </select>
                    </div>

                    <div class="mb-4 bg-light p-3 rounded-3 d-flex flex-column gap-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-sm fw-semibold text-navy">Overall Luxury Experience Rating</span>
                            <div class="star-rating-interactive fs-5 text-muted" data-rating-metric="overall">
                                <i class="fa-regular fa-star pointer" data-value="1"></i>
                                <i class="fa-regular fa-star pointer" data-value="2"></i>
                                <i class="fa-regular fa-star pointer" data-value="3"></i>
                                <i class="fa-regular fa-star pointer" data-value="4"></i>
                                <i class="fa-regular fa-star pointer" data-value="5"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-sm fw-semibold text-navy">Property Cleanliness & Sanitation</span>
                            <div class="star-rating-interactive fs-5 text-muted" data-rating-metric="cleanliness">
                                <i class="fa-regular fa-star pointer" data-value="1"></i>
                                <i class="fa-regular fa-star pointer" data-value="2"></i>
                                <i class="fa-regular fa-star pointer" data-value="3"></i>
                                <i class="fa-regular fa-star pointer" data-value="4"></i>
                                <i class="fa-regular fa-star pointer" data-value="5"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-sm fw-semibold text-navy">Bespoke Concierge Staff Service</span>
                            <div class="star-rating-interactive fs-5 text-muted" data-rating-metric="service">
                                <i class="fa-regular fa-star pointer" data-value="1"></i>
                                <i class="fa-regular fa-star pointer" data-value="2"></i>
                                <i class="fa-regular fa-star pointer" data-value="3"></i>
                                <i class="fa-regular fa-star pointer" data-value="4"></i>
                                <i class="fa-regular fa-star pointer" data-value="5"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-xs fw-bold text-muted text-uppercase">Detailed Experiences Essay</label>
                        <textarea class="form-input" id="reviewCommentText" rows="4" placeholder="Detail your experience with our services, room amenities, and dining..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-navy w-100 py-2.5 fw-bold text-uppercase tracking-wider">Publish Verified Feedback</button>
                </form>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white">
                <h5 class="text-navy fw-bold mb-4">Your Verified Platform Reviews Ledger</h5>
                
                <div class="d-flex flex-column gap-4" id="personalReviewsContainer">
                    
                    <div class="border-bottom pb-4 position-relative review-node-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="m-0 text-navy fw-bold text-md">Standard Executive King Stay Review</h6>
                                <span class="text-xxs text-muted font-monospace">Published March 10, 2026</span>
                            </div>
                            <div class="text-gold text-sm"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                        </div>
                        <p class="text-sm text-secondary italic mb-3">
                            "The automated drapery matrix systems inside the rooms work beautifully. Absolute perfection across room cleanliness arrays. Front desk receptionists deserve five stars."
                        </p>
                        
                        <div class="bg-light p-3 border-start border-4 border-gold rounded-end-3 text-xs mb-3">
                            <strong class="d-block text-navy mb-1"><i class="fa-solid fa-reply-all me-1 text-gold"></i> Executive Director Response:</strong>
                            <span class="text-secondary">"Thank you for your feedback, Sarah! We look forward to welcome you back for your upcoming stay."</span>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-light btn-xs text-navy border"><i class="fa-solid fa-pencil me-1"></i> Edit</button>
                            <button class="btn btn-light btn-xs text-danger border" onclick="App.deleteReviewTrigger(this)"><i class="fa-solid fa-trash-can me-1"></i> Wipe</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>