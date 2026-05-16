const CHECKIN_Controler = "../../Controler/checkin_Controler.php";
async function searchCheckinBooking() {
  const q = checkinSearch.value.trim();
  if (!q)
    return showAlert(
      "checkinAlert",
      "Enter booking ID or guest name.",
      "error",
    );
  try {
    const res = await getJson(
      `${CHECKIN_Controler}?action=search&q=${encodeURIComponent(q)}`,
    );
    if (!res.success) return showAlert("checkinAlert", res.message, "error");
    checkinBookingTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.id}</td><td>${r.guest_name}</td><td>${r.id_number}</td><td>${r.room_type}</td><td>${r.checkin_date} to ${r.checkout_date}</td><td>${badge(r.status)}</td><td><button class="btn btn-success" onclick="prepareCheckin(${r.id}, ${r.room_type_id})">Assign Room</button></td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="7" class="empty">No confirmed booking found.</td></tr>';
  } catch (e) {
    showAlert("checkinAlert", "Search failed.", "error");
  }
}
async function prepareCheckin(bookingIdValue, roomTypeId) {
  bookingId.value = bookingIdValue;
  assignRoomCard.style.display = "block";
  const res = await getJson(
    `${CHECKIN_Controler}?action=available_rooms&room_type_id=${roomTypeId}`,
  );
  availableRoomSelect.innerHTML = (res.data || [])
    .map(
      (r) =>
        `<option value="${r.id}">${r.room_number} - Floor ${r.floor}</option>`,
    )
    .join("");
}
async function submitCheckin(e) {
  e.preventDefault();
  const data = new FormData(checkinForm);
  data.append("action", "checkin");
  try {
    const res = await postForm(CHECKIN_Controler, data);
    showAlert("checkinAlert", res.message, res.success ? "success" : "error");
    if (res.success) {
      resetCheckinForm();
      searchCheckinBooking();
    }
  } catch (e) {
    showAlert("checkinAlert", "Check-in failed.", "error");
  }
}
function resetCheckinForm() {
  checkinForm.reset();
  assignRoomCard.style.display = "none";
}
document.addEventListener("DOMContentLoaded", () => {
  const p = new URLSearchParams(location.search);
  if (p.get("booking_id")) {
    checkinSearch.value = p.get("booking_id");
    searchCheckinBooking();
  }
});
