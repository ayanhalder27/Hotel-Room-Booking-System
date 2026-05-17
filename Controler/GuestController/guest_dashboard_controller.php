<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','stats');
    if($action==='stats'){
        $stats=[
            'upcoming_bookings'=>(int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE guest_id=? AND status IN ('pending','confirmed') AND checkin_date>=CURDATE()",$gid),
            'active_stays'=>(int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE guest_id=? AND status='checked_in'",$gid),
            'completed_stays'=>(int)db::FetchValue("SELECT COUNT(*) FROM bookings WHERE guest_id=? AND status='checked_out'",$gid),
            'pending_requests'=>(int)db::FetchValue("SELECT COUNT(*) FROM service_requests WHERE guest_id=? AND status IN ('pending','in_progress')",$gid),
            'loyalty_balance'=>(int)db::FetchValue("SELECT COALESCE(balance,0) FROM loyalty_points WHERE guest_id=? ORDER BY id DESC LIMIT 1",$gid),
            'unpaid_bills'=>(int)db::FetchValue("SELECT COUNT(*) FROM billing WHERE booking_id IN (SELECT id FROM bookings WHERE guest_id=?) AND payment_status IN ('pending','unpaid')",$gid)
        ];
        $recent=db::FetchAll("SELECT b.id,rt.name room_type,b.checkin_date,b.checkout_date,b.status,b.total_price FROM bookings b JOIN room_types rt ON rt.id=b.room_type_id WHERE b.guest_id=? ORDER BY b.id DESC LIMIT 6",$gid);
        jsonResponse(true,'Dashboard loaded.',['stats'=>$stats,'recent_bookings'=>$recent]);
    }
});
?>
