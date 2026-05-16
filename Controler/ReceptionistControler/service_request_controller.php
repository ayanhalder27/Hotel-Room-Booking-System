<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    $action = request_action();

    if ($action === 'list') {
        $q = '%' . clean($_GET['q'] ?? '') . '%';
        $status = clean($_GET['status'] ?? '');
        $allowed = ['pending','in_progress','completed'];
        $sql = "SELECT sr.id, u.name AS guest_name, r.room_number, sr.service_type, sr.description, sr.status, sr.requested_at, sr.completed_at
                FROM service_requests sr
                INNER JOIN users u ON u.id=sr.guest_id
                LEFT JOIN rooms r ON r.id=sr.room_id
                LEFT JOIN bookings b ON b.id=sr.booking_id
                WHERE (u.name LIKE ? OR r.room_number LIKE ? OR sr.service_type LIKE ? OR sr.description LIKE ?)";
        $params = [$q,$q,$q,$q];
        if ($status !== '' && in_array($status, $allowed, true)) {
            $sql .= " AND sr.status=?";
            $params[] = $status;
        }
        $sql .= " ORDER BY FIELD(sr.status,'pending','in_progress','completed'), sr.requested_at DESC";
        $rows = db::FetchAll($sql, $params);
        send_json(true, 'Service requests loaded.', $rows);
    }

    if ($action === 'update_status') {
        require_fields(['id'=>'Service request ID', 'status'=>'Status']);
        $id = (int)$_POST['id'];
        $status = clean($_POST['status']);
        if (!in_array($status, ['pending','in_progress','completed'], true)) send_json(false, 'Invalid status.');
        $request = db::Fetch("SELECT id FROM service_requests WHERE id=?", $id);
        if (!$request) send_json(false, 'Service request not found.');
        $completedAt = $status === 'completed' ? date('Y-m-d H:i:s') : null;
        db::Execute("UPDATE service_requests SET status=?, completed_at=? WHERE id=?", $status, $completedAt, $id);
        send_json(true, 'Service request updated successfully.');
    }

    send_json(false, 'Invalid action.');
} catch (Exception $e) { send_json(false, $e->getMessage()); }
