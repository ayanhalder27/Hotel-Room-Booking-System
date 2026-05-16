<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    if (request_action() !== 'list') send_json(false, 'Invalid action.');
    $today = date('Y-m-d');
    $q = '%' . clean($_GET['q'] ?? '') . '%';
    $rows = db::FetchAll(
        "SELECT b.id, u.name AS guest_name, rt.name AS room_type, b.checkin_date, b.checkout_date, b.num_guests, b.total_price, b.created_at
         FROM bookings b
         INNER JOIN users u ON u.id=b.guest_id
         INNER JOIN room_types rt ON rt.id=b.room_type_id
         WHERE b.checkin_date=? AND b.status='confirmed'
           AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ? OR u.phone LIKE ?)
         ORDER BY b.created_at ASC",
        $today, $q, $q, $q
    );
    send_json(true, 'Today check-ins loaded.', $rows);
} catch (Exception $e) { send_json(false, $e->getMessage()); }
