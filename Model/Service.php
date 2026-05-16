<?php

require_once 'dbRec.php';

class Service extends db{

    public static function getAllServices(){

        $query = "SELECT
                    service_requests.id,
                    users.name,
                    rooms.room_number,
                    service_requests.service_type,
                    service_requests.status
                  FROM service_requests
                  JOIN users ON service_requests.guest_id = users.id
                  JOIN rooms ON service_requests.room_id = rooms.id";

        return self::FetchAll($query);
    }

}

?>