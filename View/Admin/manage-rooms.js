let allRooms = [];

async function fetchRooms() {
    console.log('Fetching rooms...');
    try {
        const response = await fetch('../../Controler/AdminControler/manage-rooms.php');
        const json = await response.json();
        
        if(json.success && json.data) {
            allRooms = json.data;
            renderRooms(allRooms);
        }
    } catch(err) {
        console.error('Error fetching rooms:', err);
    }
}

function renderRooms(rooms) {
    const tbody = document.querySelector('tbody');
    tbody.innerHTML = '';
    
    rooms.forEach(room => {
        const row = document.createElement('tr');
        row.innerHTML = `<td class="room-number">${room.room_number}</td>
                        <td class="room-type">${room.room_type}</td>
                        <td class="floor">${room.floor}</td>
                        <td class="status"><span class="badge ${room.status.toLowerCase()}">${room.status}</span></td>
                        <td class="notes" style="color: var(--text-secondary); font-size: 0.85rem;">${room.notes || ''}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon" title="Edit" data-id="${room.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                                <button class="btn-icon delete" title="Delete" data-id="${room.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </td>`;
        tbody.appendChild(row);
    });
}

async function loadRoomTypes() {
    try {
        let promise = await fetch('../../Controler/AdminControler/room_types.php');
        let json = await promise.json();
        if(json.success && json.data) {
            const select = document.getElementById('roomType');
            // Clear existing except first
            select.innerHTML = '<option value="">Select a Room Type</option>';
            json.data.forEach(type => {
                const option = document.createElement('option');
                option.value = type.id;
                option.textContent = type.name;
                select.appendChild(option);
            });
        }
    } catch(err) {
        console.error('Error fetching room types:', err);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchRooms();
    loadRoomTypes();

    const modal = document.getElementById('roomModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const roomForm = document.getElementById('roomForm');

    // Open Add Room modal
    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Add New Room';
        roomForm.reset();
        document.getElementById('roomId').value = '';
        modal.classList.add('active');
    });

    // Close modal functions
    const closeModal = () => {
        modal.classList.remove('active');
    };

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Close modal if clicking outside the content box
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Handle Form Submission
    roomForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(roomForm);
        
        try {
            const res = await fetch('../../Controler/AdminControler/manage-rooms.php', {
                method: 'POST',
                body: formData
            });
            const json = await res.json();
            if(json.success) {
                closeModal();
                fetchRooms();
            } else {
                alert("Error saving room");
            }
        } catch(err) {
            console.error("Error", err);
        }
    });

    // Filtering & Searching
    const searchInput = document.querySelector('.search-box input');
    const statusFilter = document.getElementById('statusFilter');

    function filterRooms() {
        const term = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        
        const filtered = allRooms.filter(r => {
            const matchSearch = r.room_number.toLowerCase().includes(term);
            const matchStatus = status === 'all' || r.status.toLowerCase() === status;
            return matchSearch && matchStatus;
        });
        renderRooms(filtered);
    }

    searchInput.addEventListener('input', filterRooms);
    statusFilter.addEventListener('change', filterRooms);

    // EVENT DELEGATION for dynamic table rows
    const tableBody = document.querySelector('tbody');
    
    tableBody.addEventListener('click', async (e) => {
        // --- EDIT BUTTON LOGIC ---
        const editBtn = e.target.closest('.btn-icon[title="Edit"]');
        if (editBtn) {
            e.preventDefault();
            const id = editBtn.getAttribute('data-id');
            const room = allRooms.find(r => r.id == id);
            
            if(room) {
                document.getElementById('modalTitle').innerText = 'Edit Room Details';
                document.getElementById('roomId').value = room.id;
                document.getElementById('roomNumber').value = room.room_number;
                document.getElementById('floor').value = room.floor;
                document.getElementById('roomType').value = room.room_type_id;
                document.getElementById('status').value = room.status.toLowerCase();
                document.getElementById('notes').value = room.notes || '';

                modal.classList.add('active');
            }
            return;
        }

        // --- DELETE BUTTON LOGIC ---
        const deleteBtn = e.target.closest('.btn-icon.delete');
        if (deleteBtn) {
            e.preventDefault();
            const id = deleteBtn.getAttribute('data-id');
            const room = allRooms.find(r => r.id == id);
            
            if (confirm(`Are you sure you want to delete Room ${room.room_number}?`)) {
                try {
                    const res = await fetch('../../Controler/AdminControler/manage-rooms.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) {
                        fetchRooms();
                    } else {
                        alert("Error: " + (json.error || "Could not delete room."));
                    }
                } catch(err) {
                    console.error(err);
                }
            }
        }
    });
});