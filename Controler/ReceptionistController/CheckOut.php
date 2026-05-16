<?php

header('Content-Type: application/json');

require_once '../../Model/Booking.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['booking_id'])){

        $bookingId = $_POST['booking_id'];

        $success = Booking::checkOut($bookingId);

        if($success){

            echo json_encode([
                'status' => 'success',
                'message' => 'Guest checked out successfully'
            ]);

        }else{

            echo json_encode([
                'status' => 'failed',
                'message' => 'Check-out failed'
            ]);

        }

    }

}

?>