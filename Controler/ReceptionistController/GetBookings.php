<?php

header('Content-Type: application/json');

require_once '../../Model/Booking.php';

$bookings = Booking::getAllBookings();

if($bookings){
    echo json_encode($bookings);
}else{
    echo json_encode([]);
}

?>