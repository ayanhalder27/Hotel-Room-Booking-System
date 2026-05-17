function initDates() {
  const t = new Date().toISOString().slice(0, 10),
    tm = new Date();
  tm.setDate(tm.getDate() + 1);
  if (qs('[name="checkin_date"]') && !qs('[name="checkin_date"]').value)
    qs('[name="checkin_date"]').value = t;
  if (qs('[name="checkout_date"]') && !qs('[name="checkout_date"]').value)
    qs('[name="checkout_date"]').value = tm.toISOString().slice(0, 10);
}
async function searchRooms(e) {
  if (e) e.preventDefault();
  const form = qs("#roomSearchForm"),
    data = Object.fromEntries(new FormData(form));
  data.action = "search";
  try {
    qs("#roomResults").innerHTML =
      '<div class="empty-card">Searching rooms...</div>';
    const r = await api("room_search_controller.php", data);
    if (!r.success) {
      qs("#roomResults").innerHTML = '<div class="empty-card">No result</div>';
      return showAlert(r.message, false);
    }
    qs("#roomResults").innerHTML = r.data.length
      ? r.data.map((room) => renderRoomCard(room, data)).join("")
      : '<div class="empty-card">No available room types found for selected dates.</div>';
  } catch (e) {
    showAlert(e.message, false);
  }
}
function renderRoomCard(room, s) {
  const am = room.amenities_text || room.amenities || "WiFi, AC, TV";
  return `<article class="room-card"><div class="room-image"><span>${esc(room.name)}</span></div><div class="room-body"><div class="room-title-row"><h3>${esc(room.name)}</h3><strong>${money(room.price_per_night)} / night</strong></div><p>${esc(room.description || "Comfortable hotel room with modern facilities.")}</p><div class="chip-row"><span class="chip">Capacity: ${esc(room.max_capacity || room.capacity || "")}</span><span class="chip">Available: ${esc(room.available_rooms)}</span><span class="chip">${esc(am)}</span></div>${room.seasonal_notice ? `<div class="notice">${esc(room.seasonal_notice)}</div>` : ""}<div class="action-row"><a class="btn btn-light" href="room_details.php?room_type_id=${room.id}">View Details</a><a class="btn btn-gradient" href="book_room.php?room_type_id=${room.id}&checkin_date=${s.checkin_date}&checkout_date=${s.checkout_date}&num_guests=${s.num_guests}">Book Now</a></div></div></article>`;
}
qs("#roomSearchForm")?.addEventListener("submit", searchRooms);
initDates();
