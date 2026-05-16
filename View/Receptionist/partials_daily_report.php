<h2 class="page-title">Daily Operations Report</h2>
<p class="page-subtitle">Arrivals, departures, walk-ins, revenue, occupancy, and service summary.</p>
<div id="reportAlert" class="alert"></div>
<section class="card">
<div class="toolbar"><input class="input" type="date" id="reportDate"><div class="action-row"><button class="btn btn-primary" onclick="loadDailyReport()">Generate</button><button class="btn btn-light" onclick="window.print()">Print Report</button></div></div>
<div class="grid grid-4" id="reportStats">
<div class="card stat-card"><h3>Total Arrivals</h3><div class="num" id="reportArrivals">0</div></div>
<div class="card stat-card"><h3>Total Departures</h3><div class="num" id="reportDepartures">0</div></div>
<div class="card stat-card"><h3>Walk-ins</h3><div class="num" id="reportWalkins">0</div></div>
<div class="card stat-card"><h3>Revenue</h3><div class="num" id="reportRevenue">0</div></div>
</div>
<br>
<div class="table-wrap"><table><thead><tr><th>Metric</th><th>Value</th></tr></thead><tbody id="reportTable"><tr><td colspan="2" class="empty">Generate report.</td></tr></tbody></table></div>
</section>
<script src="report.js"></script>
