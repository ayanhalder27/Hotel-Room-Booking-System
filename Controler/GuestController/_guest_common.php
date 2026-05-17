<?php
require_once __DIR__ . '/../../Model/dbRec.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Send JSON response in a consistent format.
 */
function jsonResponse(bool $success, string $message, array $data = []): void {
    db::JsonResponse($success, $message, $data);
}

/**
 * Retrieve POST value safely.
 */
function post(string $key, string $default = ''): string {
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}

/**
 * Retrieve value from POST or GET safely.
 */
function reqv(string $key, string $default = ''): string {
    if (isset($_POST[$key])) {
        return trim((string)$_POST[$key]);
    }
    if (isset($_GET[$key])) {
        return trim((string)$_GET[$key]);
    }
    return $default;
}

/**
 * Prepare value for SQL LIKE queries.
 */
function likeQ(string $value): string {
    return '%' . $value . '%';
}

/**
 * Ensure current user is a guest and return their ID.
 */
function requireGuest(): int {
    if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'guest') {
        jsonResponse(false, 'Unauthorized. Login as guest first.');
    }
    return (int)$_SESSION['user_id'];
}

/**
 * Validate required POST fields.
 */
function requiredFields(array $fields): void {
    foreach ($fields as $field) {
        if (post($field) === '') {
            throw new Exception(ucwords(str_replace('_', ' ', $field)) . ' is required.');
        }
    }
}

/**
 * Validate check-in and checkout date range.
 */
function validDateRange(string $checkin, string $checkout): void {
    if ($checkin === '' || $checkout === '') {
        throw new Exception('Check-in and checkout dates are required.');
    }
    if (strtotime($checkout) <= strtotime($checkin)) {
        throw new Exception('Checkout date must be after check-in date.');
    }
}

/**
 * Calculate number of nights between two dates.
 */
function nightsBetween(string $checkin, string $checkout): int {
    validDateRange($checkin, $checkout);
    return (int)((strtotime($checkout) - strtotime($checkin)) / 86400);
}

/**
 * Check if a column exists in a given table.
 */
function columnExists(string $table, string $column): bool {
    $dbName = db::FetchValue('SELECT DATABASE()');
    $count = (int)db::FetchValue(
        'SELECT COUNT(*) 
         FROM INFORMATION_SCHEMA.COLUMNS 
         WHERE TABLE_SCHEMA=? AND TABLE_NAME=? AND COLUMN_NAME=?',
        $dbName, $table, $column
    );
    return $count > 0;
}

/**
 * Dynamic column helpers.
 */
function userIdColumn(): string {
    return columnExists('users', 'national_id') ? 'national_id' : 'id_number';
}

function roomCapacityColumn(): string {
    if (columnExists('room_types', 'max_capacity')) return 'max_capacity';
    if (columnExists('room_types', 'capacity')) return 'capacity';
    return 'max_capacity';
}

function billingGuestColumnExists(): bool {
    return columnExists('billing', 'guest_id');
}

function bookingSourceColumnExists(): bool {
    return columnExists('bookings', 'source');
}

function bookingSpecialRequestColumnExists(): bool {
    return columnExists('bookings', 'special_requests');
}

/**
 * Get current guest ID.
 */
function currentGuestId(): int {
    return requireGuest();
}

/**
 * Verify guest owns a booking.
 */
function guestOwnsBooking(int $bookingId, int $guestId): bool {
    $count = (int)db::FetchValue(
        'SELECT COUNT(*) FROM bookings WHERE id=? AND guest_id=?',
        $bookingId, $guestId
    );
    return $count > 0;
}

/**
 * Get seasonal price for a room type.
 */
function seasonalPrice(int $roomTypeId, string $checkin, string $checkout): array {
    $basePrice = (float)db::FetchValue(
        'SELECT price_per_night FROM room_types WHERE id=?',
        $roomTypeId
    );

    $seasonal = db::Fetch(
        'SELECT label, price_per_night 
         FROM seasonal_pricing 
         WHERE room_type_id=? AND start_date<=? AND end_date>=? 
         ORDER BY price_per_night DESC LIMIT 1',
        $roomTypeId, $checkout, $checkin
    );

    return [
        'price'    => $seasonal ? (float)$seasonal['price_per_night'] : $basePrice,
        'seasonal' => $seasonal
    ];
}

/**
 * Count available rooms for a given type and date range.
 */
function availableRoomCount(int $roomTypeId, string $checkin, string $checkout): int {
    return (int)db::FetchValue(
        "SELECT COUNT(*) 
         FROM rooms r 
         WHERE r.room_type_id=? 
           AND r.status='available' 
           AND r.id NOT IN (
                SELECT COALESCE(room_id,0) 
                FROM bookings 
                WHERE room_id IS NOT NULL 
                  AND status IN ('pending','confirmed','checked_in') 
                  AND ? < checkout_date 
                  AND ? > checkin_date
           )",
        $roomTypeId, $checkin, $checkout
    );
}

/**
 * Wrap controller logic with error handling.
 */
function wrapController(callable $fn): void {
    try {
        $fn();
        jsonResponse(false, 'Invalid action.');
    } catch (Exception $e) {
        try { db::Rollback(); } catch (Exception $x) {}
        jsonResponse(false, $e->getMessage());
    }
}
