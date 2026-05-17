// Load today's check-ins and render table
async function loadCheckins() {
  try {
    const response = await api("today_checkins_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const checkins = response.data;

    const tableHTML = checkins.length
      ? checkins.map(renderCheckinRow).join("")
      : '<tr><td colspan="7" class="empty">No check-ins found</td></tr>';

    qs("#checkinsTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single check-in row
function renderCheckinRow(booking) {
  return `
        <tr>
            <td>#${booking.id}</td>
            <td>${esc(booking.guest_name)}</td>
            <td>${esc(booking.room_type)}</td>
            <td>${esc(booking.checkin_date)} → ${esc(booking.checkout_date)}</td>
            <td>${booking.num_guests}</td>
            <td>${money(booking.total_price)}</td>
            <td>
                <button 
                    class="btn btn-success" 
                    onclick="location.href='checkin.php?booking_id=${booking.id}'"
                >
                    Check In
                </button>
            </td>
        </tr>
    `;
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadCheckins);
qs("#refreshBtn")?.addEventListener("click", loadCheckins);

// Initial load
loadCheckins();
