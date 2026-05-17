        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('typeModal');
            const openBtn = document.getElementById('openModalBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const fileInput = document.getElementById('thumbnail');
            const fileNameDisplay = document.getElementById('fileNameDisplay');
            const typeForm = document.getElementById('typeForm');
            const tableBody = document.getElementById('roomTypesTableBody');
            
            let allRoomTypes = [];

            // Fetch and render data
            const loadRoomTypes = async () => {
                try {
                    const res = await fetch('../../Controler/AdminControler/room_types.php');
                    const json = await res.json();
                    if(json.success && json.data) {
                        allRoomTypes = json.data;
                        renderTable(allRoomTypes);
                    }
                } catch(e) {
                    console.error("Error fetching room types", e);
                }
            };

            const renderTable = (data, searchTerm = '') => {
                tableBody.innerHTML = '';
                const highlight = (text) => {
                    if (!searchTerm || !text) return text || '';
                    const regex = new RegExp(`(${searchTerm})`, 'gi');
                    return String(text).replace(regex, '<mark style="background-color: var(--gold, #FFD700); color: #000; border-radius: 2px; padding: 0 2px;">$1</mark>');
                };
                data.forEach(rt => {
                    const amenities = rt.amenities ? JSON.parse(rt.amenities) : [];
                    let amTags = amenities.map(a => `<span class="amenity-tag">${highlight(a)}</span>`).join(' ');
                    const thumbnail = rt.thumbnail_path ? `../../${rt.thumbnail_path}` : 'https://placehold.co/150x100?text=No+Image';

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><img src="${thumbnail}" alt="${rt.name}" class="type-thumbnail"></td>
                        <td class="type-name">${highlight(rt.name)}</td>
                        <td>$${parseFloat(rt.price_per_night).toFixed(2)}</td>
                        <td>${rt.max_capacity} Guests</td>
                        <td>
                            <div class="amenities-list">${amTags}</div>
                        </td>
                        <td class="description-cell">${highlight(rt.description || '')}</td>
                        <td><span class="room-count-badge">${rt.total_rooms} Rooms</span></td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon edit-btn" title="Edit" data-id="${rt.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                                <button class="btn-icon delete delete-btn" title="Delete" data-id="${rt.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(tr);
                });

                // Attach event listeners to new buttons
                document.querySelectorAll('.edit-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const id = e.currentTarget.getAttribute('data-id');
                        const rt = allRoomTypes.find(r => r.id == id);
                        if(rt) {
                            document.getElementById('modalTitle').innerText = 'Edit Room Type';
                            document.getElementById('typeId').value = rt.id;
                            document.getElementById('typeName').value = rt.name;
                            document.getElementById('basePrice').value = rt.price_per_night;
                            document.getElementById('maxCapacity').value = rt.max_capacity;
                            document.getElementById('description').value = rt.description;
                            
                            // Checkboxes
                            const ams = rt.amenities ? JSON.parse(rt.amenities) : [];
                            document.querySelectorAll('input[name="amenities[]"]').forEach(cb => {
                                cb.checked = ams.includes(cb.value);
                            });

                            fileNameDisplay.innerText = rt.thumbnail_path ? "Current: " + rt.thumbnail_path : "Supports JPG, PNG (Max 2MB)";
                            fileNameDisplay.style.color = "var(--text-secondary)";
                            modal.classList.add('active');
                        }
                    });
                });

                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        const id = e.currentTarget.getAttribute('data-id');
                        if(confirm('Are you sure you want to delete this room type? This cannot be undone if no rooms exist.')) {
                            try {
                                const res = await fetch('../../Controler/AdminControler/room_types.php', {
                                    method: 'DELETE',
                                    headers: {'Content-Type': 'application/json'},
                                    body: JSON.stringify({id: id})
                                });
                                const json = await res.json();
                                if(json.success) {
                                    loadRoomTypes();
                                } else {
                                    alert("Error: " + (json.error || "Could not delete. Make sure there are no rooms associated with this type."));
                                }
                            } catch(err) {
                                console.error(err);
                            }
                        }
                    });
                });
            };

            // Search
            document.querySelector('.search-box input').addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                const filtered = allRoomTypes.filter(rt => {
                    const amText = rt.amenities ? JSON.parse(rt.amenities).join(' ') : '';
                    const searchableText = `${rt.name} ${rt.description || ''} ${amText}`.toLowerCase();
                    return searchableText.includes(term);
                });
                renderTable(filtered, term);
            });

            // Handle file input display
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    fileNameDisplay.innerText = "Selected: " + this.files[0].name;
                    fileNameDisplay.style.color = "var(--gold)";
                } else {
                    fileNameDisplay.innerText = "Supports JPG, PNG (Max 2MB)";
                    fileNameDisplay.style.color = "var(--text-secondary)";
                }
            });

            // Open modal
            openBtn.addEventListener('click', () => {
                document.getElementById('modalTitle').innerText = 'Add New Room Type';
                typeForm.reset();
                document.getElementById('typeId').value = '';
                fileNameDisplay.innerText = "Supports JPG, PNG (Max 2MB)";
                fileNameDisplay.style.color = "var(--text-secondary)";
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
            typeForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(typeForm);
                
                try {
                    const res = await fetch('../../Controler/AdminControler/room_types.php', {
                        method: 'POST',
                        body: formData
                    });
                    const json = await res.json();
                    if(json.success) {
                        closeModal();
                        loadRoomTypes();
                    } else {
                        alert("Error saving room type");
                    }
                } catch(err) {
                    console.error("Error", err);
                }
            });

            // Initial load
            loadRoomTypes();
        });
