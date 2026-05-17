document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('../../Controler/AdminControler/reports_api.php?type=occupancy');
        const json = await res.json();
        if(json.success) {
            document.getElementById('avgOccupancyVal').innerText = json.data.avg_occupancy + '%';
            document.getElementById('totalNightsVal').innerText = json.data.total_nights.toLocaleString();
            document.getElementById('avgStayVal').innerHTML = \`\${json.data.avg_stay} <span style="font-size: 1rem; color: var(--text-secondary); font-family: var(--font-body); font-weight: 400;">Nights</span>\`;
            document.getElementById('popularRoomVal').innerText = json.data.popular_room;
        }
    } catch(err) {
        console.error('Error loading occupancy report:', err);
    }
});
