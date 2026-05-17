<?php
require_once '_rec_common.php';

try {
    $action = post('action', 'list');

    // List guests
    if ($action === 'list') {
        $q = post('q');
        $sql = "
            SELECT 
                id,
                name,
                email,
                username,
                phone,
                nationality,
                national_id,
                is_active
            FROM users
            WHERE role = 'guest'
        ";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR national_id LIKE ?)";
            $params = [likeQ($q), likeQ($q), likeQ($q), likeQ($q)];
        }

        $sql .= " ORDER BY created_at DESC LIMIT 100";

        db::JsonResponse(true, 'Loaded', db::FetchAll($sql, $params));
    }

    // Create guest
    if ($action === 'create') {
        requiredFields(['name','email','username','phone','nationality','national_id']);

        $defaultPass = password_hash('guest123', PASSWORD_DEFAULT);

        db::Execute(
            "INSERT INTO users(name,email,username,password_hash,phone,nationality,national_id,role,is_active) 
             VALUES(?,?,?,?,?,?,?,'guest',1)",
            post('name'),
            post('email'),
            post('username'),
            $defaultPass,
            post('phone'),
            post('nationality'),
            post('national_id')
        );

        db::JsonResponse(true, 'Guest registered successfully. Default password: guest123');
    }

    // Update guest
    if ($action === 'update') {
        requiredFields(['id','name','email','username','phone','nationality','national_id']);

        db::Execute(
            "UPDATE users 
             SET name=?, email=?, username=?, phone=?, nationality=?, national_id=? 
             WHERE id=? AND role='guest'",
            post('name'),
            post('email'),
            post('username'),
            post('phone'),
            post('nationality'),
            post('national_id'),
            (int) post('id')
        );

        db::JsonResponse(true, 'Guest updated successfully.');
    }

    // Deactivate guest
    if ($action === 'deactivate') {
        requiredFields(['id']);

        db::Execute(
            "UPDATE users SET is_active=0 WHERE id=? AND role='guest'",
            (int) post('id')
        );

        db::JsonResponse(true, 'Guest deactivated.');
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    db::JsonResponse(false, $e->getMessage());
}
