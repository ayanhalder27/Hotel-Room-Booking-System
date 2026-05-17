async function calculateTotal() {
  const f = qs("#bookingForm"),
    d = Object.fromEntries(new FormData(f));
  d.action = "estimate";
  if (!d.room_type_id || !d.checkin_date || !d.checkout_date) return;
  try {
    const r = await api("booking_controller.php", d);
    if (!r.success) {
      qs("#estimatedTotal").value = "";
      qs("#bookingSummary").innerHTML =
        `<div class="empty">${esc(r.message)}</div>`;
      return;
    }
    const x = r.data;
    qs("#estimatedTotal").value = money(x.total_price);
    qs("#bookingSummary").innerHTML =
      `<h3>Booking Summary</h3><p><strong>Room:</strong> ${esc(x.room_type)}</p><p><strong>Nights:</strong> ${esc(x.nights)}</p><p><strong>Price/Night:</strong> ${money(x.price_per_night)}</p><p><strong>Total:</strong> ${money(x.total_price)}</p>${x.seasonal_notice ? `<p class="notice">${esc(x.seasonal_notice)}</p>` : ""}`;
  } catch (e) {
    showAlert(e.message, false);
  }
}
qs("#bookingForm")?.addEventListener("change", calculateTotal);
qs("#bookingForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const d = Object.fromEntries(new FormData(e.target));
  d.action = "create";
  try {
    const r = await api("booking_controller.php", d);
    showAlert(r.message, r.success);
    if (r.success && r.data?.booking_id)
      setTimeout(
        () =>
          (location.href = `booking_details.php?booking_id=${r.data.booking_id}`),
        800,
      );
  } catch (err) {
    showAlert(err.message, false);
  }
});
calculateTotal();
