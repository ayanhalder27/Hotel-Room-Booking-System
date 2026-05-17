<?php
include("../../Model/db.php");
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $data = db::FetchAll("SELECT rt.id, rt.name, rt.description, rt.price_per_night, rt.max_capacity, rt.amenities, rt.thumbnail_path, COUNT(r.id) AS total_rooms FROM room_types rt LEFT JOIN rooms r ON rt.id = r.room_type_id GROUP BY rt.id, rt.name, rt.description, rt.price_per_night, rt.max_capacity, rt.amenities, rt.thumbnail_path ORDER BY rt.id DESC");
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['type_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $price_per_night = $_POST['price_per_night'] ?? 0;
    $max_capacity = $_POST['max_capacity'] ?? 1;
    $description = $_POST['description'] ?? '';
    $amenities = isset($_POST['amenities']) ? json_encode($_POST['amenities']) : '[]';

    $thumbnail_path = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../../Resources/uploads/room_types/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['thumbnail']['name']);
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFile)) {
            $thumbnail_path = 'Resources/uploads/room_types/' . $fileName;
        }
    }

    if ($id) {
        // Update
        if ($thumbnail_path) {
            $success = db::Execute("UPDATE room_types SET name=?, description=?, price_per_night=?, max_capacity=?, amenities=?, thumbnail_path=? WHERE id=?", $name, $description, $price_per_night, $max_capacity, $amenities, $thumbnail_path, $id);
        } else {
            $success = db::Execute("UPDATE room_types SET name=?, description=?, price_per_night=?, max_capacity=?, amenities=? WHERE id=?", $name, $description, $price_per_night, $max_capacity, $amenities, $id);
        }
        echo json_encode(['success' => $success]);
    } else {
        // Create
        $success = db::Execute("INSERT INTO room_types (name, description, price_per_night, max_capacity, amenities, thumbnail_path) VALUES (?, ?, ?, ?, ?, ?)", $name, $description, $price_per_night, $max_capacity, $amenities, $thumbnail_path);
        echo json_encode(['success' => $success]);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            // Check for dependencies before deleting
            $rooms = db::FetchAll("SELECT COUNT(id) as c FROM rooms WHERE room_type_id=?", $id)[0]['c'] ?? 0;
            $bookings = db::FetchAll("SELECT COUNT(id) as c FROM bookings WHERE room_type_id=?", $id)[0]['c'] ?? 0;
            $pricing = db::FetchAll("SELECT COUNT(id) as c FROM seasonal_pricing WHERE room_type_id=?", $id)[0]['c'] ?? 0;
            
            if ($rooms > 0 || $bookings > 0 || $pricing > 0) {
                $refs = [];
                if ($rooms > 0) $refs[] = "$rooms room(s)";
                if ($bookings > 0) $refs[] = "$bookings booking(s)";
                if ($pricing > 0) $refs[] = "$pricing pricing rule(s)";
                echo json_encode(['success' => false, 'error' => "Cannot delete room type because it is referenced by " . implode(', ', $refs) . '.']);
                exit;
            }

            $success = db::Execute("DELETE FROM room_types WHERE id=?", $id);
            echo json_encode(['success' => $success]);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (strpos($msg, 'foreign key constraint fails') !== false) {
                $msg = 'Cannot delete room type: It is currently assigned to existing records.';
            }
            echo json_encode(['success' => false, 'error' => $msg]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No ID provided']);
    }
    exit;
}
?>