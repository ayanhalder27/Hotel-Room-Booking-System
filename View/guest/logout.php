<?php
/**
 * GRAND HORIZON RESORT SYSTEM - SECURE LOGOUT CONTROLLER
 * Clears authentication states, tracking metrics, and kills active identity tokens.
 */

// 1. Initialize session if your authentication layer utilizes it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Unset all session variables and destroy active server session records
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();

// 3. Explicitly expire the identity tracking cookies set during your login sequence
// Setting the expiration timestamp to the deep past forces the browser to discard them immediately.
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/');
}

if (isset($_COOKIE['role'])) {
    setcookie('role', '', time() - 3600, '/');
}

/**
 * 4. Execute Secure Relocation
 * Based on your login mapping:
 * This file lives in:  /View/guest/logout.php
 * Target login portal: /View/login.html
 * Moving up one directory out of 'guest/' brings us to '/View/'
 */
header("Location: ../login.html?status=logged_out");
exit();