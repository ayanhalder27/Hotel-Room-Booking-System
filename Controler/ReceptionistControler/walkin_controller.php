<?php
require_once __DIR__ . '/_receptionist_Controler_helper.php';
require_receptionist();

try {
    $action = request_action();

    if ($action === 'room_types') {
        $rows = db::FetchAll("SELECT id, name, price_per_night, max_capacity FROM room_types ORDER BY name");
        send_json(true, 'Room types loaded.', $rows);
    }

    if ($action === 'available_rooms') {
        $roomTypeId = (int)($_GET['room_type_id'] ?? 0);
        if ($roomTypeId <= 0) send_json(false, 'Room type is required.');
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $rows = available_rooms_for_dates($roomTypeId, $today, $tomorrow);
        send_json(true, 'Available rooms loaded.', $rows);
    }

    if ($action === 'create_walkin') {
        require_fields([
            'guest_name'=>'Guest name', 'email'=>'Email', 'phone'=>'Phone', 'id_number'=>'National ID', 'nationality'=>'Nationality',
            'num_guests'=>'Number of guests', 'checkout_date'=>'Checkout date', 'room_type_id'=>'Room type', 'room_id'=>'Room', 'payment_method'=>'Payment method'
        ]);
        $guestName = clean($_POST['guest_name']);
        $email = strtolower(clean($_POST['email']));
        $phone = clean($_POST['phone']);
        $nationalId = clean($_POST['id_number']);
        $nationality = clean($_POST['nationality']);
        $numGuests = (int)$_POST['num_guests'];
        $checkin = date('Y-m-d');
        $checkout = clean($_POST['checkout_date']);
        $roomTypeId = (int)$_POST['room_type_id'];
        $roomId = (int)$_POST['room_id'];
        $paymentMethod = clean($_POST['payment_method']);
        $allowedMethods = ['cash','card','bkash','nagad','bank'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) send_json(false, 'Invalid email address.');
        if ($numGuests <= 0) send_json(false, 'Number of guests must be positive.');
        if (!is_valid_date($checkout) || $checkout <= $checkin) send_json(false, 'Checkout date must be after today.');
        if (!in_array($paymentMethod, $allowedMethods, true)) send_json(false, 'Invalid payment method.');

        $roomType = db::Fetch("SELECT * FROM room_types WHERE id=?", $roomTypeId);
        if (!$roomType) send_json(false, 'Room type not found.');
        if ($numGuests > (int)$roomType['max_capacity']) send_json(false, 'Number of guests exceeds room capacity.');

        $available = available_rooms_for_dates($roomTypeId, $checkin, $checkout);
        $roomOk = false;
        foreach ($available as $r) if ((int)$r['id'] === $roomId) $roomOk = true;
        if (!$roomOk) send_json(false, 'Selected room is not available for this walk-in booking.');

        $baseAmount = calculate_base_amount($roomTypeId, $checkin, $checkout);

        db::BeginTransaction();

        $guestId = db::FetchValue("SELECT id FROM users WHERE email=? OR phone=? OR national_id=? LIMIT 1", $email, $phone, $nationalId);
        if (!$guestId) {
            $usernameBase = preg_replace('/[^a-z0-9]/i', '', strtolower(explode('@', $email)[0])) ?: 'guest';
            $username = $usernameBase;
            $i = 1;
            while (db::FetchValue("SELECT id FROM users WHERE username=?", $username)) { $username = $usernameBase . $i; $i++; }
            $password = password_hash($nationalId ?: 'guest123', PASSWORD_DEFAULT);
            db::Execute(
                "INSERT INTO users(name,email,username,password_hash,phone,nationality,national_id,role,is_active)
                 VALUES(?,?,?,?,?,?,?,'guest',1)",
                $guestName, $email, $username, $password, $phone, $nationality, $nationalId
            );
            $guestId = db::InsertId();
        }

        db::Execute(
            "INSERT INTO bookings(guest_id, room_id, room_type_id, checkin_date, checkout_date, num_guests, total_price, status, source)
             VALUES(?,?,?,?,?,?,?,'checked_in','walk_in')",
            (int)$guestId, $roomId, $roomTypeId, $checkin, $checkout, $numGuests, $baseAmount
        );
        $bookingId = db::InsertId();

        db::Execute(
            "INSERT INTO billing(booking_id, guest_id, base_amount, extras_amount, discount_amount, payment_method, payment_status, paid_at, receipt_path)
             VALUES(?, ?, ?, 0, 0, ?, 'paid', NOW(), ?)",
            $bookingId, (int)$guestId, $baseAmount, $paymentMethod, 'receipts/walkin_' . $bookingId . '.html'
        );
        db::Execute("UPDATE rooms SET status='occupied' WHERE id=?", $roomId);

        db::Commit();
        send_json(true, 'Walk-in booking created and guest checked in successfully.', ['booking_id'=>$bookingId]);
    }

    send_json(false, 'Invalid action.');
} catch (Exception $e) { try { db::Rollback(); } catch(Exception $x) {} send_json(false, $e->getMessage()); }
