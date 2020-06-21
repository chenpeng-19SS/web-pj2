<?php
require_once ("config.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
if (isset($_GET["imageID"])){
    $imageID = $_GET["imageID"];
    $username = $_COOKIE["username"];
    $sql = "select UID from traveluser where UserName = '$username'";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_assoc($result);
    $UID = $row["UID"];
    if (isset($_GET["favored"]) && $_GET["favored"] == 1){
        $sql = "delete from travelimagefavor where ImageID = '$imageID' and UID = '$UID'";
        $result = mysqli_query($connection,$sql);
        if ($result !== null)
            echo "success";
        else
            echo "fail";
    }
    else{
        $sql = "insert into travelimagefavor (ImageID,UID) values ('$imageID','$UID')";
        $result = mysqli_query($connection,$sql);
    }
    if (!is_null($result) & !is_bool($result)){
        mysqli_free_result($result);
    }
    if (strpos($_SERVER["HTTP_REFERER"],"Details.php") !== false)
       header("Refresh:0.1;url=Details.php?id=$imageID");
    elseif (strpos($_SERVER["HTTP_REFERER"],"Favor.php") !== false)
        header("Refresh:0.1;url=Favor.php");
}