<?php
require_once '_rec_common.php';

try {
    $q = post('q');

    $sql = "
        SELECT 
            b.id,
            u.name AS guest_name,
            rt.name AS room_type,
            b.checkin_date,
            b.checkout_date,
            b.num_guests,
            b.total_price
        FROM bookings b
        JOIN users u ON u.id = b.guest_id
        JOIN room_types rt ON rt.id = b.room_type_id
        WHERE b.checkin_date = CURDATE()
          AND b.status = 'confirmed'
    ";

    $params = [];

    if ($q !== '') {
        $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR rt.name LIKE ?)";
        $params = [likeQ($q), likeQ($q), likeQ($q)];
    }

    $sql .= " ORDER BY b.created_at ASC";

    db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
