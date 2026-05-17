let allGuests = [];

async function fetchGuests() {
    try {
        const response = await fetch('../../Controler/AdminControler/guests_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allGuests = json.data;
            renderGuests(allGuests);
        }
    } catch(err) {
        console.error('Error fetching guests:', err);
    }
}

function renderGuests(guests) {
    const tbody = document.getElementById('guestsTableBody');
    tbody.innerHTML = '';
    
    guests.forEach(g => {
        const isActive = parseInt(g.is_active) === 1;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <div class="guest-info">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(g.name)}&background=random" alt="${g.name}" class="guest-avatar">
                    <div class="guest-details">
                        <span class="guest-name" style="${!isActive ? 'text-decoration: line-through; color: var(--text-secondary);' : ''}">${g.name}</span>
                        <span class="guest-email">${g.email}</span>
                    </div>
                </div>
            </td>
            <td>
                <div style="font-size: 0.9rem; ${!isActive ? 'color: var(--text-secondary);' : ''}">${g.phone}</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">@${g.username}</div>
            </td>
            <td>
                <div style="font-size: 0.9rem; ${!isActive ? 'color: var(--text-secondary);' : 'color: var(--text-primary);'}">${g.nationality}</div>
                <span class="id-text">ID: ${g.national_id}</span>
            </td>
            <td><span class="badge ${isActive ? 'active' : 'inactive'}">${isActive ? 'Active' : 'Deactivated'}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    ${isActive ? 
                        `<button class="btn-icon deactivate toggle-status-btn" title="Deactivate" data-id="${g.id}" data-status="0"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg></button>` :
                        `<button class="btn-icon activate toggle-status-btn" title="Reactivate" data-id="${g.id}" data-status="1"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></button>`
                    }
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const status = e.currentTarget.getAttribute('data-status');
            const msg = status == '1' ? 'Reactivate account?' : 'Deactivate account?';
            if(confirm(msg)) {
                try {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('is_active', status);
                    
                    const res = await fetch('../../Controler/AdminControler/guests_api.php', {
                        method: 'POST',
                        body: formData
                    });
                    const json = await res.json();
                    if(json.success) fetchGuests();
                } catch(err) { console.error(err); }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchGuests();

    const searchInput = document.querySelector('.search-box input');
    const statusFilter = document.querySelector('select[name="status_filter"]');

    function filterGuests() {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        
        const filtered = allGuests.filter(g => {
            const matchSearch = g.name.toLowerCase().includes(term) || g.email.toLowerCase().includes(term) || g.national_id.toLowerCase().includes(term);
            const matchStatus = status === 'all' || String(g.is_active) === status;
            return matchSearch && matchStatus;
        });
        renderGuests(filtered);
    }

    searchInput.addEventListener('input', filterGuests);
    statusFilter.addEventListener('change', filterGuests);

    const modal = document.getElementById('guestModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const guestForm = document.getElementById('guestForm');
    const passwordHelp = document.getElementById('passwordHelp');

    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Add Walk-in Guest';
        guestForm.reset();
        document.getElementById('guestId').value = '';
        passwordHelp.innerText = "A temporary password will be assigned if left blank.";
        modal.classList.add('modal-active');
    });

    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    guestForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        alert("Guest saving via this modal is mocked as the API focuses on status toggles and viewing.");
        closeModal();
    });
});
