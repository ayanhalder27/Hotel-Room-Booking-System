<div class="container-fluid p-0">
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 bg-white d-flex align-items-center justify-content-between flex-row">
                <div>
                    <span class="text-muted text-xs text-uppercase tracking-wider d-block mb-1">Settled Capital Outflow</span>
                    <h3 class="m-0 text-navy fw-bold font-monospace">$2,410.50</h3>
                </div>
                <div class="p-3 bg-navy-subtle text-navy rounded-circle fs-4" style="width:55px; height:55px; display:flex; align-items:center; justify-content:center;"><i class="fa-solid fa-file-invoice"></i></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 bg-white d-flex align-items-center justify-content-between flex-row">
                <div>
                    <span class="text-muted text-xs text-uppercase tracking-wider d-block mb-1">Outstanding Pending Folio Invoices</span>
                    <h3 class="m-0 text-gold fw-bold font-monospace">$775.50</h3>
                </div>
                <div class="p-3 bg-gold-subtle text-gold rounded-circle fs-4" style="width:55px; height:55px; display:flex; align-items:center; justify-content:center;"><i class="fa-solid fa-clock-rotate-left"></i></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-0 rounded-4 overflow-hidden bg-white">
        <div class="p-4 border-bottom">
            <h5 class="m-0 text-navy fw-bold">Official Corporate Invoices Ledger Archive</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-sm">
                <thead class="table-light text-muted text-uppercase text-xs tracking-wider">
                    <tr>
                        <th class="ps-4">Statement Invoice Token</th>
                        <th>Linked Booking Reference</th>
                        <th>Payment System Method</th>
                        <th>Settlement Timestamp</th>
                        <th>Gross Value Amount</th>
                        <th>Status Flag</th>
                        <th class="pe-4 text-end">Document Exports</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 font-monospace fw-bold text-navy">#INV-990142</td>
                        <td class="font-monospace">#GH-90812</td>
                        <td><i class="fa-brands fa-cc-visa text-primary me-1 fs-5"></i> Visa ending 4211</td>
                        <td class="font-monospace">Jan 15, 2026, 11:04 AM</td>
                        <td class="font-monospace fw-bold text-navy">$540.00</td>
                        <td><span class="badge bg-success-subtle text-success px-2.5 py-1 text-xxs font-monospace rounded-pill">PAID SETTLED</span></td>
                        <td class="pe-4 text-end"><button class="btn btn-light btn-xs border text-navy" onclick="window.print()"><i class="fa-solid fa-download me-1"></i> Receipt File</button></td>
                    </tr>
                    <tr>
                        <td class="ps-4 font-monospace fw-bold text-navy">#INV-884011</td>
                        <td class="font-monospace">#GH-2026-88412</td>
                        <td><span class="text-muted italic text-xs">On-File Deferred Authorization</span></td>
                        <td><span class="text-muted font-monospace">-</span></td>
                        <td class="font-monospace fw-bold text-navy">$775.50</td>
                        <td><span class="badge bg-warning-subtle text-warning px-2.5 py-1 text-xxs font-monospace rounded-pill">PENDING ARREST</span></td>
                        <td class="pe-4 text-end"><button class="btn btn-light btn-xs border text-muted disabled"><i class="fa-solid fa-lock me-1"></i> Locked Ledger</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>