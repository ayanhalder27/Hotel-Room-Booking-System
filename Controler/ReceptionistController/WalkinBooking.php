<?php

header('Content-Type: application/json');

require_once '../../Model/User.php';
require_once '../../Model/Booking.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $name = trim($_POST['guest_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $roomId = trim($_POST['room_id']);

    $checkin = trim($_POST['checkin_date']);
    $checkout = trim($_POST['checkout_date']);



    if(
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($roomId) ||
        empty($checkin) ||
        empty($checkout)
    ){

        echo json_encode([
            'status' => 'failed',
            'message' => 'All fields are required'
        ]);

        exit();
    }



    $guestId = User::createGuest(
        $name,
        $email,
        $phone
    );



    $success = Booking::createWalkinBooking(
        $guestId,
        $roomId,
        $checkin,
        $checkout
    );



    if($success){

        echo json_encode([
            'status' => 'success',
            'message' => 'Walk-in booking created successfully'
        ]);

    }else{

        echo json_encode([
            'status' => 'failed',
            'message' => 'Booking creation failed'
        ]);

    }

}

?>