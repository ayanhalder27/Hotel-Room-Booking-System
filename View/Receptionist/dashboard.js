const DASHBOARD_Controler =
  "../../Controler/receptionist_dashboard_Controler.php";
const TODAY_CHECKINS_Controler = "../../Controler/today_checkins_Controler.php";

async function loadDashboard() {
  try {
    const res = await getJson(`${DASHBOARD_Controler}?action=summary`);
    if (!res.success) return showAlert("dashboardAlert", res.message, "error");
    const d = res.data;
    expectedCheckins.textContent = d.expected_checkins ?? 0;
    expectedCheckouts.textContent = d.expected_checkouts ?? 0;
    checkedInGuests.textContent = d.checked_in_guests ?? 0;
    availableRooms.textContent = d.available_rooms ?? 0;
    occupiedRooms.textContent = d.occupied_rooms ?? 0;
    dirtyRooms.textContent = d.dirty_rooms ?? 0;
    pendingRequests.textContent = d.pending_requests ?? 0;
    todayRevenue.textContent = d.today_revenue ?? 0;
    availableByTypeTable.innerHTML =
      (d.available_by_type || [])
        .map((r) => `<tr><td>${r.name}</td><td>${r.total}</td></tr>`)
        .join("") ||
      '<tr><td colspan="2" class="empty">No data found.</td></tr>';
  } catch (e) {
    showAlert("dashboardAlert", "Dashboard loading failed.", "error");
  }
}

async function loadTodayCheckins() {
  const q = document.getElementById("todayCheckinSearch")?.value || "";
  try {
    const res = await getJson(
      `${TODAY_CHECKINS_Controler}?action=list&q=${encodeURIComponent(q)}`,
    );
    if (!res.success)
      return showAlert("checkinListAlert", res.message, "error");
    todayCheckinsTable.innerHTML =
      (res.data || [])
        .map(
          (r) =>
            `<tr><td>${r.id}</td><td>${r.guest_name}</td><td>${r.room_type}</td><td>${r.checkin_date}</td><td>${r.checkout_date}</td><td>${r.num_guests}</td><td>${r.total_price}</td><td><a class="btn btn-success" href="checkin.php?booking_id=${r.id}">Check In</a></td></tr>`,
        )
        .join("") ||
      '<tr><td colspan="8" class="empty">No check-ins found.</td></tr>';
  } catch (e) {
    showAlert("checkinListAlert", "Check-in list loading failed.", "error");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("dashboardStats")) loadDashboard();
  if (document.getElementById("todayCheckinsTable")) loadTodayCheckins();
});
