async function loadRoomDetails() {
  const id = qs("#roomTypeId")?.value;
  if (!id) {
    qs("#roomDetailsBox").innerHTML =
      '<div class="card empty">No room type selected.</div>';
    return;
  }
  try {
    const r = await api("room_details_controller.php", {
      action: "details",
      room_type_id: id,
    });
    if (!r.success) return showAlert(r.message, false);
    const x = r.data;
    qs("#roomDetailsBox").innerHTML =
      `<div class="room-detail-hero"><div><span class="eyebrow">Room Type</span><h2>${esc(x.name)}</h2><p>${esc(x.description || "")}</p><div class="chip-row"><span class="chip">Capacity: ${esc(x.max_capacity || x.capacity || "")}</span><span class="chip">Price: ${money(x.price_per_night)} / night</span><span class="chip">Available rooms: ${esc(x.available_rooms || 0)}</span></div><div class="rating-box">Average Overall: ${esc(x.avg_overall || "N/A")} | Cleanliness: ${esc(x.avg_cleanliness || "N/A")} | Service: ${esc(x.avg_service || "N/A")}</div><a class="btn btn-gradient" href="room_search.php">Search Dates</a></div></div>`;
  } catch (e) {
    showAlert(e.message, false);
  }
}
loadRoomDetails();
