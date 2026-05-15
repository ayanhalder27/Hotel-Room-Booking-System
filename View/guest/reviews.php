<div class="row g-4 animate-slide-up">
    <div class="col-xl-4 col-lg-5">
        <div class="luxury-card p-4 border-0 shadow-sm">
            <h4 class="brand-serif text-navy mb-3">Share Your Experience</h4>
            <p class="text-muted text-xs mb-4">Your evaluations refine our precision benchmarks. We read every word.</p>
            
            <form id="reviewSubmissionForm" onsubmit="event.preventDefault();">
                <div class="mb-3">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Select Fulfilled Lodging Residency</label>
                    <select class="form-select">
                        <option value="studio">Grand Horizon Studio Room (January 2026)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium d-block mb-2">Experience Score Rating</label>
                    <div class="star-rating-selector fs-3 text-gold-dim d-flex gap-1" id="starSelectorContainer">
                        <i class="bi bi-star transition-base cursor-pointer" onclick="app.showToast('5-Star Metric Pre-selected')"></i>
                        <i class="bi bi-star transition-base cursor-pointer"></i>
                        <i class="bi bi-star transition-base cursor-pointer"></i>
                        <i class="bi bi-star transition-base cursor-pointer"></i>
                        <i class="bi bi-star transition-base cursor-pointer"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label text-xs uppercase text-muted tracking-wider fw-medium">Your Narrative Evaluation</label>
                    <textarea class="form-control" rows="5" placeholder="Share your experience with our services, spaces, culinary quality, and concierge execution..." required></textarea>
                </div>
                <button type="submit" class="btn btn-luxury-primary w-100 py-2-5 text-sm" onclick="app.showToast('Evaluation narrative published to resort feedback registers.')">Publish Narrative Review</button>
            </form>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="luxury-card p-4 border-0 shadow-sm h-100">
            <h5 class="brand-serif text-navy mb-4">Your Historic Feedback Submissions</h5>
            <div class="d-flex flex-column gap-4">
                
                <div class="border-bottom pb-4">
                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
                        <div>
                            <h6 class="text-navy fw-semibold mb-0">Ocean Deluxe Suite</h6>
                            <small class="text-muted text-xs">Residency Window: November 2025 • Published Nov 12, 2025</small>
                        </div>
                        <div class="text-gold text-sm">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            <span class="text-navy fw-medium ms-1">(5.0)</span>
                        </div>
                    </div>
                    <p class="text-sm text-muted mb-0 italic leading-relaxed">
                        "The ocean view suite exceeded every expectation. The butler service was flawless, anticipating our dinner reservations and handling wardrobe pressing seamlessly. A masterclass in luxury hospitality."
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>