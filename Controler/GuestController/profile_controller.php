<?php
require_once '_guest_common.php';
wrapController(function(){
    $gid=currentGuestId(); $action=reqv('action','get'); $idCol=userIdColumn();
    if($action==='get'){
        $u=db::Fetch("SELECT id,name,email,phone,nationality,$idCol AS id_number,profile_pic,is_active,created_at FROM users WHERE id=? AND role='guest'",$gid); if(!$u) throw new Exception('Profile not found.');
        $u['loyalty_balance']=(int)db::FetchValue('SELECT COALESCE(balance,0) FROM loyalty_points WHERE guest_id=? ORDER BY id DESC LIMIT 1',$gid);
        jsonResponse(true,'Profile loaded.',$u);
    }
    if($action==='update'){
        requiredFields(['name','phone','nationality','id_number']);
        db::Execute("UPDATE users SET name=?,phone=?,nationality=?,$idCol=? WHERE id=? AND role='guest'",post('name'),post('phone'),post('nationality'),post('id_number'),$gid);
        $_SESSION['name']=post('name'); jsonResponse(true,'Profile updated successfully.');
    }
    if($action==='change_password'){
        requiredFields(['current_password','new_password']); $u=db::Fetch('SELECT password_hash FROM users WHERE id=? AND role=\'guest\'',$gid); if(!$u) throw new Exception('User not found.');
        if(!password_verify(post('current_password'),$u['password_hash']) && post('current_password')!==$u['password_hash']) throw new Exception('Current password is incorrect.'); if(strlen(post('new_password'))<6) throw new Exception('New password must be at least 6 characters.');
        db::Execute('UPDATE users SET password_hash=? WHERE id=?',password_hash(post('new_password'),PASSWORD_DEFAULT),$gid); jsonResponse(true,'Password changed successfully.');
    }
    if($action==='upload_profile_pic'){
        if(!isset($_FILES['profile_pic']) || $_FILES['profile_pic']['error']!==UPLOAD_ERR_OK) throw new Exception('Profile picture is required.');
        $allowed=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp']; $mime=mime_content_type($_FILES['profile_pic']['tmp_name']); if(!isset($allowed[$mime])) throw new Exception('Only JPG, PNG, or WEBP images are allowed.');
        $dir=__DIR__.'/../../Resources/uploads/guest_profiles'; if(!is_dir($dir)) mkdir($dir,0777,true); $name='guest_'.$gid.'_'.time().'.'.$allowed[$mime];
        if(!move_uploaded_file($_FILES['profile_pic']['tmp_name'],$dir.'/'.$name)) throw new Exception('Failed to upload profile picture.');
        $path='Resources/uploads/guest_profiles/'.$name; db::Execute('UPDATE users SET profile_pic=? WHERE id=?',$path,$gid); jsonResponse(true,'Profile picture uploaded.',['profile_pic'=>$path]);
    }
});
?>
