<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'list');

    switch ($action) {
        /**
         * List billing history for the current guest.
         */
        case 'list':
            $search = post('q');
            $sql = "
                SELECT 
                    bill.*,
                    b.id AS booking_no,
                    b.checkin_date,
                    b.checkout_date,
                    b.status AS booking_status,
                    rt.name AS room_type
                FROM billing bill
                JOIN bookings b ON b.id = bill.booking_id
                JOIN room_types rt ON rt.id = b.room_type_id
                WHERE b.guest_id = ?
            ";
            $params = [$guestId];

            if ($search !== '') {
                $sql .= " 
                    AND (
                        CAST(b.id AS CHAR) LIKE ? 
                        OR rt.name LIKE ? 
                        OR bill.payment_status LIKE ?
                    )
                ";
                $params[] = likeQ($search);
                $params[] = likeQ($search);
                $params[] = likeQ($search);
            }

            $sql .= " ORDER BY bill.id DESC";

            $rows = db::FetchAll($sql, ...$params);
            jsonResponse(true, 'Billing history loaded.', $rows);
            break;

        /**
         * Load a specific receipt by billing ID.
         */
        case 'receipt':
            requiredFields(['billing_id']);

            $billingId = (int)post('billing_id');
            $bill = db::Fetch(
                "
                SELECT 
                    bill.*,
                    b.checkin_date,
                    b.checkout_date,
                    rt.name AS room_type,
                    u.name AS guest_name,
                    u.email
                FROM billing bill
                JOIN bookings b ON b.id = bill.booking_id
                JOIN room_types rt ON rt.id = b.room_type_id
                JOIN users u ON u.id = b.guest_id
                WHERE bill.id = ? AND b.guest_id = ?
                ",
                $billingId,
                $guestId
            );

            if (!$bill) {
                throw new Exception('Receipt not found.');
            }

            jsonResponse(true, 'Receipt loaded.', $bill);
            break;

        /**
         * Default case for invalid actions.
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
