const CHECKOUT_Controler = "../../Controler/checkout_Controler.php";
async function searchCheckoutBooking() {
  const q = checkoutSearch.value.trim();
  if (!q)
    return showAlert(
      "checkoutAlert",
      "Enter room number, guest name, or booking ID.",
      "error",
    );
  try {
    const res = await getJson(
      `${CHECKOUT_Controler}?action=search&q=${encodeURIComponent(q)}`,
    );
    if (!res.success) return showAlert("checkoutAlert", res.message, "error");
    checkoutTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.booking_id}</td><td>${r.guest_name}</td><td>${r.room_number}</td><td>${r.checkout_date}</td><td>${badge(r.payment_status)}</td><td>${r.total_amount}</td><td>${r.payment_status === "paid" ? `<button class="btn btn-success" onclick="submitCheckout(${r.booking_id})">Check Out</button>` : '<a class="btn btn-warning" href="payment.php">Pay First</a>'}</td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="7" class="empty">No checked-in guest found.</td></tr>';
  } catch (e) {
    showAlert("checkoutAlert", "Search failed.", "error");
  }
}
async function submitCheckout(bookingId) {
  if (!confirm("Confirm guest checkout?")) return;
  const data = new FormData();
  data.append("action", "checkout");
  data.append("booking_id", bookingId);
  try {
    const res = await postForm(CHECKOUT_Controler, data);
    showAlert("checkoutAlert", res.message, res.success ? "success" : "error");
    if (res.success) searchCheckoutBooking();
  } catch (e) {
    showAlert("checkoutAlert", "Checkout failed.", "error");
  }
}
