const ROOM_Controler = "../../Controler/room_status_Controler.php";
async function loadRoomTypesForFilter() {
  try {
    const res = await getJson(`${ROOM_Controler}?action=room_types`);
    roomTypeFilter.innerHTML =
      '<option value="">All Types</option>' +
      (res.data || [])
        .map((r) => `<option value="${r.id}">${r.name}</option>`)
        .join("");
  } catch (e) {}
}
async function loadRoomStatus() {
  const q = roomSearch.value || "";
  const status = roomStatusFilter.value || "";
  const type = roomTypeFilter.value || "";
  try {
    const res = await getJson(
      `${ROOM_Controler}?action=list&q=${encodeURIComponent(q)}&status=${encodeURIComponent(status)}&room_type_id=${encodeURIComponent(type)}`,
    );
    if (!res.success) return showAlert("roomAlert", res.message, "error");
    roomStatusTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.room_number}</td><td>${r.room_type}</td><td>${r.floor}</td><td>${badge(r.status)}</td><td>${r.notes || ""}</td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="5" class="empty">No room found.</td></tr>';
  } catch (e) {
    showAlert("roomAlert", "Room status loading failed.", "error");
  }
}
document.addEventListener("DOMContentLoaded", () => {
  loadRoomTypesForFilter();
  loadRoomStatus();
});
