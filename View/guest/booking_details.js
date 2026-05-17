async function loadDetails() {
  const id = qs("#bookingId")?.value;
  if (!id) {
    qs("#detailsBox").innerHTML =
      '<div class="card empty">No booking selected.</div>';
    return;
  }
  try {
    const r = await api("my_bookings_controller.php", {
      action: "details",
      booking_id: id,
    });
    if (!r.success) return showAlert(r.message, false);
    const b = r.data;
    qs("#detailsBox").innerHTML =
      `<div class="card detail-card"><div class="section-head"><div><h2>Booking #${b.id}</h2><p>${esc(b.room_type)} | ${esc(b.checkin_date)} → ${esc(b.checkout_date)}</p></div>${badge(b.status)}</div><div class="grid grid-3 mt-20"><div class="mini-box"><span>Guests</span><strong>${esc(b.num_guests)}</strong></div><div class="mini-box"><span>Total</span><strong>${money(b.total_price)}</strong></div><div class="mini-box"><span>Room</span><strong>${esc(b.room_number || "Not assigned")}</strong></div></div><div class="mt-20"><h3>Billing</h3><p>Payment: ${badge(b.payment_status || "pending")} | Amount: ${money(b.total_amount || b.total_price)}</p></div><div class="action-row mt-20"><a class="btn btn-light" href="my_bookings.php">Back to Bookings</a><a class="btn btn-gradient" href="service_requests.php">Request Service</a></div></div>`;
  } catch (e) {
    showAlert(e.message, false);
  }
}
loadDetails();
