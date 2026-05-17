function resetReview() {
  qs("#reviewForm").reset();
  qs("#reviewId").value = "";
}
async function loadCompletedBookings() {
  const r = await api("review_controller.php", {
    action: "completed_bookings",
  });
  qs("#completedBookingSelect").innerHTML = (r.data || []).length
    ? r.data
        .map(
          (b) =>
            `<option value="${b.id}">#${b.id} - ${esc(b.room_type)} (${esc(b.checkout_date)})</option>`,
        )
        .join("")
    : '<option value="">No completed booking available</option>';
}
async function loadReviews() {
  try {
    const r = await api("review_controller.php", { action: "list" });
    if (!r.success) return showAlert(r.message, false);
    qs("#reviewList").innerHTML = r.data.length
      ? r.data.map(renderReview).join("")
      : '<div class="empty">No reviews yet</div>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
function renderReview(r) {
  const j = esc(JSON.stringify(r));
  return `<div class="review-card"><div class="section-head"><strong>Booking #${r.booking_id} - ${esc(r.room_type)}</strong><span>★ ${esc(r.overall_rating)}/5</span></div><p>${esc(r.review_text)}</p><small>Cleanliness ${esc(r.cleanliness_rating)}/5 | Service ${esc(r.service_rating)}/5</small>${r.admin_reply ? `<div class="notice">Admin reply: ${esc(r.admin_reply)}</div>` : ""}<div class="action-row"><button class="btn btn-light" onclick='editReview(${j})'>Edit</button><button class="btn btn-danger" onclick="deleteReview(${r.id})">Delete</button></div></div>`;
}
function editReview(r) {
  Object.entries(r).forEach(([k, v]) => {
    const el = qs(`[name="${k}"]`);
    if (el) el.value = v;
  });
  qs("#reviewId").value = r.id;
  scrollTo(0, 0);
}
async function deleteReview(id) {
  if (!confirm("Delete this review?")) return;
  const r = await api("review_controller.php", { action: "delete", id });
  showAlert(r.message, r.success);
  if (r.success) loadReviews();
}
qs("#reviewForm")?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const d = Object.fromEntries(new FormData(e.target));
  d.action = d.id ? "update" : "create";
  try {
    const r = await api("review_controller.php", d);
    showAlert(r.message, r.success);
    if (r.success) {
      resetReview();
      loadReviews();
    }
  } catch (err) {
    showAlert(err.message, false);
  }
});
qs("#resetBtn")?.addEventListener("click", resetReview);
qs("#refreshBtn")?.addEventListener("click", loadReviews);
loadCompletedBookings();
loadReviews();
