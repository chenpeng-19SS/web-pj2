<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>图片详情</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/details.css">
    <link rel="stylesheet" type="text/css" href="../css/navigation.css">
</head>
<body>
    <h1>
    <!--logo导向主页-->
    <a href="../index.php" id="logo"><img width="53" height="53" src="../images/logo.jpeg" alt="logo"></a>
    <!--navigation类用于内联布局,jump类存放超链接实现跳转-->
    <div class="navigation">
        <div class="jump" id="home">
            <a href="../index.php">主页</a>
        </div>
    </div>
    <div class="navigation">
        <div class="jump" id="browse">
            <a href="Browse.php">浏览页</a>
        </div>
    </div>
    <div class="navigation">
        <div class="jump" id="search">
            <a href="Search.php">搜索页</a>
        </div>
    </div>
    <div class="navigation">
        <div class="account">
            <script src = "../js/controlWrap.js"></script>
        </div>
    </div>
</h1>
    <section class="mainSection">
        <p class="headText">图片详情</p>
        <?php
        require_once("config.php");
        getInfo();
        ?>
    </section>
</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>
<?php
    function getInfo(){
        if (isset($_GET["id"]) && $id = $_GET["id"]){
            $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
            $sql = "select * from travelimage where ImageID = '$id'";
            $resultOfImage = mysqli_query($connection,$sql);
            $rowOfImage = mysqli_fetch_assoc($resultOfImage);
            $authorID = $rowOfImage["UID"];
            $sql = "select UserName from traveluser where UID = '$authorID'";
            $resultOfAuthor = mysqli_query($connection,$sql);
            $rowOfPhotographer = mysqli_fetch_assoc($resultOfAuthor);
            echo "<h2>" . $rowOfImage["Title"] . " <span class='photographer'>by ". $rowOfPhotographer["UserName"] . "</span></h2>";
            $path = $rowOfImage["PATH"];
            echo "<img src='../travel-images/square-medium/$path' class='detailsImg' alt='图片'>";
            $sql = "select count(*) as count from travelimagefavor where ImageID = '$id'";
            $resultOfImageFavor = mysqli_query($connection,$sql);
            $rowOfImageFavor = mysqli_fetch_assoc($resultOfImageFavor);
            echo "<div class='informationSection'>".
                "<div class='favorNumberSection'>".
                "<p class='headText'>收藏数量</p>".
                "<p class='favorNumber'>". $rowOfImageFavor["count"] . "</p>".
                "</div>";
            $countryCodeISO = $rowOfImage["Country_RegionCodeISO"];
            $sql = "select * from geocountries_regions where ISO = '$countryCodeISO'";
            $resultOfCountry = mysqli_query($connection,$sql);
            if ($resultOfCountry !== null)
                $rowOfCountry = mysqli_fetch_assoc($resultOfCountry);
            $cityCode = $rowOfImage["CityCode"];
            $sql = "select * from geocities where GeoNameID = '$cityCode'";
            $resultOfCity = mysqli_query($connection,$sql);
            if ($resultOfCity !== null)
                $rowOfCity = mysqli_fetch_assoc($resultOfCity);
            echo "<div class='imageDetails'>".
                "<p class='headText'>图片信息</p>".
                "<p class='filter'>主题：" . (isset($rowOfImage) && $rowOfImage["Content"] !== null ? $rowOfImage["Content"] : "Unknown") . "</p>".
                "<p class='filter'>国家：" . (isset($rowOfCountry) && $rowOfCountry["Country_RegionName"] !== null ? $rowOfCountry["Country_RegionName"] : "Unknown") . "</p>".
                "<p class='filter'>城市：" . (isset($rowOfCity) && $rowOfCity["AsciiName"] !== null ? $rowOfCity["AsciiName"] : "Unknown") . "</p>".
                "</div>";
            if (isset($_COOKIE["username"])){
                $username = $_COOKIE["username"];
                $sql = "select * from traveluser where UserName = '$username'";
                $result = mysqli_query($connection,$sql);
                $rowOfUser = mysqli_fetch_assoc($result);
                $favored = getFavored();
                echo "<a href='switchFavor.php?imageID=" . $id . "&UID=" . $rowOfUser["UID"] . ($favored ? "&favored=1" : "") . "'>".
                    "<button id='favorBtn'>" . ($favored ? "取消" : "") . "收藏</button></a>";
                if (!is_null($result) & !is_bool($result)){
                    mysqli_free_result($result);
                }
            }
            else{
                echo "<a href='Login.php'><button id='favorBtn'>收藏</button></a>";
            }
            echo "</div>".
                  "<div class='descriptionSection'>" .
                ($rowOfImage["Description"] != null ? $rowOfImage["Description"] : "No Description")
                  . "</div>";
            if (!is_null($resultOfImage) & !is_bool($resultOfImage)){
                mysqli_free_result($resultOfImage);
            }
            if (!is_null($resultOfImageFavor) & !is_bool($resultOfImageFavor)){
                mysqli_free_result($resultOfImageFavor);
            }
            if (!is_null($resultOfAuthor) & !is_bool($resultOfAuthor)){
                mysqli_free_result($resultOfAuthor);
            }
            if (!is_null($resultOfCountry) & !is_bool($resultOfCountry)){
                mysqli_free_result($resultOfCountry);
            }
            if (!is_null($resultOfCity) & !is_bool($resultOfCity)){
                mysqli_free_result($resultOfCity);
            }
            mysqli_close($connection);
        }
        else{
            echo "<h2>山清水秀&nbsp;&nbsp;<span class=\"photographer\">by bth</span></h2>".
        "<img src='../images/exhibition.jpeg' class='detailsImg' alt='图片'>".
        "<div class='informationSection'>".
            "<div class='favorNumberSection'>".
                "<p class='headText'>收藏数量</p>".
                "<p class='favorNumber'>99</p>".
            "</div>".
            "<div class='imageDetails'>".
                "<p class='headText'>图片信息</p>".
                "<p class='filter'>主题：风景</p>".
                "<p class='filter'>国家：中国</p>".
                "<p class='filter'>城市：上海</p>".
            "</div>".
        "</div>".
        "<div class='descriptionSection'>".
                "Welcome to my photo website. This is the details of this photo.".
        "</div>";
        }
    }
    function getFavored(){
        $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
        $username = $_COOKIE["username"];$id = $_GET["id"];
        $sql = "select travelimagefavor.ImageID from travelimagefavor,traveluser where traveluser.UserName = '$username'" .
            " and travelimagefavor.ImageID = '$id' and travelimagefavor.UID = traveluser.UID";
        $result = mysqli_query($connection,$sql);
        if ($result->num_rows > 0){
            if (!is_null($result) & !is_bool($result)){
                mysqli_free_result($result);
            }
            mysqli_close($connection);
            return true;
        }
        else{
            if (!is_null($result) & !is_bool($result)){
                mysqli_free_result($result);
            }
            mysqli_close($connection);
            return false;
        }
    }
?>