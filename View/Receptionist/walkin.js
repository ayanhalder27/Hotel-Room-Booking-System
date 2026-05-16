const WALKIN_Controler = "../../Controler/walkin_Controler.php";
const GUEST_Controler = "../../Controler/guest_register_Controler.php";
async function loadWalkinRoomTypes() {
  try {
    const res = await getJson(`${WALKIN_Controler}?action=room_types`);
    if (roomTypeSelect)
      roomTypeSelect.innerHTML = (res.data || [])
        .map(
          (r) =>
            `<option value="${r.id}">${r.name} - ${r.price_per_night}</option>`,
        )
        .join("");
    loadAvailableWalkinRooms();
  } catch (e) {
    showAlert("walkinAlert", "Room type loading failed.", "error");
  }
}
async function loadAvailableWalkinRooms() {
  if (!roomTypeSelect) return;
  try {
    const res = await getJson(
      `${WALKIN_Controler}?action=available_rooms&room_type_id=${roomTypeSelect.value}`,
    );
    walkinRoomSelect.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<option value="${r.id}">${r.room_number} - Floor ${r.floor}</option>`,
        )
        .join("") || '<option value="">No room available</option>';
  } catch (e) {
    showAlert("walkinAlert", "Available room loading failed.", "error");
  }
}
async function submitWalkinBooking(e) {
  e.preventDefault();
  const data = new FormData(walkinForm);
  data.append("action", "create_walkin");
  try {
    const res = await postForm(WALKIN_Controler, data);
    showAlert("walkinAlert", res.message, res.success ? "success" : "error");
    if (res.success) walkinForm.reset();
  } catch (e) {
    showAlert("walkinAlert", "Walk-in booking failed.", "error");
  }
}
async function submitGuestRegister(e) {
  e.preventDefault();
  const data = new FormData(guestRegisterForm);
  data.append("action", "create_guest");
  try {
    const res = await postForm(GUEST_Controler, data);
    showAlert("guestAlert", res.message, res.success ? "success" : "error");
    if (res.success) {
      guestRegisterForm.reset();
      loadGuests();
    }
  } catch (e) {
    showAlert("guestAlert", "Guest registration failed.", "error");
  }
}
async function loadGuests() {
  if (!document.getElementById("guestTable")) return;
  const q = guestSearch.value || "";
  try {
    const res = await getJson(
      `${GUEST_Controler}?action=list&q=${encodeURIComponent(q)}`,
    );
    guestTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.id}</td><td>${r.name}</td><td>${r.email}</td><td>${r.phone}</td><td>${r.id_number}</td><td>${badge(r.is_active == 1 ? "active" : "inactive")}</td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="6" class="empty">No guest found.</td></tr>';
  } catch (e) {
    showAlert("guestAlert", "Guest loading failed.", "error");
  }
}
document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("walkinForm")) loadWalkinRoomTypes();
  if (document.getElementById("guestTable")) loadGuests();
});
