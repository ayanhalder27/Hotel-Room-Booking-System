<?php
require_once __DIR__ . "/../../Model/dbRec.php";

try {
    $action = $_POST['action'] ?? 'list';

    if ($action === 'list') {
        $q = $_POST['q'] ?? '';

        $sql = "
            SELECT 
                b.id,
                u.name AS guest_name,
                rt.name AS room_type,
                b.room_type_id,
                b.room_id,
                b.checkin_date,
                b.checkout_date,
                b.status
            FROM bookings b
            JOIN users u ON u.id = b.guest_id
            JOIN room_types rt ON rt.id = b.room_type_id
            WHERE 1=1
        ";

        $params = [];

        if ($q !== '') {
            $sql .= " AND (CAST(b.id AS CHAR) LIKE ? OR u.name LIKE ?)";
            $params[] = "%$q%";
            $params[] = "%$q%";
        }

        $sql .= " ORDER BY b.id DESC LIMIT 100";

        $bookings = db::FetchAll($sql, ...$params);

        db::JsonResponse(true, "Bookings loaded successfully.", $bookings);
    }

    if ($action === 'update_dates') {
        $booking_id = $_POST['booking_id'] ?? '';
        $checkin_date = $_POST['checkin_date'] ?? '';
        $checkout_date = $_POST['checkout_date'] ?? '';

        if ($booking_id === '' || $checkin_date === '' || $checkout_date === '') {
            throw new Exception("All fields are required.");
        }

        if ($checkout_date <= $checkin_date) {
            throw new Exception("Checkout date must be after check-in date.");
        }

        db::BeginTransaction();

        $booking = db::Fetch("SELECT * FROM bookings WHERE id=?", (int)$booking_id);

        if (!$booking) {
            throw new Exception("Booking not found.");
        }

        $price = db::FetchValue(
            "SELECT price_per_night FROM room_types WHERE id=?",
            (int)$booking['room_type_id']
        );

        $nights = (strtotime($checkout_date) - strtotime($checkin_date)) / 86400;
        $total = $price * $nights;

        db::Execute(
            "UPDATE bookings SET checkin_date=?, checkout_date=?, total_price=? WHERE id=?",
            $checkin_date,
            $checkout_date,
            $total,
            (int)$booking_id
        );

        db::Execute(
            "UPDATE billing SET base_amount=?, total_amount=(? + extras_amount - discount_amount) WHERE booking_id=?",
            $total,
            $total,
            (int)$booking_id
        );

        db::Commit();

        db::JsonResponse(true, "Booking updated successfully.");
    }

    db::JsonResponse(false, "Invalid action.");

} catch (Exception $e) {
    try {
        db::Rollback();
    } catch (Exception $ignore) {}

    db::JsonResponse(false, $e->getMessage());
}