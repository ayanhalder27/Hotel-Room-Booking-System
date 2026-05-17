let allRequests = [];

function toggleMaintenanceFields(category) {
    const serviceTypeWrapper = document.getElementById('serviceTypeWrapper');
    const severityWrapper = document.getElementById('severityWrapper');
    
    if(category === 'maintenance') {
        serviceTypeWrapper.style.display = 'none';
        severityWrapper.style.display = 'block';
    } else {
        serviceTypeWrapper.style.display = 'block';
        severityWrapper.style.display = 'none';
    }
}

async function fetchRequests() {
    try {
        const response = await fetch('../../Controler/AdminControler/service_requests_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allRequests = json.data;
            renderRequests(allRequests);
        }
    } catch(err) {
        console.error('Error fetching requests:', err);
    }
}

function renderRequests(requests, searchTerm = '') {
    const tbody = document.getElementById('requestsTableBody');
    tbody.innerHTML = '';
    
    const highlight = (text) => {
        if (!searchTerm || !text) return text || '';
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return String(text).replace(regex, '<mark style="background-color: var(--gold, #FFD700); color: #000; border-radius: 2px; padding: 0 2px;">$1</mark>');
    };

    requests.forEach(req => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="request-id" ${req.service_type === 'maintenance' ? 'style="color: var(--danger);"' : ''}>#SR-${highlight(req.id)}</div>
            </td>
            <td>
                <div class="room-number">Room ${highlight(req.room_number || 'N/A')}</div>
                <div class="text-muted-sm">${highlight(req.guest_name || 'System/Staff')}</div>
            </td>
            <td>
                <div class="type-tag ${req.service_type === 'maintenance' ? 'maintenance' : (req.service_type === 'room_service' ? 'room-service' : 'housekeeping')}">
                    ${req.service_type.replace('_', ' ')}
                </div>
                <div style="font-size: 0.9rem; margin-top: 6px;">${highlight(req.description)}</div>
            </td>
            <td>
                <div>${req.requested_at}</div>
            </td>
            <td><span class="badge ${req.status.replace('_', '-')}">${req.status.replace('_', ' ')}</span></td>
            <td>
                <div class="action-btns">
                    ${req.status !== 'completed' ? 
                    `<button class="btn-icon success update-status" title="Mark Completed" data-id="${req.id}" data-status="completed"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="20 6 9 17 4 12"></polyline></svg></button>` : ''}
                    <button class="btn-icon edit-btn" title="Edit/View" data-id="${req.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    <button class="btn-icon delete delete-btn" title="Delete" data-id="${req.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.querySelectorAll('.update-status').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const status = e.currentTarget.getAttribute('data-status');
            try {
                const formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);
                const res = await fetch('../../Controler/AdminControler/service_requests_api.php', {
                    method: 'POST',
                    body: formData
                });
                const json = await res.json();
                if(json.success) fetchRequests();
            } catch(err) { console.error(err); }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            if(confirm('Delete this request?')) {
                try {
                    const res = await fetch('../../Controler/AdminControler/service_requests_api.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) fetchRequests();
                } catch(err) { console.error(err); }
            }
        });
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const req = allRequests.find(r => r.id == id);
            if(req) {
                document.getElementById('modalTitle').innerText = 'Edit Request';
                document.getElementById('requestId').value = req.id;
                document.getElementById('description').value = req.description;
                document.getElementById('status').value = req.status;
                // Since our form lacks some proper bindings for the mock, we just open it.
                document.getElementById('requestModal').classList.add('modal-active');
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchRequests();

    const searchInput = document.querySelector('.search-box input');
    const typeFilter = document.querySelector('select[name="type_filter"]');
    const statusFilter = document.querySelector('select[name="status_filter"]');

    function filterData() {
        const term = searchInput.value.toLowerCase();
        const type = typeFilter.value;
        const status = statusFilter.value;
        
        const filtered = allRequests.filter(r => {
            const searchableText = `${r.id} ${r.room_number || ''} ${r.guest_name || ''} ${r.description || ''}`.toLowerCase();
            const matchSearch = searchableText.includes(term);
            const matchType = type === 'all' || r.service_type === type || (type === 'housekeeping' && ['laundry', 'toiletries', 'extra_bed'].includes(r.service_type));
            const matchStatus = status === 'all' || r.status === status;
            return matchSearch && matchType && matchStatus;
        });
        renderRequests(filtered, term);
    }

    searchInput.addEventListener('input', filterData);
    typeFilter.addEventListener('change', filterData);
    statusFilter.addEventListener('change', filterData);

    const modal = document.getElementById('requestModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const requestForm = document.getElementById('requestForm');

    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Create New Request';
        requestForm.reset();
        document.getElementById('requestId').value = '';
        toggleMaintenanceFields('service');
        modal.classList.add('modal-active');
    });

    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    requestForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        alert("Creating request from Admin mock is partially implemented via API update endpoint, but no INSERT implemented in service_requests_api.php yet.");
        closeModal();
    });
});
