async function loadActiveBookings() {
  const r = await api("service_request_controller.php", {
    action: "active_bookings",
  });
  qs("#activeBookingSelect").innerHTML = (r.data || []).length
    ? r.data
        .map(
          (b) =>
            `<option value="${b.id}">#${b.id} - ${esc(b.room_type)} ${esc(b.room_number || "")}</option>`,
        )
        .join("")
    : '<option value="">No active booking</option>';
}
async function loadRequests() {
  try {
    const r = await api("service_request_controller.php", { action: "list" });
    if (!r.success) return showAlert(r.message, false);
    qs("#requestTable").innerHTML = r.data.length
      ? r.data
          .map(
            (x) =>
              `<tr><td>#${x.booking_id}</td><td>${esc(x.service_type)}</td><td>${esc(x.description)}</td><td>${badge(x.status)}</td></tr>`,
          )
          .join("")
      : '<tr><td colspan="4" class="empty">No service requests found</td></tr>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#requestForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const d = Object.fromEntries(new FormData(e.target));
  d.action = "create";
  try {
    const r = await api("service_request_controller.php", d);
    showAlert(r.message, r.success);
    if (r.success) {
      e.target.reset();
      loadRequests();
    }
  } catch (err) {
    showAlert(err.message, false);
  }
});
qs("#refreshBtn")?.addEventListener("click", loadRequests);
loadActiveBookings();
loadRequests();
