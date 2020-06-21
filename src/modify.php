<?php
require_once ("config.php");
$connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
$path = $_POST["imagePath"];$title = $_POST["imageTitle"];$description = $_POST["imageDescription"];
$country = $_POST["country"];$city = $_POST["city"];$content = $_POST["content"];
$username = $_COOKIE["username"];
$sql = "select geocountries_regions.ISO,geocities.GeoNameID from geocountries_regions,geocities where geocountries_regions.Country_RegionName = '$country' and geocities.AsciiName = '$city'";
$result = mysqli_query($connection,$sql);
if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $countryCodeISO = $row["ISO"];
    $cityCode = $row["GeoNameID"];
    if (isset($_GET["modify"]) && $_GET["modify"] == 1) {
        $imageID = $_GET["imageID"];
        $sql = "update travelimage
            set Title = '$title',Description = '$description',Country_RegionCodeISO = '$countryCodeISO',CityCode = '$cityCode',PATH = '$path',Content = '$content'
            where ImageID = '$imageID'";
        $result = mysqli_query($connection, $sql);
        header("Refresh:0.1;url=Depository.php?page=1");
    }
    else{
        $sql = "select UID from traveluser where UserName = '$username'";
        $result = mysqli_query($connection,$sql);
        $row = mysqli_fetch_assoc($result);
        $UID = $row["UID"];
        $sql = "insert into travelimage(Title,Description,Country_RegionCodeISO,CityCode,PATH,UID,Content) values ('$title','$description','$countryCodeISO','$cityCode','$path','$UID','$content')";
        echo $sql;
        $result = mysqli_query($connection,$sql);
        header("Refresh:0.1;url=Depository.php?page=1");
    }
    if (!is_null($result) & !is_bool($result)){
        mysqli_free_result($result);
    }
}
mysqli_close($connection);