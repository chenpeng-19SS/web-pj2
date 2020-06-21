<?php
require_once ("config.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$sql = "select count(*) as count from travelimagefavor where ImageID = 1";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($result);
echo ceil(null == false);
?>