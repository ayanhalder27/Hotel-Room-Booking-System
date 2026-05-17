<?php
require_once '_guest_common.php';
wrapController(function(){
    if(reqv('action','details')==='details'){
        $id=(int)reqv('room_type_id',reqv('id','0')); if($id<=0) throw new Exception('Room type is required.'); $cap=roomCapacityColumn();
        $type=db::Fetch("SELECT id,name,description,price_per_night,$cap AS capacity,thumbnail_path,amenities FROM room_types WHERE id=?",$id); if(!$type) throw new Exception('Room type not found.');
        $ratings=db::Fetch("SELECT ROUND(AVG(overall_rating),1) overall,ROUND(AVG(cleanliness_rating),1) cleanliness,ROUND(AVG(service_rating),1) service,COUNT(*) total_reviews FROM reviews r JOIN bookings b ON b.id=r.booking_id WHERE b.room_type_id=?",$id);
        $reviews=db::FetchAll("SELECT r.overall_rating,r.cleanliness_rating,r.service_rating,r.review_text,r.admin_reply,r.created_at,u.name guest_name FROM reviews r JOIN users u ON u.id=r.guest_id JOIN bookings b ON b.id=r.booking_id WHERE b.room_type_id=? ORDER BY r.id DESC LIMIT 10",$id);
        $seasonal=db::FetchAll('SELECT label,start_date,end_date,price_per_night FROM seasonal_pricing WHERE room_type_id=? ORDER BY start_date ASC',$id);
        jsonResponse(true,'Room details loaded.',['room_type'=>$type,'ratings'=>$ratings,'reviews'=>$reviews,'seasonal_pricing'=>$seasonal]);
    }
});
?>
