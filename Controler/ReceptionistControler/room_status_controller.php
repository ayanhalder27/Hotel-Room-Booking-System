<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    $action = request_action();

    if ($action === 'room_types') {
        send_json(true, 'Room types loaded.', db::FetchAll("SELECT id, name FROM room_types ORDER BY name"));
    }

    if ($action === 'list') {
        $q = '%' . clean($_GET['q'] ?? '') . '%';
        $status = clean($_GET['status'] ?? '');
        $roomTypeId = (int)($_GET['room_type_id'] ?? 0);
        $allowed = ['available','occupied','dirty','maintenance','blocked'];
        $sql = "SELECT r.id, r.room_number, rt.name AS room_type, r.floor, r.status, r.notes
                FROM rooms r INNER JOIN room_types rt ON rt.id=r.room_type_id
                WHERE (r.room_number LIKE ? OR rt.name LIKE ? OR CAST(r.floor AS CHAR) LIKE ? OR r.notes LIKE ?)";
        $params = [$q,$q,$q,$q];
        if ($status !== '' && in_array($status, $allowed, true)) { $sql .= " AND r.status=?"; $params[] = $status; }
        if ($roomTypeId > 0) { $sql .= " AND r.room_type_id=?"; $params[] = $roomTypeId; }
        $sql .= " ORDER BY r.floor ASC, r.room_number ASC";
        $rows = db::FetchAll($sql, $params);
        send_json(true, 'Room status loaded.', $rows);
    }

    send_json(false, 'Invalid action.');
} catch (Exception $e) { send_json(false, $e->getMessage()); }
