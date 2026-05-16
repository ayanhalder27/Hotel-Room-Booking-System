const MODIFY_Controler = "../../Controler/booking_modify_Controler.php";
async function searchBookingForModify() {
  const q = modifySearch.value.trim();
  if (!q)
    return showAlert("modifyAlert", "Enter booking ID or guest name.", "error");
  try {
    const res = await getJson(
      `${MODIFY_Controler}?action=search&q=${encodeURIComponent(q)}`,
    );
    if (!res.success) return showAlert("modifyAlert", res.message, "error");
    modifyTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.id}</td><td>${r.guest_name}</td><td>${r.room_type}</td><td>${r.checkin_date}</td><td>${r.checkout_date}</td><td>${r.num_guests}</td><td>${badge(r.status)}</td><td><button class="btn btn-warning" onclick="prepareModify(${r.id}, '${r.checkin_date}', '${r.checkout_date}', ${r.num_guests})">Modify</button></td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="8" class="empty">No booking found.</td></tr>';
  } catch (e) {
    showAlert("modifyAlert", "Booking search failed.", "error");
  }
}
function prepareModify(id, checkin, checkout, guests) {
  modifyBookingId.value = id;
  newCheckinDate.value = checkin;
  newCheckoutDate.value = checkout;
  newNumGuests.value = guests;
  modifyCard.style.display = "block";
}
async function checkModifyAvailability() {
  const data = new FormData(modifyForm);
  data.append("action", "check_availability");
  try {
    const res = await postForm(MODIFY_Controler, data);
    showAlert("modifyAlert", res.message, res.success ? "success" : "error");
  } catch (e) {
    showAlert("modifyAlert", "Availability check failed.", "error");
  }
}
async function submitBookingModify(e) {
  e.preventDefault();
  const data = new FormData(modifyForm);
  data.append("action", "update_booking");
  try {
    const res = await postForm(MODIFY_Controler, data);
    showAlert("modifyAlert", res.message, res.success ? "success" : "error");
    if (res.success) {
      modifyCard.style.display = "none";
      searchBookingForModify();
    }
  } catch (e) {
    showAlert("modifyAlert", "Booking update failed.", "error");
  }
}
