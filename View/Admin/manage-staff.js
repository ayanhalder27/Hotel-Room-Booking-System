let allStaff = [];

async function fetchStaff() {
    try {
        const response = await fetch('../../Controler/AdminControler/staff_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allStaff = json.data;
            renderStaff(allStaff);
        }
    } catch(err) {
        console.error('Error fetching staff:', err);
    }
}

function renderStaff(staff, searchTerm = '') {
    const tbody = document.getElementById('staffTableBody');
    tbody.innerHTML = '';
    
    const highlight = (text) => {
        if (!searchTerm || !text) return text || '';
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return String(text).replace(regex, '<mark style="background-color: var(--gold, #FFD700); color: #000; border-radius: 2px; padding: 0 2px;">$1</mark>');
    };
    
    staff.forEach(s => {
        const isActive = parseInt(s.is_active) === 1;
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <div class="staff-info">
                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(s.name)}&background=random" alt="${s.name}" class="staff-avatar">
                    <div class="staff-details">
                        <span class="staff-name" style="${!isActive ? 'text-decoration: line-through; color: var(--text-secondary);' : ''}">${highlight(s.name)}</span>
                        <span class="staff-email">${highlight(s.email)}</span>
                    </div>
                </div>
            </td>
            <td><span class="role-text" style="${!isActive ? 'color: var(--text-secondary);' : ''}">${highlight(s.role)}</span></td>
            <td>
                <div style="font-size: 0.9rem; ${!isActive ? 'color: var(--text-secondary);' : ''}">${highlight(s.phone)}</div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);">@${highlight(s.username)}</div>
            </td>
            <td><span class="badge ${isActive ? 'active' : 'inactive'}">${isActive ? 'Active' : 'Inactive'}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    ${isActive ? 
                        `<button class="btn-icon deactivate toggle-status-btn" title="Deactivate" data-id="${s.id}" data-status="0"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg></button>` :
                        `<button class="btn-icon activate toggle-status-btn" title="Reactivate" data-id="${s.id}" data-status="1"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></button>`
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
            const msg = status == '1' ? 'Reactivate staff member?' : 'Deactivate staff member?';
            if(confirm(msg)) {
                try {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('is_active', status);
                    
                    const res = await fetch('../../Controler/AdminControler/staff_api.php', {
                        method: 'POST',
                        body: formData
                    });
                    const json = await res.json();
                    if(json.success) fetchStaff();
                } catch(err) { console.error(err); }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchStaff();

    const searchInput = document.querySelector('.search-box input');
    const roleFilter = document.querySelector('select[name="role_filter"]');
    const statusFilter = document.querySelector('select[name="status_filter"]');

    function filterStaff() {
        const term = searchInput.value.toLowerCase();
        const role = roleFilter.value;
        const status = statusFilter.value;
        
        const filtered = allStaff.filter(s => {
            const searchableText = `${s.name} ${s.email} ${s.role} ${s.phone || ''} ${s.username || ''}`.toLowerCase();
            const matchSearch = searchableText.includes(term);
            const matchRole = role === 'all' || s.role === role;
            const matchStatus = status === 'all' || String(s.is_active) === status;
            return matchSearch && matchRole && matchStatus;
        });
        renderStaff(filtered, term);
    }

    searchInput.addEventListener('input', filterStaff);
    roleFilter.addEventListener('change', filterStaff);
    statusFilter.addEventListener('change', filterStaff);

    const modal = document.getElementById('staffModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const staffForm = document.getElementById('staffForm');
    const passwordHelp = document.getElementById('passwordHelp');

    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Add Staff Member';
        staffForm.reset();
        document.getElementById('staffId').value = '';
        passwordHelp.innerText = "A temporary password will be assigned if left blank.";
        modal.classList.add('modal-active');
    });

    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    staffForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        alert("Staff user creation is mocked on this screen since the API focuses on status toggles.");
        closeModal();
    });
});
