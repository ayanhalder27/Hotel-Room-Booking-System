<section 
    data-page-title="Daily Report" 
    data-page-script="report.js"
>
    <h2 class="page-title">Daily Operations Report</h2>
    <p class="page-subtitle">
        Today’s arrivals, departures, walk-ins, revenue, and room counts.
    </p>

    <!-- Alert box -->
    <div id="alertBox" class="alert"></div>

    <!-- Toolbar -->
    <div class="toolbar">
        <button class="btn btn-primary" id="refreshBtn">Refresh</button>
        <button class="btn btn-light" onclick="window.print()">Print</button>
    </div>

    <!-- Report stats grid -->
    <div class="grid grid-4" id="reportStats"></div>
</section>
