<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','list');
    if($action==='active_bookings'){
        $rows=db::FetchAll("SELECT b.id,rt.name room_type,r.room_number FROM bookings b JOIN room_types rt ON rt.id=b.room_type_id LEFT JOIN rooms r ON r.id=b.room_id WHERE b.guest_id=? AND b.status='checked_in' ORDER BY b.id DESC",$gid); jsonResponse(true,'Active bookings loaded.',$rows);
    }
    if($action==='list'){
        $q=post('q'); $sql='SELECT sr.*,r.room_number,rt.name room_type FROM service_requests sr JOIN bookings b ON b.id=sr.booking_id LEFT JOIN rooms r ON r.id=sr.room_id LEFT JOIN room_types rt ON rt.id=b.room_type_id WHERE sr.guest_id=?'; $params=[$gid];
        if($q!==''){ $sql.=' AND (sr.service_type LIKE ? OR sr.description LIKE ? OR sr.status LIKE ?)'; $params[]=likeQ($q); $params[]=likeQ($q); $params[]=likeQ($q); }
        $sql.=' ORDER BY sr.id DESC'; jsonResponse(true,'Service requests loaded.',db::FetchAll($sql,...$params));
    }
    if($action==='create'){
        requiredFields(['booking_id','service_type','description']); $bid=(int)post('booking_id'); $b=db::Fetch('SELECT id,guest_id,room_id,status FROM bookings WHERE id=? AND guest_id=?',$bid,$gid); if(!$b) throw new Exception('Booking not found.'); if($b['status']!=='checked_in') throw new Exception('Service requests are allowed only during active stay.');
        db::Execute("INSERT INTO service_requests (booking_id,guest_id,room_id,service_type,description,status,requested_at) VALUES (?,?,?,?,?,'pending',NOW())",$bid,$gid,$b['room_id'],post('service_type'),post('description')); jsonResponse(true,'Service request submitted.');
    }
    if($action==='delete'){ requiredFields(['id']); db::Execute("DELETE FROM service_requests WHERE id=? AND guest_id=? AND status='pending'",(int)post('id'),$gid); jsonResponse(true,'Pending request deleted.'); }
});
?>
