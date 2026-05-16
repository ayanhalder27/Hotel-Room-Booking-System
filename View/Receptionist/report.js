const REPORT_Controler = "../../Controler/report_Controler.php";
async function loadDailyReport() {
  const date = reportDate.value || new Date().toISOString().slice(0, 10);
  reportDate.value = date;
  try {
    const res = await getJson(
      `${REPORT_Controler}?action=daily_report&date=${encodeURIComponent(date)}`,
    );
    if (!res.success) return showAlert("reportAlert", res.message, "error");
    const d = res.data;
    reportArrivals.textContent = d.arrivals ?? 0;
    reportDepartures.textContent = d.departures ?? 0;
    reportWalkins.textContent = d.walkins ?? 0;
    reportRevenue.textContent = d.revenue ?? 0;
    reportTable.innerHTML = Object.entries(d)
      .map(
        ([k, v]) => `<tr><td>${k.replaceAll("_", " ")}</td><td>${v}</td></tr>`,
      )
      .join("");
  } catch (e) {
    showAlert("reportAlert", "Report generation failed.", "error");
  }
}
document.addEventListener("DOMContentLoaded", loadDailyReport);
