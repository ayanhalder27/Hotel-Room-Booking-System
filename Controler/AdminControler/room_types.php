<?php
include("../Model/db.php");

$data = db::FetchAll("SELECT rt.name, rt.description, rt.price_per_night, rt.max_capacity, rt.amenities, COUNT(r.id) AS total_rooms FROM room_types rt LEFT JOIN rooms r ON rt.id = r.room_type_id GROUP BY rt.id, rt.name, rt.description, rt.price_per_night, rt.max_capacity, rt.amenities;");

header('Content-Type: application/json');
echo json_encode($data);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['saveRoomType'])) {
        $name = $_POST['typeName'];
        $description = $_POST['description'];
        $price_per_night = $_POST['basePrice'];
        $max_capacity = $_POST['maxCapacity'];
        $amenities = json_encode($_POST['amenities'] ?? []);
        $thumbnail = $_FILES['roomThumbnail']['name'] ?? null;
        move_uploaded_file($_FILES["roomThumbnail"]["tmp_name"], "../Resources/images/" . $_FILES["roomThumbnail"]["name"]);

        $success = db::Execute("INSERT INTO room_types (name, description, price_per_night, max_capacity, amenities, thumbnail_path) VALUES ('$name', '$description', '$price_per_night', '$max_capacity', '$amenities', '$thumbnail')");
        if($success) {
            header("Location: ../View/room_types.html?success=1");
        } else {
            header("Location: ../View/room_types.html?error=1");
        }
        exit();
    }
}
?>