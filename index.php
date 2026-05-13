<?php

include("model/db.php");

echo db::FetchValue("select count(*) from student");


?>

