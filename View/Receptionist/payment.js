// Load bills and render table
async function loadBills() {
  try {
    const response = await api("payment_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const bills = response.data;

    const tableHTML = bills.length
      ? bills.map(renderBillRow).join("")
      : '<tr><td colspan="8" class="empty">No bills found</td></tr>';

    qs("#billTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single bill row
function renderBillRow(bill) {
  return `
        <tr>
            <td>#${bill.booking_id}</td>
            <td>${esc(bill.guest_name)}</td>
            <td>${money(bill.base_amount)}</td>
            <td>${money(bill.extras_amount)}</td>
            <td>${money(bill.discount_amount)}</td>
            <td>${money(bill.total_amount)}</td>
            <td>${badge(bill.payment_status)}</td>
            <td>
                <select class="select" id="pm_${bill.id}">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                    <option value="bank">Bank</option>
                </select>
                <input 
                    class="input" 
                    id="pts_${bill.id}" 
                    type="number" 
                    min="0" 
                    placeholder="Points" 
                    style="margin:6px 0"
                >
                <button 
                    class="btn btn-success" 
                    onclick="pay(${bill.id})"
                >
                    Pay
                </button>
            </td>
        </tr>
    `;
}

// Handle payment
async function pay(billingId) {
  try {
    const response = await api("payment_controller.php", {
      action: "pay",
      billing_id: billingId,
      payment_method: qs("#pm_" + billingId).value,
      points_used: qs("#pts_" + billingId).value || 0,
    });

    showAlert(response.message, response.success);

    if (response.success) {
      loadBills();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadBills);
qs("#refreshBtn")?.addEventListener("click", loadBills);

// Initial load
loadBills();
