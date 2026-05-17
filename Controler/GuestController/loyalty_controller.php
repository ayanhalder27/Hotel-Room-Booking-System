<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','summary');
    if($action==='summary'){
        $balance=(int)db::FetchValue('SELECT COALESCE(balance,0) FROM loyalty_points WHERE guest_id=? ORDER BY id DESC LIMIT 1',$gid);
        $history=db::FetchAll('SELECT lp.*,b.checkin_date,b.checkout_date,rt.name room_type FROM loyalty_points lp LEFT JOIN bookings b ON b.id=lp.booking_id LEFT JOIN room_types rt ON rt.id=b.room_type_id WHERE lp.guest_id=? ORDER BY lp.id DESC',$gid);
        jsonResponse(true,'Loyalty data loaded.',['balance'=>$balance,'history'=>$history,'rate_note'=>'Suggested rule: 1 point = 1 currency unit discount.']);
    }
    if($action==='redeem_preview'){
        $points=(int)post('points'); $balance=(int)db::FetchValue('SELECT COALESCE(balance,0) FROM loyalty_points WHERE guest_id=? ORDER BY id DESC LIMIT 1',$gid);
        if($points<=0) throw new Exception('Enter points to redeem.'); if($points>$balance) throw new Exception('Not enough loyalty points.');
        jsonResponse(true,'Redeem preview ready.',['points'=>$points,'discount'=>$points,'balance_after'=>$balance-$points]);
    }
});
?>
