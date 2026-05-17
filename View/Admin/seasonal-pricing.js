let allPricingRules = [];

async function fetchPricingRules() {
    try {
        const response = await fetch('../../Controler/AdminControler/seasonal_pricing_api.php');
        const json = await response.json();
        if(json.success && json.data) {
            allPricingRules = json.data;
            renderPricingRules(allPricingRules);
        }
    } catch(err) {
        console.error('Error fetching pricing rules:', err);
    }
}

function renderPricingRules(rules) {
    const tbody = document.getElementById('pricingTableBody');
    tbody.innerHTML = '';
    
    rules.forEach(rule => {
        const tr = document.createElement('tr');
        
        let badgeClass = 'active';
        let badgeText = 'Active Now';
        if(rule.status === 'upcoming') { badgeClass = 'upcoming'; badgeText = 'Upcoming'; }
        if(rule.status === 'expired') { badgeClass = 'expired'; badgeText = 'Expired'; }

        tr.innerHTML = `
            <td class="label-name">${rule.label}</td>
            <td>${rule.room_type_name}</td>
            <td>
                <div class="date-range">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <span>${rule.start_date} to ${rule.end_date}</span>
                </div>
            </td>
            <td class="price-highlight">$${parseFloat(rule.price_per_night).toFixed(2)}</td>
            <td><span class="badge ${badgeClass}">${badgeText}</span></td>
            <td>
                <div class="action-btns">
                    <button class="btn-icon edit-btn" title="Edit" data-id="${rule.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></button>
                    <button class="btn-icon delete delete-btn" title="Delete" data-id="${rule.id}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            const rule = allPricingRules.find(r => r.id == id);
            if(rule) {
                document.getElementById('modalTitle').innerText = 'Edit Pricing Rule';
                document.getElementById('ruleId').value = rule.id;
                document.getElementById('label').value = rule.label;
                document.getElementById('roomTypeId').value = rule.room_type_id;
                document.getElementById('startDate').value = rule.start_date;
                document.getElementById('endDate').value = rule.end_date;
                document.getElementById('pricePerNight').value = rule.price_per_night;
                document.getElementById('pricingModal').classList.add('modal-active');
            }
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const id = e.currentTarget.getAttribute('data-id');
            if(confirm('Delete this pricing rule?')) {
                try {
                    const res = await fetch('../../Controler/AdminControler/seasonal_pricing_api.php', {
                        method: 'DELETE',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify({id: id})
                    });
                    const json = await res.json();
                    if(json.success) fetchPricingRules();
                } catch(err) { console.error(err); }
            }
        });
    });
}

// Fetch room types to populate the select options dynamically
async function fetchRoomTypesForSelect() {
    try {
        const response = await fetch('../../Controler/AdminControler/room_types.php');
        const json = await response.json();
        if(json.success && json.data) {
            const rtSelect = document.getElementById('roomTypeId');
            const filterSelect = document.querySelector('select[name="room_type_filter"]');
            
            // Clear existing except first option
            rtSelect.innerHTML = '<option value="">Select a Room Type...</option>';
            filterSelect.innerHTML = '<option value="all">All Room Types</option>';
            
            json.data.forEach(rt => {
                const opt1 = document.createElement('option');
                opt1.value = rt.id;
                opt1.textContent = `${rt.name} (Base: $${rt.price_per_night})`;
                rtSelect.appendChild(opt1);

                const opt2 = document.createElement('option');
                opt2.value = rt.id;
                opt2.textContent = rt.name;
                filterSelect.appendChild(opt2);
            });
        }
    } catch(err) {
        console.error('Error fetching room types:', err);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchPricingRules();
    fetchRoomTypesForSelect();

    const searchInput = document.querySelector('.search-box input');
    const typeFilter = document.querySelector('select[name="room_type_filter"]');

    function filterRules() {
        const term = searchInput.value.toLowerCase();
        const type = typeFilter.value;
        
        const filtered = allPricingRules.filter(r => {
            const matchSearch = r.label.toLowerCase().includes(term);
            const matchType = type === 'all' || r.room_type_id == type;
            return matchSearch && matchType;
        });
        renderPricingRules(filtered);
    }

    searchInput.addEventListener('input', filterRules);
    typeFilter.addEventListener('change', filterRules);

    const modal = document.getElementById('pricingModal');
    const openBtn = document.getElementById('openModalBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');
    const pricingForm = document.getElementById('pricingForm');

    openBtn.addEventListener('click', () => {
        document.getElementById('modalTitle').innerText = 'Add Pricing Rule';
        pricingForm.reset();
        document.getElementById('ruleId').value = '';
        modal.classList.add('modal-active');
    });

    const closeModal = () => modal.classList.remove('modal-active');
    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    pricingForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (startDate && endDate && startDate >= endDate) {
            alert("End Date must be strictly after the Start Date.");
            return;
        }

        const formData = new FormData(pricingForm);
        try {
            const res = await fetch('../../Controler/AdminControler/seasonal_pricing_api.php', {
                method: 'POST',
                body: formData
            });
            const json = await res.json();
            if(json.success) {
                fetchPricingRules();
                closeModal();
            } else {
                alert('Failed to save pricing rule.');
            }
        } catch(err) { console.error(err); }
    });
});
