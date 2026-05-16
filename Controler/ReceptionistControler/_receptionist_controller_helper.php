<?php
require_once __DIR__ . '/../Model/dbRec.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function send_json($success, $message, $data = []) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => (bool)$success,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

function require_receptionist() {
    // Enable this after confirming your login session uses these exact keys.
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'receptionist') {
        send_json(false, 'Unauthorized access. Please login as receptionist.');
    }
}

function request_action() {
    return $_POST['action'] ?? $_GET['action'] ?? '';
}

function clean($value) {
    return trim((string)$value);
}

function require_fields($fields) {
    foreach ($fields as $field => $label) {
        if (!isset($_POST[$field]) || clean($_POST[$field]) === '') {
            send_json(false, $label . ' is required.');
        }
    }
}

function is_valid_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function money($amount) {
    return number_format((float)$amount, 2, '.', '');
}

function available_rooms_for_dates($roomTypeId, $checkin, $checkout, $excludeBookingId = 0) {
    return db::FetchAll(
        "SELECT r.id, r.room_number, r.floor, rt.name AS room_type
         FROM rooms r
         INNER JOIN room_types rt ON rt.id = r.room_type_id
         WHERE r.room_type_id = ?
           AND r.status = 'available'
           AND r.id NOT IN (
                SELECT b.room_id FROM bookings b
                WHERE b.room_id IS NOT NULL
                  AND b.status IN ('confirmed','checked_in')
                  AND b.id <> ?
                  AND ? < b.checkout_date
                  AND ? > b.checkin_date
           )
         ORDER BY r.floor ASC, r.room_number ASC",
        (int)$roomTypeId,
        (int)$excludeBookingId,
        $checkin,
        $checkout
    );
}

function calculate_base_amount($roomTypeId, $checkin, $checkout) {
    $roomType = db::Fetch("SELECT price_per_night FROM room_types WHERE id = ?", (int)$roomTypeId);
    if (!$roomType) {
        send_json(false, 'Room type not found.');
    }

    $start = new DateTime($checkin);
    $end = new DateTime($checkout);
    $nights = (int)$start->diff($end)->days;
    if ($nights <= 0) {
        send_json(false, 'Checkout date must be after check-in date.');
    }

    return (float)$roomType['price_per_night'] * $nights;
}
