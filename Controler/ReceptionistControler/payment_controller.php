<?php
require_once __DIR__ . '/_rec_common.php';

try {
    $action = rec_Controler_action();

    if ($action === 'search_bill') {
        $q = rec_input('q');
        rec_required($q, 'Search text');
        $rows = db::FetchAll("SELECT bl.id, bl.booking_id, u.name AS guest_name, bl.guest_id, bl.base_amount, bl.extras_amount, bl.discount_amount, bl.total_amount, bl.payment_status, bl.payment_method, bl.receipt_path,
                   COALESCE(lb.current_balance,0) AS loyalty_balance
            FROM billing bl
            JOIN bookings b ON b.id=bl.booking_id
            JOIN users u ON u.id=bl.guest_id
            LEFT JOIN loyalty_balances lb ON lb.guest_id=bl.guest_id
            WHERE CAST(bl.booking_id AS CHAR) LIKE ? OR u.name LIKE ? OR u.phone LIKE ? OR u.national_id LIKE ?
            ORDER BY bl.id DESC", rec_like($q), rec_like($q), rec_like($q), rec_like($q));
        rec_json(true, 'Bills loaded.', $rows);
    }

    if ($action === 'pay_bill') {
        $billingId = rec_int(rec_input('billing_id'), 'Billing ID');
        $paymentMethod = rec_payment_method(rec_input('payment_method', 'cash'));
        $pointsUsed = max(0, (int)rec_input('points_used', 0));

        $bill = db::Fetch("SELECT bl.*, COALESCE(lb.current_balance,0) AS loyalty_balance FROM billing bl LEFT JOIN loyalty_balances lb ON lb.guest_id=bl.guest_id WHERE bl.id=?", $billingId);
        if (!$bill) throw new Exception('Bill not found.');
        if ($bill['payment_status'] === 'paid') throw new Exception('This bill is already paid.');
        if ($pointsUsed > (int)$bill['loyalty_balance']) throw new Exception('Not enough loyalty points.');

        $maxAllowed = (float)$bill['base_amount'] + (float)$bill['extras_amount'];
        if ($pointsUsed > $maxAllowed) throw new Exception('Points cannot be greater than payable amount.');
        $discount = (float)$bill['discount_amount'] + $pointsUsed;
        $receiptPath = 'receipts/booking_' . $bill['booking_id'] . '_' . date('YmdHis') . '.html';

        db::BeginTransaction();
        try {
            db::Execute("UPDATE billing SET discount_amount=?, payment_method=?, payment_status='paid', paid_at=NOW(), receipt_path=? WHERE id=?", $discount, $paymentMethod, $receiptPath, $billingId);
            if ($pointsUsed > 0) {
                db::Execute("INSERT INTO loyalty_points (guest_id, booking_id, points_earned, points_used) VALUES (?, ?, 0, ?) ON DUPLICATE KEY UPDATE points_used = points_used + VALUES(points_used)", (int)$bill['guest_id'], (int)$bill['booking_id'], $pointsUsed);
            }
            db::Commit();
        } catch (Exception $e) {
            db::Rollback();
            throw $e;
        }
        rec_json(true, 'Payment completed and receipt generated.', ['receipt_path' => $receiptPath]);
    }

    rec_json(false, 'Invalid payment action.', [], 400);
} catch (Exception $e) {
    rec_json(false, $e->getMessage(), [], 500);
}
?>
