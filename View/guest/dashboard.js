async function loadDashboard() {
  try {
    const r = await api("guest_dashboard_controller.php", { action: "stats" });
    if (!r.success) return showAlert(r.message, false);
    const d = r.data;
    qs("#dashboardStats").innerHTML = [
      ["Upcoming", d.upcoming_bookings, "Future reservations"],
      ["Active Stay", d.active_stays, "Currently checked in"],
      ["Completed", d.completed_stays, "Past hotel stays"],
      ["Loyalty", d.loyalty_balance, "Available points"],
    ]
      .map(
        ([t, v, p]) =>
          `<div class="card stat-card"><h3>${esc(t)}</h3><div class="num">${esc(v)}</div><p>${esc(p)}</p></div>`,
      )
      .join("");
    qs("#upcomingTable").innerHTML = (d.upcoming || []).length
      ? d.upcoming
          .map(
            (b) =>
              `<tr><td>#${b.id}</td><td>${esc(b.room_type)}</td><td>${esc(b.checkin_date)} → ${esc(b.checkout_date)}</td><td>${badge(b.status)}</td></tr>`,
          )
          .join("")
      : '<tr><td colspan="4" class="empty">No upcoming bookings</td></tr>';
    qs("#billTable").innerHTML = (d.recent_bills || []).length
      ? d.recent_bills
          .map(
            (b) =>
              `<tr><td>#${b.booking_id}</td><td>${money(b.total_amount)}</td><td>${badge(b.payment_status)}</td></tr>`,
          )
          .join("")
      : '<tr><td colspan="3" class="empty">No bills found</td></tr>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#refreshDashboard")?.addEventListener("click", loadDashboard);
loadDashboard();
