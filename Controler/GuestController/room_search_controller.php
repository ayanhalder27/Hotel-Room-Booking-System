<?php
require_once '_guest_common.php';
wrapController(function(){
    if(reqv('action','search')==='search'){
        $ci=post('checkin_date'); $co=post('checkout_date'); $guests=(int)post('num_guests','1'); validDateRange($ci,$co); if($guests<1) throw new Exception('Guest number must be valid.');
        $cap=roomCapacityColumn(); $types=db::FetchAll("SELECT id,name,description,price_per_night,$cap AS capacity,thumbnail_path,amenities FROM room_types WHERE $cap>=? ORDER BY price_per_night ASC",$guests);
        $rows=[]; $nights=nightsBetween($ci,$co);
        foreach($types as $t){ $available=availableRoomCount((int)$t['id'],$ci,$co); if($available<=0) continue; $p=seasonalPrice((int)$t['id'],$ci,$co); $t['available_rooms']=$available; $t['nightly_price']=$p['price']; $t['nights']=$nights; $t['estimated_total']=$p['price']*$nights; $t['seasonal_notice']=$p['seasonal']?($p['seasonal']['label'].' price applied'):''; $rows[]=$t; }
        jsonResponse(true,'Available room types loaded.',$rows);
    }
});
?>
