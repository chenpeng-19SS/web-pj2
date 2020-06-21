<?php
require_once("config.php");
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["repassword"]) && isset($_POST["email"])){
    $username = $_POST["username"];$email = $_POST["email"];
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if ( mysqli_connect_errno() ) {
        die( mysqli_connect_error() );
    }
    $sql1 = "select * from traveluser where UserName = '$username'";
    $result1 = mysqli_query($connection,$sql1);
    $sql2 = "select * from traveluser where Email = '$email'";
    $result2 = mysqli_query($connection,$sql2);
    if ($result1->num_rows > 0 && $result2->num_rows > 0){
        header("Refresh:0.1;url=Register.php?repeated=repeatedUserName");
        if (!is_null($result1) & !is_bool($result1)){
            mysqli_free_result($result1);
        }
        if (!is_null($result2) & !is_bool($result2)){
            mysqli_free_result($result2);
        }
    }
    elseif ($result1->num_rows > 0){
        header("Refresh:0.1;url=Register.php?repeated=repeatedUserName");
        if (!is_null($result1) & !is_bool($result1)){
            mysqli_free_result($result1);
        }
    }
    elseif ($result2->num_rows > 0){
        header("Refresh:0.1;url=Register.php?repeated=repeatedEmail");
        if (!is_null($result2) & !is_bool($result2)){
            mysqli_free_result($result2);
        }
    }
    else{
        $pass = do_hash($_POST["password"]);
        $dateJoined = date("Y-m-d H:i:s");
        $sql = "insert into traveluser set UserName = '$username',Pass = '$pass',DateJoined = '$dateJoined',Email='$email',State=1";
        $result = mysqli_query($connection,$sql);
        header( "Refresh:0.1;url=Login.php");
    }
    mysqli_close($connection);
}
else
    header("Refresh:0.1;url=Register.php");