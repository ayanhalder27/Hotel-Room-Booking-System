let allBookings = [];

async function fetchBookings() {
    try {
        const response = await fetch('../../Controler/AdminControler/bookings_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allBookings = json.data;
            renderBookings(allBookings);
        }
    } catch(err) {
        console.error('Error fetching bookings:', err);
    }
}

function renderBookings(bookings) {
    const tbody = document.getElementById('bookingsTableBody');
    tbody.innerHTML = '';
    
    bookings.forEach(bkg => {
        const date1 = new Date(bkg.checkin_date);
        const date2 = new Date(bkg.checkout_date);
        const nights = Math.round((date2 - date1)/(1000*60*60*24));

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <div class="booking-id">#BKG-${bkg.id}</div>
                <div class="text-muted-sm">${bkg.created_at.substring(0, 10)}</div>
            </td>
            <td>
                <div class="guest-name">${bkg.guest_name}</div>
                <div class="text-muted-sm">${bkg.guest_phone || ''}</div>
            </td>
            <td>
                <div style="font-weight: 500; color: var(--text-primary);">${bkg.room_type}</div>
                <div class="text-muted-sm">${bkg.room_number ? 'Room ' + bkg.room_number : 'Unassigned'}</div>
            </td>
            <td>
                <div>${bkg.checkin_date}</div>
                <div class="text-muted-sm">to ${bkg.checkout_date} (${nights} Nights)</div>
            </td>
            <td>
                <div style="font-family: var(--font-heading); font-weight: 600;">$${parseFloat(bkg.total_price).toFixed(2)}</div>
                <span class="source-tag" ${bkg.source === 'walk_in' ? 'style="background: rgba(212,175,55,0.1); color: var(--gold);"' : ''}>${bkg.source === 'walk_in' ? 'Walk In' : 'Online Booking'}</span>
            </td>
            <td><span class="badge ${bkg.status.replace('_', '-')}">${bkg.status.replace('_', ' ')}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon edit-btn" title="View/Edit Booking" data-id="${bkg.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    <button class="btn-icon delete delete-btn" title="Cancel/Delete" data-id="${bkg.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const bkg = allBookings.find(b => b.id == id);
            if(bkg) {
                document.getElementById('modalTitle').innerText = 'Edit Booking';
                document.getElementById('bookingId').value = bkg.id;
                // Currently form lacks full matching to all fields so we set what we can
                document.getElementById('source').value = bkg.source;
                document.getElementById('checkinDate').value = bkg.checkin_date;
                document.getElementById('checkoutDate').value = bkg.checkout_date;
                document.getElementById('numGuests').value = bkg.num_guests;
                document.getElementById('status').value = bkg.status;
                document.getElementById('totalPrice').value = bkg.total_price;
                document.getElementById('specialRequests').value = bkg.special_requests;
                document.getElementById('bookingModal').classList.add('modal-active');
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            if(confirm('Delete this booking?')) {
                try {
                    const res = await fetch('../../Controler/AdminControler/bookings_api.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) fetchBookings();
                } catch(err) { console.error(err); }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchBookings();

    const modal = document.getElementById('bookingModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const bookingForm = document.getElementById('bookingForm');

    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Create New Booking';
        bookingForm.reset();
        document.getElementById('bookingId').value = '';
        modal.classList.add('modal-active');
    });

    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    bookingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(bookingForm);
        try {
            const res = await fetch('../../Controler/AdminControler/bookings_api.php', {
                method: 'POST',
                body: formData
            });
            const json = await res.json();
            if(json.success) {
                closeModal();
                fetchBookings();
            } else alert('Error saving booking');
        } catch(err) { console.error(err); }
    });
});
