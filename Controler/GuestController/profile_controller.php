<?php
require_once '_guest_common.php';

wrapController(function () {
    $guestId = currentGuestId();
    $action  = reqv('action', 'get');
    $idCol   = userIdColumn();

    switch ($action) {
        /**
         * Get Guest Profile
         */
        case 'get':
            $user = db::Fetch(
                "SELECT 
                    id,
                    name,
                    email,
                    phone,
                    nationality,
                    $idCol AS id_number,
                    profile_pic,
                    is_active,
                    created_at
                 FROM users 
                 WHERE id = ? AND role = 'guest'",
                $guestId
            );

            if (!$user) {
                throw new Exception('Profile not found.');
            }

            $user['loyalty_balance'] = (int)db::FetchValue(
                "SELECT COALESCE(balance,0) 
                 FROM loyalty_points 
                 WHERE guest_id = ? 
                 ORDER BY id DESC 
                 LIMIT 1",
                $guestId
            );

            jsonResponse(true, 'Profile loaded.', $user);
            break;

        /**
         * Update Guest Profile
         */
        case 'update':
            requiredFields(['name','phone','nationality','id_number']);

            db::Execute(
                "UPDATE users 
                 SET name = ?, phone = ?, nationality = ?, $idCol = ? 
                 WHERE id = ? AND role = 'guest'",
                post('name'),
                post('phone'),
                post('nationality'),
                post('id_number'),
                $guestId
            );

            $_SESSION['name'] = post('name');
            jsonResponse(true, 'Profile updated successfully.');
            break;

        /**
         * Change Password
         */
        case 'change_password':
            requiredFields(['current_password','new_password']);

            $user = db::Fetch(
                "SELECT password_hash 
                 FROM users 
                 WHERE id = ? AND role = 'guest'",
                $guestId
            );

            if (!$user) {
                throw new Exception('User not found.');
            }

            if (!password_verify(post('current_password'), $user['password_hash']) 
                && post('current_password') !== $user['password_hash']) {
                throw new Exception('Current password is incorrect.');
            }

            if (strlen(post('new_password')) < 6) {
                throw new Exception('New password must be at least 6 characters.');
            }

            db::Execute(
                "UPDATE users 
                 SET password_hash = ? 
                 WHERE id = ?",
                password_hash(post('new_password'), PASSWORD_DEFAULT),
                $guestId
            );

            jsonResponse(true, 'Password changed successfully.');
            break;

        /**
         * Upload Profile Picture
         */
        case 'upload_profile_pic':
            if (!isset($_FILES['profile_pic']) || $_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
                throw new Exception('Profile picture is required.');
            }

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            $mime = mime_content_type($_FILES['profile_pic']['tmp_name']);
            if (!isset($allowed[$mime])) {
                throw new Exception('Only JPG, PNG, or WEBP images are allowed.');
            }

            $dir = __DIR__ . '/../../Resources/uploads/guest_profiles';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $filename = 'guest_' . $guestId . '_' . time() . '.' . $allowed[$mime];
            $filepath = $dir . '/' . $filename;

            if (!move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filepath)) {
                throw new Exception('Failed to upload profile picture.');
            }

            $relativePath = 'Resources/uploads/guest_profiles/' . $filename;

            db::Execute(
                "UPDATE users 
                 SET profile_pic = ? 
                 WHERE id = ?",
                $relativePath,
                $guestId
            );

            jsonResponse(true, 'Profile picture uploaded.', [
                'profile_pic' => $relativePath
            ]);
            break;

        /**
         * Default case
         */
        default:
            jsonResponse(false, 'Invalid action.');
    }
});
