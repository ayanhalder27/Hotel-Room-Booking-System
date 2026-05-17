// Load all bookings and render them in the table
async function loadBookings() {
  const searchQuery = qs("#searchInput").value;

  const response = await api("booking_modify_controller.php", {
    action: "list",
    q: searchQuery,
  });

  if (!response.success) {
    return showAlert(response.message, false);
  }

  const bookings = response.data;

  const tableHTML = bookings.length
    ? bookings.map(renderBookingRow).join("")
    : '<tr><td colspan="6" class="empty">No bookings found</td></tr>';

  qs("#bookingTable").innerHTML = tableHTML;
}

// Render a single booking row
function renderBookingRow(booking) {
  return `
        <tr>
            <td>#${booking.id}</td>
            <td>${esc(booking.guest_name)}</td>
            <td>${esc(booking.room_type)}</td>
            <td>${booking.checkin_date} → ${booking.checkout_date}</td>
            <td>${badge(booking.status)}</td>
            <td>
                <input 
                    class="input" 
                    id="ci_${booking.id}" 
                    type="date" 
                    value="${booking.checkin_date}"
                >
                <input 
                    class="input" 
                    id="co_${booking.id}" 
                    type="date" 
                    value="${booking.checkout_date}" 
                    style="margin:6px 0"
                >
                <button 
                    class="btn btn-primary" 
                    onclick="modify(${booking.id})"
                >
                    Save
                </button>
            </td>
        </tr>
    `;
}

// Update booking dates
async function modify(id) {
  const checkinDate = qs("#ci_" + id).value;
  const checkoutDate = qs("#co_" + id).value;

  const response = await api("booking_modify_controller.php", {
    action: "update_dates",
    booking_id: id,
    checkin_date: checkinDate,
    checkout_date: checkoutDate,
  });

  showAlert(response.message, response.success);
  loadBookings();
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadBookings);
qs("#refreshBtn")?.addEventListener("click", loadBookings);

// Initial load
loadBookings();
