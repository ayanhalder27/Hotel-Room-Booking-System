// Load service requests and render table
async function loadRequests() {
  try {
    const response = await api("service_request_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
      status: qs("#statusFilter").value,
    });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const requests = response.data;

    const tableHTML = requests.length
      ? requests.map(renderRequestRow).join("")
      : '<tr><td colspan="7" class="empty">No requests found</td></tr>';

    qs("#requestTable").innerHTML = tableHTML;
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single request row
function renderRequestRow(request) {
  return `
        <tr>
            <td>${request.id}</td>
            <td>${esc(request.guest_name)}</td>
            <td>${esc(request.room_number || "N/A")}</td>
            <td>${esc(request.service_type)}</td>
            <td>${esc(request.description)}</td>
            <td>${badge(request.status)}</td>
            <td>
                <button 
                    class="btn btn-warning" 
                    onclick="setStatus(${request.id}, 'in_progress')"
                >
                    In Progress
                </button>
                <button 
                    class="btn btn-success" 
                    onclick="setStatus(${request.id}, 'completed')"
                >
                    Complete
                </button>
            </td>
        </tr>
    `;
}

// Update request status
async function setStatus(id, status) {
  try {
    const response = await api("service_request_controller.php", {
      action: "update_status",
      id,
      status,
    });

    showAlert(response.message, response.success);

    if (response.success) {
      loadRequests();
    }
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Event listeners
qs("#searchInput")?.addEventListener("input", loadRequests);
qs("#statusFilter")?.addEventListener("change", loadRequests);
qs("#refreshBtn")?.addEventListener("click", loadRequests);

// Initial load
loadRequests();
