<?php

session_start();

header('Content-Type: application/json');

require_once("../../Model/db.php");


/*
|--------------------------------------------------------------------------
| AUTH CHECK
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION['user'])) {

    echo json_encode([
        'success' => false,
        'message' => 'Please login first.'
    ]);

    exit();
}


/*
|--------------------------------------------------------------------------
| ROLE CHECK
|--------------------------------------------------------------------------
*/

if ($_SESSION['user']['role'] !== 'guest') {

    echo json_encode([
        'success' => false,
        'message' => 'Unauthorized access.'
    ]);

    exit();
}


/*
|--------------------------------------------------------------------------
| REQUEST METHOD CHECK
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);

    exit();
}


/*
|--------------------------------------------------------------------------
| ACTION ROUTER
|--------------------------------------------------------------------------
*/

$action = $_POST['action'] ?? '';

switch ($action) {

    case 'create_booking':
        createBooking();
        break;

    case 'booking_history':
        bookingHistory();
        break;

    case 'booking_details':
        bookingDetails();
        break;

    case 'cancel_booking':
        cancelBooking();
        break;

    default:

        echo json_encode([
            'success' => false,
            'message' => 'Invalid action.'
        ]);

        break;
}




/*
|--------------------------------------------------------------------------
| CREATE BOOKING
|--------------------------------------------------------------------------
*/

function createBooking()
{

    $guestId         = $_SESSION['user']['id'];

    $roomTypeId      = trim($_POST['room_type_id'] ?? '');
    $checkinDate     = trim($_POST['checkin_date'] ?? '');
    $checkoutDate    = trim($_POST['checkout_date'] ?? '');
    $numGuests       = trim($_POST['num_guests'] ?? '');
    $specialRequests = trim($_POST['special_requests'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        empty($roomTypeId) ||
        empty($checkinDate) ||
        empty($checkoutDate) ||
        empty($numGuests)
    ) {

        echo json_encode([
            'success' => false,
            'message' => 'All required fields must be filled.'
        ]);

        exit();
    }


    if ($checkinDate >= $checkoutDate) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid booking dates.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | ROOM TYPE CHECK
    |--------------------------------------------------------------------------
    */

    $roomType = db::Fetch(
        "
        SELECT *
        FROM room_types
        WHERE id = ?
        ",
        $roomTypeId
    );


    if (!$roomType) {

        echo json_encode([
            'success' => false,
            'message' => 'Room type not found.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | GUEST CAPACITY CHECK
    |--------------------------------------------------------------------------
    */

    if ($numGuests > $roomType['max_capacity']) {

        echo json_encode([
            'success' => false,
            'message' => 'Guest count exceeds room capacity.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL PRICE CALCULATION
    |--------------------------------------------------------------------------
    */

    $days = (strtotime($checkoutDate) - strtotime($checkinDate)) / (60 * 60 * 24);

    $pricePerNight = $roomType['price_per_night'];


    /*
    |--------------------------------------------------------------------------
    | SEASONAL PRICE CHECK
    |--------------------------------------------------------------------------
    */

    $seasonal = db::Fetch(
        "
        SELECT price_per_night

        FROM seasonal_pricing

        WHERE room_type_id = ?

        AND (
            (? BETWEEN start_date AND end_date)
            OR
            (? BETWEEN start_date AND end_date)
        )

        LIMIT 1
        ",
        $roomTypeId,
        $checkinDate,
        $checkoutDate
    );


    if ($seasonal) {

        $pricePerNight = $seasonal['price_per_night'];
    }


    $totalPrice = $days * $pricePerNight;


    /*
    |--------------------------------------------------------------------------
    | CREATE BOOKING
    |--------------------------------------------------------------------------
    */

    $bookingInsert = db::Execute(
        "
        INSERT INTO bookings
        (
            guest_id,
            room_type_id,
            checkin_date,
            checkout_date,
            num_guests,
            total_price,
            special_requests,
            status
        )

        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?, 'pending'
        )
        ",
        $guestId,
        $roomTypeId,
        $checkinDate,
        $checkoutDate,
        $numGuests,
        $totalPrice,
        $specialRequests
    );


    if (!$bookingInsert) {

        echo json_encode([
            'success' => false,
            'message' => 'Failed to create booking.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | GET LAST BOOKING ID
    |--------------------------------------------------------------------------
    */

    $booking = db::Fetch(
        "
        SELECT id

        FROM bookings

        WHERE guest_id = ?

        ORDER BY id DESC

        LIMIT 1
        ",
        $guestId
    );


    $bookingId = $booking['id'];


    /*
    |--------------------------------------------------------------------------
    | CREATE BILLING
    |--------------------------------------------------------------------------
    */

    db::Execute(
        "
        INSERT INTO billing
        (
            booking_id,
            guest_id,
            base_amount,
            payment_status
        )

        VALUES
        (
            ?, ?, ?, 'pending'
        )
        ",
        $bookingId,
        $guestId,
        $totalPrice
    );


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'message' => 'Booking created successfully.',
        'booking_id' => $bookingId
    ]);

    exit();
}




/*
|--------------------------------------------------------------------------
| BOOKING HISTORY
|--------------------------------------------------------------------------
*/

function bookingHistory()
{

    $guestId = $_SESSION['user']['id'];


    $bookings = db::FetchAll(
        "
        SELECT
            b.id,
            b.checkin_date,
            b.checkout_date,
            b.total_price,
            b.status,
            rt.name AS room_type

        FROM bookings b

        INNER JOIN room_types rt
        ON b.room_type_id = rt.id

        WHERE b.guest_id = ?

        ORDER BY b.id DESC
        ",
        $guestId
    );


    echo json_encode([
        'success' => true,
        'bookings' => $bookings
    ]);

    exit();
}




/*
|--------------------------------------------------------------------------
| BOOKING DETAILS
|--------------------------------------------------------------------------
*/

function bookingDetails()
{

    $bookingId = $_POST['booking_id'] ?? '';


    if (empty($bookingId)) {

        echo json_encode([
            'success' => false,
            'message' => 'Booking ID is required.'
        ]);

        exit();
    }


    $booking = db::Fetch(
        "
        SELECT
            b.*,
            rt.name AS room_type,
            rt.description,
            rt.price_per_night,
            r.room_number,

            bill.total_amount,
            bill.payment_method,
            bill.payment_status

        FROM bookings b

        INNER JOIN room_types rt
        ON b.room_type_id = rt.id

        LEFT JOIN rooms r
        ON b.room_id = r.id

        LEFT JOIN billing bill
        ON b.id = bill.booking_id

        WHERE b.id = ?
        AND b.guest_id = ?
        ",
        $bookingId,
        $_SESSION['user']['id']
    );


    if (!$booking) {

        echo json_encode([
            'success' => false,
            'message' => 'Booking not found.'
        ]);

        exit();
    }


    echo json_encode([
        'success' => true,
        'booking' => $booking
    ]);

    exit();
}




/*
|--------------------------------------------------------------------------
| CANCEL BOOKING
|--------------------------------------------------------------------------
*/

function cancelBooking()
{

    $bookingId = $_POST['booking_id'] ?? '';


    if (empty($bookingId)) {

        echo json_encode([
            'success' => false,
            'message' => 'Booking ID is required.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK BOOKING
    |--------------------------------------------------------------------------
    */

    $booking = db::Fetch(
        "
        SELECT *
        FROM bookings
        WHERE id = ?
        AND guest_id = ?
        ",
        $bookingId,
        $_SESSION['user']['id']
    );


    if (!$booking) {

        echo json_encode([
            'success' => false,
            'message' => 'Booking not found.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS CHECK
    |--------------------------------------------------------------------------
    */

    if ($booking['status'] == 'cancelled') {

        echo json_encode([
            'success' => false,
            'message' => 'Booking already cancelled.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | CANCEL BOOKING
    |--------------------------------------------------------------------------
    */

    $cancel = db::Execute(
        "
        UPDATE bookings

        SET status = 'cancelled'

        WHERE id = ?
        ",
        $bookingId
    );


    if (!$cancel) {

        echo json_encode([
            'success' => false,
            'message' => 'Failed to cancel booking.'
        ]);

        exit();
    }


    echo json_encode([
        'success' => true,
        'message' => 'Booking cancelled successfully.'
    ]);

    exit();
}

?>