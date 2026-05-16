<?php

require_once 'dbRec.php';

class Room extends db{

    public static function getAllRooms(){

        $query = "SELECT
                    rooms.room_number,
                    room_types.name AS room_type,
                    rooms.floor,
                    rooms.status
                  FROM rooms
                  JOIN room_types
                  ON rooms.room_type_id = room_types.id";

        return self::FetchAll($query);
    }

}

?>