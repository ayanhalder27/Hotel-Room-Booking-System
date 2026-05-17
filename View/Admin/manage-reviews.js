let allReviews = [];
const modal = document.getElementById('replyModal');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelModalBtn');
const replyForm = document.getElementById('replyForm');

async function fetchReviews() {
    try {
        const response = await fetch('../../Controler/AdminControler/reviews_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allReviews = json.data;
            renderReviews(allReviews);
        }
    } catch(err) {
        console.error('Error fetching reviews:', err);
    }
}

function renderReviews(reviews, searchTerm = '') {
    const tbody = document.getElementById('reviewsTableBody');
    tbody.innerHTML = '';
    const highlight = (text) => {
        if (!searchTerm || !text) return text || '';
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return String(text).replace(regex, '<mark style="background-color: var(--gold, #FFD700); color: #000; border-radius: 2px; padding: 0 2px;">$1</mark>');
    };

    reviews.forEach(r => {
        const tr = document.createElement('tr');
        
        // Generate Stars HTML
        let starsHTML = '';
        for(let i = 1; i <= 5; i++) {
            if(i <= r.rating) {
                starsHTML += `<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
            } else {
                starsHTML += `<svg viewBox="0 0 24 24" class="empty-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
            }
        }

        tr.innerHTML = `
            <td>
                <div class="guest-info">${highlight(r.guest_name)}</div>
                <div class="text-muted-sm">Room: ${highlight(r.room_number || 'N/A')}</div>
            </td>
            <td>
                <div class="star-rating">${starsHTML}</div>
            </td>
            <td>
                <div class="review-snippet">"${highlight(r.comment)}"</div>
            </td>
            <td>
                <div>${r.created_at}</div>
            </td>
            <td><span class="badge ${r.status === 'published' ? 'replied' : r.status === 'hidden' ? 'inactive' : 'pending'}">${r.status.toUpperCase()}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon edit-btn" title="View & Manage" data-id="${r.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></button>
                    <button class="btn-icon delete-btn" title="Delete" data-id="${r.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const review = allReviews.find(x => x.id == id);
            if(review) {
                document.getElementById('modalGuestName').innerText = review.guest_name;
                document.getElementById('modalReviewText').innerText = `"${review.comment}"`;
                document.getElementById('reviewId').value = review.id;
                
                let starsHTML = '';
                for(let i = 1; i <= 5; i++) {
                    if(i <= review.rating) {
                        starsHTML += `<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
                    } else {
                        starsHTML += `<svg viewBox="0 0 24 24" class="empty-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
                    }
                }
                document.getElementById('modalStars').innerHTML = starsHTML;
                modal.classList.add('modal-active');
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            if(confirm('Delete this review?')) {
                try {
                    const res = await fetch('../../Controler/AdminControler/reviews_api.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) fetchReviews();
                } catch(err) { console.error(err); }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchReviews();

    const searchInput = document.querySelector('.search-box input');
    const ratingFilter = document.querySelector('select[name="rating_filter"]');
    const statusFilter = document.querySelector('select[name="status_filter"]');

    function filterReviews() {
        const term = searchInput.value.toLowerCase();
        const rating = ratingFilter.value;
        const status = statusFilter.value;
        
        const filtered = allReviews.filter(r => {
            const searchableText = `${r.guest_name} ${r.comment} ${r.room_number || ''}`.toLowerCase();
            const matchSearch = searchableText.includes(term);
            let matchRating = true;
            if(rating === '5') matchRating = parseInt(r.rating) === 5;
            else if(rating === '4') matchRating = parseInt(r.rating) >= 4;
            else if(rating === '3') matchRating = parseInt(r.rating) <= 3;
            
            let matchStatus = true;
            // Map the frontend filter terms back to backend statuses roughly
            if(status === 'pending') matchStatus = r.status === 'pending';
            else if(status === 'replied') matchStatus = r.status === 'published';
            
            return matchSearch && matchRating && matchStatus;
        });
        renderReviews(filtered, term);
    }

    searchInput.addEventListener('input', filterReviews);
    ratingFilter.addEventListener('change', filterReviews);
    statusFilter.addEventListener('change', filterReviews);

    // Close modal functions
    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

    replyForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('reviewId').value;
        
        // In a real scenario, we'd save the reply. Here we just mark as published.
        try {
            const formData = new FormData();
            formData.append('id', id);
            formData.append('status', 'published');
            
            const res = await fetch('../../Controler/AdminControler/reviews_api.php', {
                method: 'POST',
                body: formData
            });
            const json = await res.json();
            if(json.success) fetchReviews();
        } catch(err) { console.error(err); }
        
        closeModal();
    });
});
