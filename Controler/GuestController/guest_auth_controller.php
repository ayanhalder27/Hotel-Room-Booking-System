<?php
require_once '_guest_common.php';
wrapController(function(){
    $action=reqv('action','register'); $idCol=userIdColumn();
    if($action==='register'){
        requiredFields(['name','email','password','phone','nationality','id_number']);
        if(!filter_var(post('email'),FILTER_VALIDATE_EMAIL)) throw new Exception('Valid email is required.');
        if((int)db::FetchValue('SELECT COUNT(*) FROM users WHERE email=?',post('email'))>0) throw new Exception('Email already registered.');
        db::Execute("INSERT INTO users (name,email,password_hash,phone,nationality,$idCol,role,is_active,created_at) VALUES (?,?,?,?,?,?, 'guest', 1, NOW())",post('name'),post('email'),password_hash(post('password'),PASSWORD_DEFAULT),post('phone'),post('nationality'),post('id_number'));
        jsonResponse(true,'Guest registered successfully.');
    }
    if($action==='login'){
        requiredFields(['email','password']);
        $u=db::Fetch("SELECT id,name,email,password_hash,role,is_active FROM users WHERE email=? AND role='guest' LIMIT 1",post('email'));
        if(!$u || (int)$u['is_active']!==1) throw new Exception('Guest account not found or inactive.');
        if(!password_verify(post('password'),$u['password_hash']) && post('password')!==$u['password_hash']) throw new Exception('Invalid password.');
        $_SESSION['user_id']=(int)$u['id']; $_SESSION['name']=$u['name']; $_SESSION['role']=$u['role'];
        jsonResponse(true,'Login successful.',['redirect'=>'dashboard.php']);
    }
});
?>
