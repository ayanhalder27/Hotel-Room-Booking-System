async function loadBookings() {
  try {
    const r = await api("my_bookings_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
      status: qs("#statusFilter").value,
    });
    if (!r.success) return showAlert(r.message, false);
    qs("#bookingTable").innerHTML = r.data.length
      ? r.data.map(renderBookingRow).join("")
      : '<tr><td colspan="7" class="empty">No bookings found</td></tr>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
function renderBookingRow(b) {
  return `<tr><td>#${b.id}</td><td>${esc(b.room_type)}</td><td>${esc(b.checkin_date)} → ${esc(b.checkout_date)}</td><td>${esc(b.num_guests)}</td><td>${money(b.total_price)}</td><td>${badge(b.status)}</td><td><div class="action-row"><a class="btn btn-light" href="booking_details.php?booking_id=${b.id}">Details</a>${b.can_cancel ? `<button class="btn btn-danger" onclick="cancelBooking(${b.id})">Cancel</button>` : ""}${b.can_modify ? `<button class="btn btn-primary" onclick="requestModify(${b.id})">Modify</button>` : ""}</div></td></tr>`;
}
async function cancelBooking(id) {
  if (!confirm("Cancel this booking?")) return;
  const r = await api("my_bookings_controller.php", {
    action: "cancel",
    booking_id: id,
  });
  showAlert(r.message, r.success);
  if (r.success) loadBookings();
}
async function requestModify(id) {
  const ci = prompt("Enter new check-in date (YYYY-MM-DD):");
  if (!ci) return;
  const co = prompt("Enter new check-out date (YYYY-MM-DD):");
  if (!co) return;
  const r = await api("my_bookings_controller.php", {
    action: "request_modify",
    booking_id: id,
    checkin_date: ci,
    checkout_date: co,
  });
  showAlert(r.message, r.success);
}
qs("#searchInput")?.addEventListener("input", loadBookings);
qs("#statusFilter")?.addEventListener("change", loadBookings);
qs("#refreshBtn")?.addEventListener("click", loadBookings);
loadBookings();
