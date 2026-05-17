let allAnnouncements = [];
const modal = document.getElementById('announcementModal');
const closeBtn = document.getElementById('closeModalBtn');
const cancelBtn = document.getElementById('cancelModalBtn');
const form = document.getElementById('announcementForm');

async function fetchAnnouncements() {
    try {
        const response = await fetch('../../Controler/AdminControler/announcements_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allAnnouncements = json.data;
            renderAnnouncements(allAnnouncements);
        }
    } catch(err) {
        console.error('Error fetching announcements:', err);
    }
}

function renderAnnouncements(announcements, searchTerm = '') {
    const tbody = document.getElementById('announcementsTableBody');
    tbody.innerHTML = '';
    
    const highlight = (text) => {
        if (!searchTerm || !text) return text || '';
        const regex = new RegExp(`(${searchTerm})`, 'gi');
        return String(text).replace(regex, '<mark style="background-color: var(--gold, #FFD700); color: #000; border-radius: 2px; padding: 0 2px;">$1</mark>');
    };

    announcements.forEach(a => {
        const tr = document.createElement('tr');
        
        let badgeClass = 'active';
        if(a.status === 'draft') badgeClass = 'pending'; // 'pending' matches the yellow style in this template
        else if(a.status === 'expired') badgeClass = 'expired';

        tr.innerHTML = `
            <td>
                <div class="announcement-title">${highlight(a.title)}</div>
                <div class="announcement-snippet">${highlight(a.content.substring(0, 100))}${a.content.length > 100 ? '...' : ''}</div>
            </td>
            <td>
                <div class="date-info">
                    <span>Posted: <strong>${a.created_at.split(' ')[0]}</strong></span>
                    <span>Valid Until: <strong>${a.valid_until}</strong></span>
                </div>
            </td>
            <td><span class="badge ${badgeClass}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon edit-btn" title="Edit" data-id="${a.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    <button class="btn-icon delete delete-btn" title="Delete" data-id="${a.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const a = allAnnouncements.find(x => x.id == id);
            if(a) {
                window.openAnnouncementModal(a.id, a.title, a.content, a.valid_until, a.status);
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            if(confirm('Delete this announcement?')) {
                try {
                    const res = await fetch('../../Controler/AdminControler/announcements_api.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) fetchAnnouncements();
                } catch(err) { console.error(err); }
            }
        });
    });
}

window.openAnnouncementModal = function(id = '', title = '', content = '', validUntil = '', status = 'active') {
    document.getElementById('announcementId').value = id;
    document.getElementById('title').value = title;
    document.getElementById('content').value = content;
    document.getElementById('validUntil').value = validUntil;
    document.getElementById('status').value = status;
    
    if(id) {
        document.getElementById('modalTitle').innerText = 'Edit Announcement';
        document.querySelector('#announcementForm button[type="submit"]').innerText = 'Update Announcement';
    } else {
        document.getElementById('modalTitle').innerText = 'New Announcement';
        document.querySelector('#announcementForm button[type="submit"]').innerText = 'Save Announcement';
    }
    modal.classList.add('modal-active');
};

const closeModal = () => modal.classList.remove('modal-active');
closeBtn.addEventListener('click', closeModal);
cancelBtn.addEventListener('click', closeModal);
modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    try {
        const res = await fetch('../../Controler/AdminControler/announcements_api.php', {
            method: 'POST',
            body: formData
        });
        const json = await res.json();
        if(json.success) {
            fetchAnnouncements();
            closeModal();
        } else {
            alert('Failed to save announcement.');
        }
    } catch(err) { console.error(err); }
});

document.addEventListener('DOMContentLoaded', () => {
    fetchAnnouncements();

    const searchInput = document.querySelector('.search-box input');
    const statusFilter = document.querySelector('select[name="status_filter"]');

    function filterAnnouncements() {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value;
        
        const filtered = allAnnouncements.filter(a => {
            const searchableText = `${a.title} ${a.content}`.toLowerCase();
            const matchSearch = searchableText.includes(term);
            const matchStatus = status === 'all' || a.status === status;
            return matchSearch && matchStatus;
        });
        renderAnnouncements(filtered, term);
    }

    searchInput.addEventListener('input', filterAnnouncements);
    statusFilter.addEventListener('change', filterAnnouncements);
});
