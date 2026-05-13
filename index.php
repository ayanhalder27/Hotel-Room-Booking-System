<?php

include("model/db.php");

$data = db::Fetch("Select * from student where id=?", 3);
if($data)
    echo $data["name"]."<br>";


?>

