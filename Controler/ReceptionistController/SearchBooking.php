<?php

header('Content-Type: application/json');

require_once '../../Model/Booking.php';


if(isset($_GET['search'])){

    $search = trim($_GET['search']);

    if($search == ''){

        $data = Booking::getAllBookings();

    }else{

        $data = Booking::searchBooking($search);

    }

    echo json_encode($data);

}

?>