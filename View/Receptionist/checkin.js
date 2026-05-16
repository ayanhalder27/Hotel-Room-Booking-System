// Load confirmed bookings and render them in the table
async function loadBookings() {
  try {
    const searchQuery = qs("#searchInput").value;

    const response = await api(
      "checkin_controller.php",
      {
        action: "search",
        q: searchQuery,
      },
    );

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const bookings = response.data;

    const tableHTML = bookings.length
      ? bookings.map(renderBookingRow).join("")
      : '<tr><td colspan="7" class="empty">No confirmed bookings found</td></tr>';

    qs("#bookingTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single booking row
function renderBookingRow(booking) {
  const roomOptions = (booking.available_rooms || [])
    .map(
      (room) => `
            <option value="${room.id}">
                ${esc(room.room_number)} - Floor ${room.floor}
            </option>
        `,
    )
    .join("");

  return `
        <tr>
            <td>#${booking.id}</td>
            <td>${esc(booking.guest_name)}</td>
            <td>${esc(booking.national_id)}</td>
            <td>${esc(booking.room_type)}</td>
            <td>${booking.checkin_date} → ${booking.checkout_date}</td>
            <td>
                <select class="select" id="room_${booking.id}">
                    ${roomOptions}
                </select>
            </td>
            <td>
                <button 
                    class="btn btn-success" 
                    onclick="checkIn(${booking.id})"
                    ${booking.available_rooms.length ? "" : "disabled"}
                >
                    Check In
                </button>
            </td>
        </tr>
    `;
}

// Perform check-in for a booking
async function checkIn(bookingId) {
  const roomId = qs("#room_" + bookingId)?.value;

  if (!roomId) {
    return showAlert("No available room selected", false);
  }

  try {
    const response = await api(
      "checkin_controller.php",
      {
        action: "checkin",
        booking_id: bookingId,
        room_id: roomId,
      },
    );

    showAlert(response.message, response.success);

    if (response.success) {
      loadBookings();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadBookings);
qs("#searchBtn")?.addEventListener("click", loadBookings);

// Initial load
loadBookings();
