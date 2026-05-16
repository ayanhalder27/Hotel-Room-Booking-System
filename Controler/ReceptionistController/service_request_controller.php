<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'list');

    // List service requests
    if ($action === 'list') {
        $q      = post('q');
        $status = post('status');

        $sql = "
            SELECT 
                sr.id,
                u.name AS guest_name,
                r.room_number,
                sr.service_type,
                sr.description,
                sr.status
            FROM service_requests sr
            JOIN users u ON u.id = sr.guest_id
            LEFT JOIN rooms r ON r.id = sr.room_id
            WHERE 1=1
        ";
        $params = [];

        if ($status !== '') {
            $sql .= " AND sr.status = ?";
            $params[] = $status;
        }

        if ($q !== '') {
            $sql .= " AND (u.name LIKE ? OR r.room_number LIKE ? OR sr.service_type LIKE ?)";
            $params[] = likeQ($q);
            $params[] = likeQ($q);
            $params[] = likeQ($q);
        }

        $sql .= " ORDER BY FIELD(sr.status,'pending','in_progress','completed'), sr.requested_at DESC";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Update service request status
    if ($action === 'update_status') {
        requiredFields(['id', 'status']);

        $status = post('status');
        $validStatuses = ['pending','in_progress','completed'];

        if (!in_array($status, $validStatuses)) {
            db::JsonResponse(false, 'Invalid status.');
        }

        db::Execute(
            "UPDATE service_requests 
             SET status=?, completed_at=IF(?='completed', NOW(), NULL) 
             WHERE id=?",
            $status,
            $status,
            (int) post('id')
        );

        db::JsonResponse(true, 'Service request updated.');
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
