async function loadDashboard() {
    try {
        const res = await fetch('../../Controler/AdminControler/dashboard_api.php');
        const json = await res.json();
        if(json.success) {
            const data = json.data;
            
            // Occupancy
            document.getElementById('occupancyVal').innerText = data.occupancy_rate + '%';
            const occBar = document.getElementById('occupancyBar');
            if(occBar) {
                occBar.setAttribute('data-width', data.occupancy_rate + '%');
                setTimeout(() => { occBar.style.width = data.occupancy_rate + '%'; }, 300);
            }
            
            // Revenue
            const formattedRevenue = parseFloat(data.today_revenue).toLocaleString('en-US', { style: 'currency', currency: 'USD' });
            document.getElementById('todayRevenueVal').innerText = formattedRevenue;
            
            // Rooms
            document.getElementById('roomStatusVal').innerHTML = \`\${data.occupied_rooms} <span style="font-size: 1rem; color: var(--text-secondary); font-weight: 400; font-family: var(--font-body);">/ \${data.total_rooms}</span>\`;
            document.getElementById('occupiedRoomsVal').innerText = data.occupied_rooms;
            document.getElementById('availableRoomsVal').innerText = data.available_rooms;
            
            const occPct = data.total_rooms > 0 ? (data.occupied_rooms / data.total_rooms) * 100 : 0;
            const availPct = data.total_rooms > 0 ? (data.available_rooms / data.total_rooms) * 100 : 100;
            document.getElementById('occupiedBar').style.flexBasis = occPct + '%';
            document.getElementById('availableBar').style.flexBasis = availPct + '%';
            
            // Maintenance and Reviews
            document.getElementById('activeMaintenanceVal').innerText = data.active_maintenance;
            document.getElementById('pendingReviewsVal').innerText = data.pending_reviews;
            
            // Bookings Table
            const tbody = document.getElementById('recentBookingsBody');
            tbody.innerHTML = '';
            if(data.recent_bookings) {
                data.recent_bookings.forEach(b => {
                    const tr = document.createElement('tr');
                    
                    let badgeClass = 'pending';
                    if(b.status === 'confirmed') badgeClass = 'confirmed';
                    else if(b.status === 'checked-in') badgeClass = 'checked-in';
                    else if(b.status === 'checked-out') badgeClass = 'expired';
                    
                    tr.innerHTML = \`
                        <td>
                            <div style="font-weight: 500;">\${b.guest_name}</div>
                            <div style="font-size: 0.85rem; color: var(--text-secondary);">ID: #BKG-\${b.id}</div>
                        </td>
                        <td>\${b.room_type || 'Unassigned'}</td>
                        <td>\${b.check_in_date} - \${b.check_out_date}</td>
                        <td style="font-family: var(--font-heading); font-weight: 600;">$\${parseFloat(b.total_price).toFixed(2)}</td>
                        <td><span class="badge \${badgeClass}">\${b.status.charAt(0).toUpperCase() + b.status.slice(1)}</span></td>
                    \`;
                    tbody.appendChild(tr);
                });
            }
        }
    } catch(err) {
        console.error("Failed to load dashboard data", err);
    }
}

document.addEventListener('DOMContentLoaded', loadDashboard);
