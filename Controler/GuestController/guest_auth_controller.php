<?php
require_once '_guest_common.php';

wrapController(function () {
    $action = reqv('action', 'register');
    $idCol  = userIdColumn();

    switch ($action) {
        /**
         * Guest Registration
         */
        case 'register':
            requiredFields(['name', 'email', 'password', 'phone', 'nationality', 'id_number']);

            // Validate email format
            if (!filter_var(post('email'), FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Valid email is required.');
            }

            // Check if email already exists
            $exists = (int)db::FetchValue(
                'SELECT COUNT(*) FROM users WHERE email = ?',
                post('email')
            );
            if ($exists > 0) {
                throw new Exception('Email already registered.');
            }

            // Insert new guest
            db::Execute(
                "INSERT INTO users 
                    (name, email, password_hash, phone, nationality, $idCol, role, is_active, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, 'guest', 1, NOW())",
                post('name'),
                post('email'),
                password_hash(post('password'), PASSWORD_DEFAULT),
                post('phone'),
                post('nationality'),
                post('id_number')
            );

            jsonResponse(true, 'Guest registered successfully.');
            break;

        /**
         * Guest Login
         */
        case 'login':
            requiredFields(['email', 'password']);

            $user = db::Fetch(
                "SELECT id, name, email, password_hash, role, is_active 
                 FROM users 
                 WHERE email = ? AND role = 'guest' 
                 LIMIT 1",
                post('email')
            );

            if (!$user || (int)$user['is_active'] !== 1) {
                throw new Exception('Guest account not found or inactive.');
            }

            // Verify password (hashed or plain fallback)
            if (!password_verify(post('password'), $user['password_hash']) 
                && post('password') !== $user['password_hash']) {
                throw new Exception('Invalid password.');
            }

            // Set session
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];

            jsonResponse(true, 'Login successful.', [
                'redirect' => 'dashboard.php'
            ]);
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
