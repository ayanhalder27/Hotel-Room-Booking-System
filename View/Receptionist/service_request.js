const SERVICE_Controler = "../../Controler/service_request_Controler.php";
async function loadServiceRequests() {
  const q = serviceSearch.value || "";
  const status = serviceStatus.value || "";
  try {
    const res = await getJson(
      `${SERVICE_Controler}?action=list&q=${encodeURIComponent(q)}&status=${encodeURIComponent(status)}`,
    );
    if (!res.success) return showAlert("serviceAlert", res.message, "error");
    serviceTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.id}</td><td>${r.guest_name}</td><td>${r.room_number}</td><td>${r.service_type}</td><td>${r.description}</td><td>${badge(r.status)}</td><td>${r.requested_at}</td><td><div class="action-row"><button class="btn btn-warning" onclick="updateServiceStatus(${r.id}, 'in_progress')">In Progress</button><button class="btn btn-success" onclick="updateServiceStatus(${r.id}, 'completed')">Completed</button></div></td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="8" class="empty">No service request found.</td></tr>';
  } catch (e) {
    showAlert("serviceAlert", "Service request loading failed.", "error");
  }
}
async function updateServiceStatus(id, status) {
  const data = new FormData();
  data.append("action", "update_status");
  data.append("id", id);
  data.append("status", status);
  try {
    const res = await postForm(SERVICE_Controler, data);
    showAlert("serviceAlert", res.message, res.success ? "success" : "error");
    if (res.success) loadServiceRequests();
  } catch (e) {
    showAlert("serviceAlert", "Status update failed.", "error");
  }
}
document.addEventListener("DOMContentLoaded", loadServiceRequests);
