// Load active stays and render them in the checkout table
async function loadCheckout() {
  try {
    const searchQuery = qs("#searchInput").value;

    const response = await api("checkout_controller.php", {
      action: "search",
      q: searchQuery,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const stays = response.data;

    const tableHTML = stays.length
      ? stays.map(renderCheckoutRow).join("")
      : '<tr><td colspan="7" class="empty">No active stays found</td></tr>';

    qs("#checkoutTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single checkout row
function renderCheckoutRow(stay) {
  return `
        <tr>
            <td>#${stay.id}</td>
            <td>${esc(stay.guest_name)}</td>
            <td>${esc(stay.room_number)}</td>
            <td>${stay.checkin_date} → ${stay.checkout_date}</td>
            <td>${badge(stay.payment_status)}</td>
            <td>${money(stay.total_amount)}</td>
            <td>
                <button 
                    class="btn btn-warning" 
                    onclick="checkout(${stay.id})"
                >
                    Check Out
                </button>
            </td>
        </tr>
    `;
}

// Perform checkout for a guest
async function checkout(bookingId) {
  if (!confirm("Check out this guest?")) {
    return;
  }

  try {
    const response = await api("checkout_controller.php", {
      action: "checkout",
      booking_id: bookingId,
    });

    showAlert(response.message, response.success);

    if (response.success) {
      loadCheckout();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadCheckout);
qs("#searchBtn")?.addEventListener("click", loadCheckout);

// Initial load
loadCheckout();
