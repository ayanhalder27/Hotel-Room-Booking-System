document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('../../Controler/AdminControler/reports_api.php?type=loyalty');
        const json = await res.json();
        if(json.success) {
            document.getElementById('pointsIssuedVal').innerText = json.data.points_issued.toLocaleString();
            document.getElementById('pointsRedeemedVal').innerText = json.data.points_redeemed.toLocaleString();
            document.getElementById('activeMembersVal').innerText = json.data.active_members.toLocaleString();
            document.getElementById('liabilityVal').innerText = '$' + json.data.liability.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
    } catch(err) {
        console.error('Error loading loyalty report:', err);
    }
});
