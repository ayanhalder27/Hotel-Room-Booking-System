<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    $action = request_action();

    if ($action === 'list') {
        $q = '%' . clean($_GET['q'] ?? '') . '%';
        $rows = db::FetchAll(
            "SELECT id, name, email, phone, nationality, national_id AS id_number, is_active, created_at
             FROM users
             WHERE role='guest' AND (name LIKE ? OR email LIKE ? OR phone LIKE ? OR national_id LIKE ?)
             ORDER BY created_at DESC LIMIT 100",
            $q, $q, $q, $q
        );
        send_json(true, 'Guests loaded.', $rows);
    }

    if ($action === 'create_guest') {
        require_fields([
            'name'=>'Name', 'email'=>'Email', 'phone'=>'Phone', 'nationality'=>'Nationality', 'id_number'=>'National ID', 'password'=>'Password'
        ]);
        $name = clean($_POST['name']);
        $email = strtolower(clean($_POST['email']));
        $phone = clean($_POST['phone']);
        $nationality = clean($_POST['nationality']);
        $nationalId = clean($_POST['id_number']);
        $password = (string)$_POST['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) send_json(false, 'Invalid email address.');
        if (strlen($password) < 6) send_json(false, 'Password must be at least 6 characters.');
        if (db::FetchValue("SELECT id FROM users WHERE email=? OR phone=? OR national_id=?", $email, $phone, $nationalId)) {
            send_json(false, 'Guest already exists with same email, phone, or national ID.');
        }
        $usernameBase = preg_replace('/[^a-z0-9]/i', '', strtolower(explode('@', $email)[0]));
        $username = $usernameBase ?: 'guest';
        $i = 1;
        while (db::FetchValue("SELECT id FROM users WHERE username=?", $username)) {
            $username = $usernameBase . $i;
            $i++;
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        db::Execute(
            "INSERT INTO users(name,email,username,password_hash,phone,nationality,national_id,role,is_active)
             VALUES(?,?,?,?,?,?,?,'guest',1)",
            $name, $email, $username, $hash, $phone, $nationality, $nationalId
        );
        send_json(true, 'Guest registered successfully.', ['guest_id' => db::InsertId(), 'username' => $username]);
    }

    send_json(false, 'Invalid action.');
} catch (Exception $e) { send_json(false, $e->getMessage()); }
