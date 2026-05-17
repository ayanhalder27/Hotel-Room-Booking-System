document.addEventListener('DOMContentLoaded', async () => {
    try {
        const res = await fetch('../../Controler/AdminControler/reports_api.php?type=finance');
        const json = await res.json();
        if(json.success) {
            const formatCurrency = val => parseFloat(val).toLocaleString('en-US', {style: 'currency', currency: 'USD'});
            
            document.getElementById('grossRevenueVal').innerText = formatCurrency(json.data.gross_revenue);
            document.getElementById('roomsRevenueVal').innerText = formatCurrency(json.data.rooms_revenue);
            document.getElementById('extrasRevenueVal').innerText = formatCurrency(json.data.extras_revenue);
            document.getElementById('adrVal').innerText = formatCurrency(json.data.adr);
            
            // Further DOM updates for charts or tables could go here
        }
    } catch(err) {
        console.error('Error loading finance report:', err);
    }
});
