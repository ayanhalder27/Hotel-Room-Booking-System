<?php

require_once 'db.php';

class Booking extends db{


    // ==========================================
    // GET ALL BOOKINGS
    // ==========================================

    public static function getAllBookings(){

        $query = "SELECT

                    bookings.id,

                    users.name,

                    rooms.room_number,

                    bookings.checkin_date,

                    bookings.checkout_date,

                    bookings.status

                  FROM bookings

                  JOIN users
                  ON bookings.guest_id = users.id

                  JOIN rooms
                  ON bookings.room_id = rooms.id

                  ORDER BY bookings.id DESC";



        return self::FetchAll($query);

    }



    // ==========================================
    // SEARCH BOOKINGS
    // ==========================================

    public static function searchBooking($search){

        $search = "%".$search."%";



        $query = "SELECT

                    bookings.id,

                    users.name,

                    rooms.room_number,

                    bookings.checkin_date,

                    bookings.checkout_date,

                    bookings.status

                  FROM bookings

                  JOIN users
                  ON bookings.guest_id = users.id

                  JOIN rooms
                  ON bookings.room_id = rooms.id

                  WHERE

                    bookings.id LIKE ?

                    OR users.name LIKE ?

                    OR rooms.room_number LIKE ?";



        return self::FetchAll(
            $query,
            $search,
            $search,
            $search
        );

    }



    // ==========================================
    // CHECK IN
    // ==========================================

    public static function checkIn($bookingId){

        $query1 = "UPDATE bookings
                   SET status='checked_in'
                   WHERE id=?";

        self::Execute($query1, $bookingId);



        $query2 = "UPDATE rooms

                   SET status='occupied'

                   WHERE id = (

                        SELECT room_id
                        FROM bookings
                        WHERE id=?

                   )";



        return self::Execute(
            $query2,
            $bookingId
        );

    }



    // ==========================================
    // CHECK OUT
    // ==========================================

    public static function checkOut($bookingId){

        $query1 = "UPDATE bookings
                   SET status='checked_out'
                   WHERE id=?";

        self::Execute($query1, $bookingId);



        $query2 = "UPDATE rooms

                   SET status='dirty'

                   WHERE id = (

                        SELECT room_id
                        FROM bookings
                        WHERE id=?

                   )";



        return self::Execute(
            $query2,
            $bookingId
        );

    }



    // ==========================================
    // CREATE WALK-IN BOOKING
    // ==========================================

    public static function createWalkinBooking(
        $guestId,
        $roomId,
        $checkin,
        $checkout
    ){

        // GET ROOM TYPE
        $roomQuery = "SELECT room_type_id
                      FROM rooms
                      WHERE id=?";

        $room = self::Fetch(
            $roomQuery,
            $roomId
        );



        $roomTypeId = $room['room_type_id'];



        // INSERT BOOKING
        $query = "INSERT INTO bookings
        (
            guest_id,
            room_id,
            room_type_id,
            checkin_date,
            checkout_date,
            num_guests,
            total_price,
            special_requests,
            status,
            source
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            1,
            0,
            '',
            'checked_in',
            'walk_in'
        )";



        self::Execute(
            $query,
            $guestId,
            $roomId,
            $roomTypeId,
            $checkin,
            $checkout
        );



        // UPDATE ROOM STATUS
        $query2 = "UPDATE rooms
                   SET status='occupied'
                   WHERE id=?";



        return self::Execute(
            $query2,
            $roomId
        );

    }

}

?>