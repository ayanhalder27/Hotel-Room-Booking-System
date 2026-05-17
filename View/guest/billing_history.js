async function loadBills() {
  try {
    const r = await api("billing_controller.php", {
      action: "list",
      q: qs("#searchInput").value,
      payment_status: qs("#paymentFilter").value,
    });
    if (!r.success) return showAlert(r.message, false);
    qs("#billingTable").innerHTML = r.data.length
      ? r.data
          .map(
            (b) =>
              `<tr><td>#${b.booking_id}</td><td>${esc(b.room_type)}</td><td>${money(b.base_amount)}</td><td>${money(b.extras_amount)}</td><td>${money(b.discount_amount)}</td><td>${money(b.total_amount)}</td><td>${badge(b.payment_status)}</td><td>${esc(b.paid_at || "-")}</td></tr>`,
          )
          .join("")
      : '<tr><td colspan="8" class="empty">No billing history found</td></tr>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#searchInput")?.addEventListener("input", loadBills);
qs("#paymentFilter")?.addEventListener("change", loadBills);
qs("#refreshBtn")?.addEventListener("click", loadBills);
loadBills();
