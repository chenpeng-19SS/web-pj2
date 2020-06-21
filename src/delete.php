<?php
require_once ("config.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if (isset($_GET["imageID"])){
    $imageID = $_GET["imageID"];
    $sql = "delete from travelimage where ImageID = '$imageID'";
    $result = mysqli_query($connection,$sql);
    if (!is_null($result) & !is_bool($result)){
        mysqli_free_result($result);
    }
    header("Refresh:0.1;url=Depository.php?page=1");
}
else
    header("Refresh:0.1;url=Depository.php?page=1");
mysqli_close($connection);