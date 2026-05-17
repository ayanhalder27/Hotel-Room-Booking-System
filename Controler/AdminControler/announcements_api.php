<?php
include("../../Model/db.php");
header('Content-Type: application/json');

// Ensure table exists
$createTableQuery = "CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    valid_until DATE NOT NULL,
    status ENUM('active', 'draft', 'expired') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=9001;";

try {
    db::Execute($createTableQuery);
} catch (Exception $e) {
    // Ignore
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $query = "SELECT * FROM announcements ORDER BY created_at DESC";
    $data = db::FetchAll($query);
    
    $today = date('Y-m-d');
    foreach($data as &$row) {
        if ($row['status'] !== 'draft' && $row['valid_until'] < $today) {
            $row['status'] = 'expired';
        }
    }
    
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

if ($method == 'POST') {
    $id = $_POST['announcement_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $valid_until = $_POST['valid_until'] ?? '';
    $status = $_POST['status'] ?? 'active';

    $today = date('Y-m-d');
    if ($status !== 'draft' && $valid_until < $today) {
        $status = 'expired';
    }

    if ($id) {
        $success = db::Execute("UPDATE announcements SET title=?, content=?, valid_until=?, status=? WHERE id=?", 
                                $title, $content, $valid_until, $status, $id);
        echo json_encode(['success' => $success]);
    } else {
        $success = db::Execute("INSERT INTO announcements (title, content, valid_until, status) VALUES (?, ?, ?, ?)", 
                                $title, $content, $valid_until, $status);
        echo json_encode(['success' => $success]);
    }
    exit;
}

if ($method == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;
    if ($id) {
        try {
            $success = db::Execute("DELETE FROM announcements WHERE id=?", $id);
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
