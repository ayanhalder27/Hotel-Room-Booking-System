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

    case 'search_rooms':
        searchRooms();
        break;

    case 'room_details':
        getRoomDetails();
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
| SEARCH AVAILABLE ROOMS
|--------------------------------------------------------------------------
*/

function searchRooms()
{

    $checkin  = trim($_POST['checkin_date'] ?? '');
    $checkout = trim($_POST['checkout_date'] ?? '');
    $guests   = trim($_POST['guests'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (empty($checkin) || empty($checkout) || empty($guests)) {

        echo json_encode([
            'success' => false,
            'message' => 'All fields are required.'
        ]);

        exit();
    }


    if ($checkin >= $checkout) {

        echo json_encode([
            'success' => false,
            'message' => 'Check-out date must be after check-in date.'
        ]);

        exit();
    }


    if ($guests <= 0) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid guest count.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH QUERY
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT 
            rt.id,
            rt.name,
            rt.description,
            rt.price_per_night,
            rt.max_capacity,
            rt.thumbnail_path,
            rt.amenities

        FROM room_types rt

        WHERE rt.max_capacity >= ?

        AND rt.id NOT IN (

            SELECT b.room_type_id

            FROM bookings b

            WHERE b.status IN ('confirmed', 'checked_in')

            AND (
                (? BETWEEN b.checkin_date AND b.checkout_date)
                OR
                (? BETWEEN b.checkin_date AND b.checkout_date)
                OR
                (b.checkin_date BETWEEN ? AND ?)
            )
        )
    ";


    $rooms = db::FetchAll(
        $sql,
        $guests,
        $checkin,
        $checkout,
        $checkin,
        $checkout
    );


    /*
    |--------------------------------------------------------------------------
    | NO ROOM FOUND
    |--------------------------------------------------------------------------
    */

    if (!$rooms) {

        echo json_encode([
            'success' => false,
            'message' => 'No available rooms found.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | SEASONAL PRICING CHECK
    |--------------------------------------------------------------------------
    */

    foreach ($rooms as &$room) {

        $seasonal = db::Fetch(
            "
            SELECT label, price_per_night

            FROM seasonal_pricing

            WHERE room_type_id = ?

            AND (
                (? BETWEEN start_date AND end_date)
                OR
                (? BETWEEN start_date AND end_date)
            )

            LIMIT 1
            ",
            $room['id'],
            $checkin,
            $checkout
        );


        if ($seasonal) {

            $room['seasonal_price'] = $seasonal['price_per_night'];
            $room['seasonal_label'] = $seasonal['label'];

        } else {

            $room['seasonal_price'] = null;
            $room['seasonal_label'] = null;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'rooms' => $rooms
    ]);

    exit();
}




/*
|--------------------------------------------------------------------------
| ROOM DETAILS
|--------------------------------------------------------------------------
*/

function getRoomDetails()
{

    $roomTypeId = $_POST['room_type_id'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (empty($roomTypeId)) {

        echo json_encode([
            'success' => false,
            'message' => 'Room type ID is required.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | ROOM DETAILS QUERY
    |--------------------------------------------------------------------------
    */

    $room = db::Fetch(
        "
        SELECT 
            id,
            name,
            description,
            price_per_night,
            max_capacity,
            thumbnail_path,
            amenities

        FROM room_types

        WHERE id = ?
        ",
        $roomTypeId
    );


    if (!$room) {

        echo json_encode([
            'success' => false,
            'message' => 'Room not found.'
        ]);

        exit();
    }


    /*
    |--------------------------------------------------------------------------
    | REVIEW SUMMARY
    |--------------------------------------------------------------------------
    */

    $ratings = db::Fetch(
        "
        SELECT 
            AVG(overall_rating) AS overall_rating,
            AVG(cleanliness_rating) AS cleanliness_rating,
            AVG(service_rating) AS service_rating

        FROM reviews r

        INNER JOIN bookings b
        ON r.booking_id = b.id

        WHERE b.room_type_id = ?
        ",
        $roomTypeId
    );


    $room['ratings'] = $ratings;


    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'room' => $room
    ]);

    exit();
}

?>