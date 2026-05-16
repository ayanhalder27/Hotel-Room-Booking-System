<?php

header('Content-Type: application/json');

require_once '../../Model/Room.php';

$data = Room::getAllRooms();

echo json_encode($data);

?>