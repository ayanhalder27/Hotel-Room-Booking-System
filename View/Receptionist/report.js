// Load daily report data
async function loadReport() {
  try {
    const response = await api("report_controller.php", { action: "daily" });

    if (!response.success) {
      return showAlert(response.message, false);
    }

    const data = response.data;

    // Define report rows
    const rows = [
      ["Arrivals", data.arrivals],
      ["Departures", data.departures],
      ["Walk-ins", data.walkins],
      ["Revenue", money(data.revenue)],
      ["Occupied Rooms", data.occupied],
      ["Available Rooms", data.available],
      ["Dirty Rooms", data.dirty],
      ["Pending Requests", data.pending_requests],
    ];

    // Render stats
    qs("#reportStats").innerHTML = rows.map(renderStatCard).join("");
  } catch (error) {
    showAlert(error.message, false);
  }
}

// Render a single stat card
function renderStatCard([title, value]) {
  return `
        <div class="card stat-card">
            <h3>${title}</h3>
            <div class="num">${value}</div>
        </div>
    `;
}

// Event listeners
qs("#refreshBtn")?.addEventListener("click", loadReport);

// Initial load
loadReport();
