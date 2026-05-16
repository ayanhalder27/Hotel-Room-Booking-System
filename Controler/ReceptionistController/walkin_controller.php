<?php
require_once '_rec_common.php';

try {
    $action = post('action');

    // Load room types
    if ($action === 'room_types') {
        db::JsonResponse(
            true,
            'Loaded',
            db::FetchAll("SELECT id, name, price_per_night FROM room_types ORDER BY name")
        );
    }

    // Load available rooms for given type and date range
    if ($action === 'available_rooms') {
        requiredFields(['room_type_id','checkin_date','checkout_date']);
        validDateRange(post('checkin_date'), post('checkout_date'));

        $rt = (int) post('room_type_id');

        $rooms = db::FetchAll(
            "SELECT id, room_number, floor 
             FROM rooms 
             WHERE room_type_id=? 
               AND status='available' 
               AND id NOT IN (
                   SELECT COALESCE(room_id,0) 
                   FROM bookings 
                   WHERE room_id IS NOT NULL 
                     AND status IN('confirmed','checked_in') 
                     AND ? < checkout_date 
                     AND ? > checkin_date
               )
             ORDER BY room_number",
            $rt,
            post('checkin_date'),
            post('checkout_date')
        );

        db::JsonResponse(true, 'Loaded', $rooms);
    }

    // Create walk-in booking
    if ($action === 'create') {
        requiredFields([
            'name','email','username','phone','nationality','national_id',
            'checkin_date','checkout_date','num_guests','room_type_id','room_id'
        ]);
        validDateRange(post('checkin_date'), post('checkout_date'));

        db::BeginTransaction();

        // Find or create guest
        $guest = db::Fetch(
            "SELECT id FROM users WHERE email=? OR phone=? OR national_id=? LIMIT 1",
            post('email'),
            post('phone'),
            post('national_id')
        );

        if ($guest) {
            $guestId = (int) $guest['id'];
        } else {
            $pass = password_hash('guest123', PASSWORD_DEFAULT);
            db::Execute(
                "INSERT INTO users(name,email,username,password_hash,phone,nationality,national_id,role,is_active) 
                 VALUES(?,?,?,?,?,?,?,'guest',1)",
                post('name'),
                post('email'),
                post('username'),
                $pass,
                post('phone'),
                post('nationality'),
                post('national_id')
            );
            $guestId = db::InsertId();
        }

        // Calculate booking details
        $rt     = (int) post('room_type_id');
        $rid    = (int) post('room_id');
        $nights = (strtotime(post('checkout_date')) - strtotime(post('checkin_date'))) / 86400;
        $price  = (float) db::FetchValue("SELECT price_per_night FROM room_types WHERE id=?", $rt);
        $total  = $price * $nights;

        // Validate room availability
        $room = db::Fetch("SELECT id, status, room_type_id FROM rooms WHERE id=? FOR UPDATE", $rid);
        if (!$room || $room['status'] !== 'available' || $room['room_type_id'] != $rt) {
            throw new Exception('Selected room is not available.');
        }

        // Insert booking
        db::Execute(
            "INSERT INTO bookings(guest_id,room_id,room_type_id,checkin_date,checkout_date,num_guests,total_price,special_requests,status,source) 
             VALUES(?,?,?,?,?,?,?,?, 'checked_in','walk_in')",
            $guestId,
            $rid,
            $rt,
            post('checkin_date'),
            post('checkout_date'),
            (int) post('num_guests'),
            $total,
            post('special_requests')
        );
        $bid = db::InsertId();

        // Insert billing
        db::Execute(
            "INSERT INTO billing(booking_id,guest_id,base_amount,extras_amount,discount_amount,payment_status) 
             VALUES(?,?,?,0,0,'pending')",
            $bid,
            $guestId,
            $total
        );

        // Update room status
        db::Execute("UPDATE rooms SET status='occupied' WHERE id=?", $rid);

        db::Commit();
        db::JsonResponse(true, "Walk-in booking created and checked in. Booking ID: $bid");
    }

    // Invalid action fallback
    db::JsonResponse(false, 'Invalid action');

} catch (Exception $e) {
    try {
        db::Rollback();
    } catch (Exception $x) {
        // ignore rollback errors
    }
    db::JsonResponse(false, $e->getMessage());
}
