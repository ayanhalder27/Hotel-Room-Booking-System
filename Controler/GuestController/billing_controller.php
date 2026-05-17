<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','list');
    if($action==='list'){
        $q=post('q'); $sql='SELECT bill.*,b.id booking_no,b.checkin_date,b.checkout_date,b.status booking_status,rt.name room_type FROM billing bill JOIN bookings b ON b.id=bill.booking_id JOIN room_types rt ON rt.id=b.room_type_id WHERE b.guest_id=?'; $params=[$gid];
        if($q!==''){ $sql.=' AND (CAST(b.id AS CHAR) LIKE ? OR rt.name LIKE ? OR bill.payment_status LIKE ?)'; $params[]=likeQ($q); $params[]=likeQ($q); $params[]=likeQ($q); }
        $sql.=' ORDER BY bill.id DESC'; jsonResponse(true,'Billing history loaded.',db::FetchAll($sql,...$params));
    }
    if($action==='receipt'){
        requiredFields(['billing_id']);
        $bill=db::Fetch('SELECT bill.*,b.checkin_date,b.checkout_date,rt.name room_type,u.name guest_name,u.email FROM billing bill JOIN bookings b ON b.id=bill.booking_id JOIN room_types rt ON rt.id=b.room_type_id JOIN users u ON u.id=b.guest_id WHERE bill.id=? AND b.guest_id=?',(int)post('billing_id'),$gid);
        if(!$bill) throw new Exception('Receipt not found.'); jsonResponse(true,'Receipt loaded.',$bill);
    }
});
?>
