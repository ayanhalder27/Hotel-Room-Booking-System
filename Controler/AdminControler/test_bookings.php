<?php
include("../../Model/db.php");
try {
    $data = db::FetchAll("SELECT b.id, u.name as guest_name, rt.name as room_type, b.check_in_date, b.check_out_date, b.total_price, b.status 
                      FROM bookings b 
                      INNER JOIN users u ON b.guest_id = u.id
                      LEFT JOIN rooms r ON b.room_id = r.id
                      LEFT JOIN room_types rt ON r.room_type_id = rt.id OR b.room_id IS NULL AND rt.id = 1
                      ORDER BY b.created_at DESC LIMIT 5");
    var_dump($data);
} catch(Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
