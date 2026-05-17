<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    // Check if it's an API request expecting JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
        exit();
    }
    
    // Calculate path to login.html based on current directory depth
    $path_to_login = strpos($_SERVER['REQUEST_URI'], 'Controller/') !== false ? '../../View/login.html' : '../login.html';
    header("Location: $path_to_login");
    exit();
}
?>
