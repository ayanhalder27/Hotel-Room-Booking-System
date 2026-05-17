<?php
require_once __DIR__ . '/../admin_auth.php';
include("../../Model/db.php");
try {
    db::Execute("ALTER TABLE reviews ADD COLUMN status ENUM('pending', 'published', 'hidden') DEFAULT 'pending' AFTER admin_reply");
    echo "Success altering table";
} catch(Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
