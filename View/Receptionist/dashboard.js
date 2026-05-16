// Load dashboard statistics
async function loadDashboard() {
  try {
    const response = await api("receptionist_dashboard_controller.php", {
      action: "stats",
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const data = response.data;

    // Stats cards
    const stats = [
      [
        "Expected Check-ins",
        data.expected_checkins,
        "Today confirmed arrivals",
      ],
      [
        "Expected Check-outs",
        data.expected_checkouts,
        "Today scheduled departures",
      ],
      ["Checked-in Guests", data.checked_in_guests, "Currently staying"],
      ["Available Rooms", data.available_rooms, "Ready for assignment"],
      ["Occupied Rooms", data.occupied_rooms, "In use now"],
      ["Dirty Rooms", data.dirty_rooms, "Need housekeeping"],
      ["Pending Requests", data.pending_requests, "Guest service queue"],
      ["Revenue Today", money(data.revenue_today), "Collected payments"],
    ];

    qs("#dashboardStats").innerHTML = stats.map(renderStatCard).join("");

    // Room type table
    qs("#roomTypeTable").innerHTML = (data.rooms_by_type || []).length
      ? data.rooms_by_type.map(renderRoomTypeRow).join("")
      : '<tr><td colspan="2" class="empty">No data</td></tr>';
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single stat card
function renderStatCard([title, value, description]) {
  return `
        <div class="card stat-card">
            <h3>${title}</h3>
            <div class="num">${value}</div>
            <p>${description}</p>
        </div>
    `;
}

// Render a single room type row
function renderRoomTypeRow(roomType) {
  return `
        <tr>
            <td>${esc(roomType.name)}</td>
            <td>${roomType.available_rooms}</td>
        </tr>
    `;
}

// Event listeners
qs("#refreshDashboard")?.addEventListener("click", loadDashboard);

// Initial load
loadDashboard();
