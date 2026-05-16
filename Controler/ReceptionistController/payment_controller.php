<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'list');

    // List bills
    if ($action === 'list') {
        $q = post('q');
        $sql = "
            SELECT 
                bl.id,
                bl.booking_id,
                u.name AS guest_name,
                bl.guest_id,
                bl.base_amount,
                bl.extras_amount,
                bl.discount_amount,
                bl.total_amount,
                bl.payment_status
            FROM billing bl
            JOIN users u ON u.id = bl.guest_id
            LEFT JOIN bookings b ON b.id = bl.booking_id
            LEFT JOIN rooms r ON r.id = b.room_id
            WHERE 1=1
        ";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (CAST(bl.booking_id AS CHAR) LIKE ? OR u.name LIKE ? OR r.room_number LIKE ?)";
            $params = [likeQ($q), likeQ($q), likeQ($q)];
        }

        $sql .= " ORDER BY bl.payment_status ASC, bl.id DESC LIMIT 100";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Process payment
    if ($action === 'pay') {
        requiredFields(['billing_id', 'payment_method']);

        $id     = (int) post('billing_id');
        $points = max(0, (int) post('points_used', 0));
        $method = post('payment_method');

        db::BeginTransaction();

        $bill = db::Fetch("SELECT * FROM billing WHERE id=? FOR UPDATE", $id);
        if (!$bill) {
            throw new Exception('Bill not found.');
        }
        if ($bill['payment_status'] === 'paid') {
            throw new Exception('Bill already paid.');
        }

        // Handle loyalty points
        if ($points > 0) {
            $balance = (int) db::FetchValue(
                "SELECT COALESCE(current_balance,0) 
                 FROM loyalty_balances 
                 WHERE guest_id=?",
                (int) $bill['guest_id']
            );

            if ($points > $balance) {
                throw new Exception('Guest does not have enough loyalty points.');
            }

            db::Execute(
                "UPDATE billing SET discount_amount = discount_amount + ? WHERE id=?",
                $points,
                $id
            );

            db::Execute(
                "INSERT INTO loyalty_points(guest_id, booking_id, points_earned, points_used) 
                 VALUES(?,?,0,?) 
                 ON DUPLICATE KEY UPDATE points_used = points_used + VALUES(points_used)",
                (int) $bill['guest_id'],
                (int) $bill['booking_id'],
                $points
            );
        }

        // Generate receipt filename
        $receipt = 'receipt_' . $bill['booking_id'] . '_' . time() . '.html';

        // Update billing record
        db::Execute(
            "UPDATE billing 
             SET payment_method=?, payment_status='paid', paid_at=NOW(), receipt_path=? 
             WHERE id=?",
            $method,
            $receipt,
            $id
        );

        db::Commit();
        db::JsonResponse(true, 'Payment completed. Receipt generated: ' . $receipt);
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    try {
        db::Rollback();
    } catch (Exception $x) {
        // ignore rollback errors
    }
    db::JsonResponse(false, $e->getMessage());
}
