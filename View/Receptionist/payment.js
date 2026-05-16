const PAYMENT_Controler = "../../Controler/payment_Controler.php";
async function searchBill() {
  const q = paymentSearch.value.trim();
  if (!q)
    return showAlert(
      "paymentAlert",
      "Enter booking ID or guest name.",
      "error",
    );
  try {
    const res = await getJson(
      `${PAYMENT_Controler}?action=search_bill&q=${encodeURIComponent(q)}`,
    );
    if (!res.success) return showAlert("paymentAlert", res.message, "error");
    billTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.booking_id}</td><td>${r.guest_name}</td><td>${r.base_amount}</td><td>${r.extras_amount}</td><td>${r.discount_amount}</td><td>${r.total_amount}</td><td>${badge(r.payment_status)}</td><td>${r.payment_status === "pending" ? `<button class="btn btn-success" onclick="preparePayment(${r.id})">Pay</button>` : '<button class="btn btn-light">Receipt</button>'}</td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="8" class="empty">No bill found.</td></tr>';
  } catch (e) {
    showAlert("paymentAlert", "Bill search failed.", "error");
  }
}
function preparePayment(id) {
  billingId.value = id;
  paymentCard.style.display = "block";
}
function hidePaymentCard() {
  paymentCard.style.display = "none";
  paymentForm.reset();
}
async function submitPayment(e) {
  e.preventDefault();
  const data = new FormData(paymentForm);
  data.append("action", "pay_bill");
  try {
    const res = await postForm(PAYMENT_Controler, data);
    showAlert("paymentAlert", res.message, res.success ? "success" : "error");
    if (res.success) {
      hidePaymentCard();
      searchBill();
    }
  } catch (e) {
    showAlert("paymentAlert", "Payment failed.", "error");
  }
}
