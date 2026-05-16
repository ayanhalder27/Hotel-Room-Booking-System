// Load rooms and render table
async function loadRooms() {
  try {
    const response = await api("room_status_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
      status: qs("#statusFilter").value,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const rooms = response.data;

    const tableHTML = rooms.length
      ? rooms.map(renderRoomRow).join("")
      : '<tr><td colspan="6" class="empty">No rooms found</td></tr>';

    qs("#roomTable").innerHTML = tableHTML;

    // Set selected status for each room
    rooms.forEach((room) => {
      const el = qs("#st_" + room.id);
      if (el) el.value = room.status;
    });
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single room row
function renderRoomRow(room) {
  return `
        <tr>
            <td>${esc(room.room_number)}</td>
            <td>${esc(room.room_type)}</td>
            <td>${room.floor}</td>
            <td>${badge(room.status)}</td>
            <td>${esc(room.notes || "")}</td>
            <td>
                <select class="select" id="st_${room.id}">
                    <option value="available">available</option>
                    <option value="occupied">occupied</option>
                    <option value="dirty">dirty</option>
                    <option value="maintenance">maintenance</option>
                    <option value="blocked">blocked</option>
                </select>
                <button 
                    class="btn btn-primary" 
                    onclick="updateRoom(${room.id})"
                >
                    Update
                </button>
            </td>
        </tr>
    `;
}

// Update room status
async function updateRoom(id) {
  try {
    const response = await api("room_status_controller.php", {
      action: "update_status",
      id,
      status: qs("#st_" + id).value,
    });

    showAlert(response.message, response.success);

    if (response.success) {
      loadRooms();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadRooms);
qs("#statusFilter")?.addEventListener("change", loadRooms);
qs("#refreshBtn")?.addEventListener("click", loadRooms);

// Initial load
loadRooms();
