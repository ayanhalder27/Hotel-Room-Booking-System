async function loadLoyalty() {
  try {
    const r = await api("loyalty_controller.php", { action: "summary" });
    if (!r.success) return showAlert(r.message, false);
    const d = r.data;
    qs("#loyaltyStats").innerHTML = [
      ["Available Balance", d.balance, "Points ready to redeem"],
      ["Total Earned", d.total_earned, "Lifetime earned points"],
      ["Total Used", d.total_used, "Redeemed discount points"],
    ]
      .map(
        ([t, v, p]) =>
          `<div class="card stat-card"><h3>${esc(t)}</h3><div class="num">${esc(v)}</div><p>${esc(p)}</p></div>`,
      )
      .join("");
    qs("#loyaltyTable").innerHTML = (d.history || []).length
      ? d.history
          .map(
            (x) =>
              `<tr><td>#${x.booking_id || "-"}</td><td>${esc(x.points_earned)}</td><td>${esc(x.points_used)}</td><td>${esc(x.balance)}</td><td>${esc(x.created_at)}</td></tr>`,
          )
          .join("")
      : '<tr><td colspan="5" class="empty">No loyalty history found</td></tr>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#refreshBtn")?.addEventListener("click", loadLoyalty);
loadLoyalty();
