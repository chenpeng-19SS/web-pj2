<?php
require_once("config.php");
if (isset($_POST["username"]) && isset($_POST["password"])){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if ( mysqli_connect_errno() ) {
        die( mysqli_connect_error() );
    }
    $sql1 = "select * from traveluser where UserName = '$username'";
    $sql2 = "select * from traveluser where Email = '$username'";
    $result1 = mysqli_query($connection,$sql1);
    $result2 = mysqli_query($connection,$sql2);
    if($result1->num_rows > 0){
        $row = mysqli_fetch_assoc($result1);
        if (do_hash($password) == $row["Pass"]){
            $dateLastModified = date("Y-m-d H:i:s");
            $sql = "update traveluser set DateLastModified = '$dateLastModified' where UserName = '$username'";
            mysqli_query($connection,$sql);
            $expiryTime = time() + 60*24*24;
            setcookie("username",$username,$expiryTime,"/","localhost");
            header("Refresh:0.1;url=../index.php");
        }
        else{
            header("Refresh:0.1;url=Login.php?wrong=true");
        }
        if (!is_null($result1) & !is_bool($result1)){
            mysqli_free_result($result1);
        }
    }
    elseif ($result2->num_rows > 0){
        $row = mysqli_fetch_assoc($result2);
        if (do_hash($password) == $row["Pass"]){
            $dateLastModified = date("Y-m-d H:i:s");
            $sql = "update traveluser set DateLastModified = '$dateLastModified' where Email = '$username'";
            mysqli_query($connection,$sql);
            $expiryTime = time() + 60*24*24;
            $username = $row["UserName"];
            setcookie("username",$username,$expiryTime,"/","localhost");
            header("Refresh:0.1;url=../index.php");
        }
        else{
            header("Refresh:0.1;url=Login.php?wrong=true");
        }
        if (!is_null($result2) & !is_bool($result2)){
            mysqli_free_result($result2);
        }
    }
    else{
        header("Refresh:0.1;url=Login.php?wrong=true");
    }
    mysqli_close($connection);
}
else
    header("Refresh:0.1;ur=Login.php");