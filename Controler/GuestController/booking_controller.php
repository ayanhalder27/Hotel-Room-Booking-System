<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','create');
    if($action==='create'){
        requiredFields(['room_type_id','checkin_date','checkout_date','num_guests']);
        $rtid=(int)post('room_type_id'); $ci=post('checkin_date'); $co=post('checkout_date'); $ng=(int)post('num_guests'); validDateRange($ci,$co);
        $cap=roomCapacityColumn(); $rt=db::Fetch("SELECT id,name,price_per_night,$cap AS capacity FROM room_types WHERE id=?",$rtid); if(!$rt) throw new Exception('Room type not found.'); if($ng>(int)$rt['capacity']) throw new Exception('Guest count exceeds room capacity.');
        if(availableRoomCount($rtid,$ci,$co)<=0) throw new Exception('No available room for selected dates.');
        $nights=nightsBetween($ci,$co); $price=seasonalPrice($rtid,$ci,$co); $total=$price['price']*$nights;
        db::BeginTransaction();
        $cols=['guest_id','room_id','room_type_id','checkin_date','checkout_date','num_guests','total_price','status']; $qs=['?','?','?','?','?','?','?','?']; $vals=[$gid,null,$rtid,$ci,$co,$ng,$total,'pending'];
        if(bookingSourceColumnExists()){ $cols[]='source'; $qs[]='?'; $vals[]='online'; }
        if(bookingSpecialRequestColumnExists()){ $cols[]='special_requests'; $qs[]='?'; $vals[]=post('special_requests'); }
        if(columnExists('bookings','created_at')){ $cols[]='created_at'; $qs[]='NOW()'; }
        db::Execute('INSERT INTO bookings ('.implode(',',$cols).') VALUES ('.implode(',',$qs).')',...$vals); $bid=db::InsertId();
        if(billingGuestColumnExists()) db::Execute("INSERT INTO billing (booking_id,guest_id,base_amount,extras_amount,discount_amount,total_amount,payment_status) VALUES (?,?,?,0,0,?,'pending')",$bid,$gid,$total,$total);
        else db::Execute("INSERT INTO billing (booking_id,base_amount,extras_amount,discount_amount,total_amount,payment_status) VALUES (?,?,0,0,?,'pending')",$bid,$total,$total);
        db::Commit(); jsonResponse(true,'Booking created successfully.',['booking_id'=>$bid,'room_type'=>$rt['name'],'checkin_date'=>$ci,'checkout_date'=>$co,'total_price'=>$total]);
    }
    if($action==='confirmation'){
        $bid=(int)reqv('booking_id','0'); if($bid<=0 || !guestOwnsBooking($bid,$gid)) throw new Exception('Booking not found.');
        $b=db::Fetch('SELECT b.id,b.checkin_date,b.checkout_date,b.num_guests,b.total_price,b.status,rt.name room_type FROM bookings b JOIN room_types rt ON rt.id=b.room_type_id WHERE b.id=? AND b.guest_id=?',$bid,$gid);
        jsonResponse(true,'Booking confirmation loaded.',$b);
    }
});
?>
