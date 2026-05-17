<?php
include("../../Model/db.php");
header('Content-Type: application/json');

// Ensure table exists
$createTableQuery = "CREATE TABLE IF NOT EXISTS seasonal_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(100) NOT NULL,
    room_type_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    price_per_night DECIMAL(10,2) NOT NULL,
    status ENUM('active', 'upcoming', 'expired') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_type_id) REFERENCES room_types(id)
) ENGINE=InnoDB AUTO_INCREMENT=8001;";

try {
    db::Execute($createTableQuery);
} catch (Exception $e) {
    // Table probably exists or we don't have permission. Ignore.
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = "SELECT sp.*, rt.name as room_type_name 
              FROM seasonal_pricing sp
              INNER JOIN room_types rt ON sp.room_type_id = rt.id
              ORDER BY sp.start_date ASC";
    $data = db::FetchAll($query);
    
    // Auto-update status based on dates if needed, but we can do it frontend or just use data as is.
    $today = date('Y-m-d');
    foreach($data as &$row) {
        if ($row['end_date'] < $today) $row['status'] = 'expired';
        else if ($row['start_date'] > $today) $row['status'] = 'upcoming';
        else $row['status'] = 'active';
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['id'] ?? '';
    $label = $_POST['label'] ?? '';
    $room_type_id = $_POST['room_type_id'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $price_per_night = $_POST['price_per_night'] ?? '';

    $today = date('Y-m-d');
    $status = 'active';
    if ($end_date < $today) $status = 'expired';
    else if ($start_date > $today) $status = 'upcoming';

    if ($id) {
        $success = db::Execute("UPDATE seasonal_pricing SET label=?, room_type_id=?, start_date=?, end_date=?, price_per_night=?, status=? WHERE id=?", 
                                $label, $room_type_id, $start_date, $end_date, $price_per_night, $status, $id);
        echo json_encode(['success' => $success]);
    } else {
        $success = db::Execute("INSERT INTO seasonal_pricing (label, room_type_id, start_date, end_date, price_per_night, status) VALUES (?, ?, ?, ?, ?, ?)", 
                                $label, $room_type_id, $start_date, $end_date, $price_per_night, $status);
        echo json_encode(['success' => $success]);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM seasonal_pricing WHERE id=?", $id);
            echo json_encode(['success' => $success]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'No ID provided']);
    }
    exit;
}
?>
