<?php

require_once 'dbRec.php';

class Service extends db{

    public static function getAllServices(){
    $query = "SELECT
                service_requests.id,
                users.name,
                rooms.room_number,
                service_requests.service_type,
                service_requests.description, -- Added this line
                service_requests.status
              FROM service_requests
              JOIN users ON service_requests.guest_id = users.id
              JOIN rooms ON service_requests.room_id = rooms.id";

    return self::FetchAll($query);
}

    public static function updateServiceStatus(
    $serviceId,
    $status
){

    $query = "UPDATE service_requests
              SET status=?
              WHERE id=?";

    return self::Execute(
        $query,
        $status,
        $serviceId
    );

}

}

?>