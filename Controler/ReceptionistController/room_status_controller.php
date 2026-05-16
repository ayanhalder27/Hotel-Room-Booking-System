<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'list');

    // List rooms
    if ($action === 'list') {
        $q      = post('q');
        $status = post('status');

        $sql = "
            SELECT 
                r.id,
                r.room_number,
                r.floor,
                r.status,
                r.notes,
                rt.name AS room_type
            FROM rooms r
            JOIN room_types rt ON rt.id = r.room_type_id
            WHERE 1=1
        ";
        $params = [];

        if ($status !== '') {
            $sql .= " AND r.status = ?";
            $params[] = $status;
        }

        if ($q !== '') {
            $sql .= " AND r.room_number LIKE ?";
            $params[] = likeQ($q);
        }

        $sql .= " ORDER BY r.floor, r.room_number";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Update room status
    if ($action === 'update_status') {
        requiredFields(['id', 'status']);

        $status = post('status');
        $validStatuses = ['available','occupied','dirty','maintenance','blocked'];

        if (!in_array($status, $validStatuses)) {
            db::JsonResponse(false, 'Invalid room status.');
        }

        db::Execute(
            "UPDATE rooms SET status=? WHERE id=?",
            $status,
            (int) post('id')
        );

        db::JsonResponse(true, 'Room status updated.');
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
