<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>我的照片</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/depository.css">
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
    <div class="mySection">
    <p class="headText">我的照片</p>
    <?php
    require_once ("config.php");
    getWorks();
    ?>
</div>
</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>
<?php
function getWorks(){
    if (isset($_COOKIE["username"]) && $username = $_COOKIE["username"]){
        $sql = "select travelimage.* from travelimage,traveluser where traveluser.UserName = '$username' and travelimage.UID = traveluser.UID";
        getResult($sql);
    }
    else
        header("Refresh:0.1;url=Login.php");
}
function getResult($sql){
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $result = mysqli_query($connection,$sql);
    if ($result !== null) {
        $imgArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $imgArray[] = "<div class='myWork'>".
                "<a href='Details.php?id=" . $row["ImageID"] . "'><img src='../travel-images/square-medium/" . $row["PATH"] . "' class='workElement myImg' alt='图片已丢失'></a>".
                "<div class='workElement'>".
                    "<h2 class='workTitle'>". $row["Title"] ."</h2>".
                    "<span class='workDescription'>". ($row["Description"] !== null ? $row["Description"] : "No Description") ."</span>".
                    "<a href='Upload.php?imageID=". $row["ImageID"] ."&modify=1'><button class='modifyBtn'>修改</button></a>".
                    "<a href='delete.php?imageID=". $row["ImageID"] ."'><button class='deleteBtn'>删除</button></a>".
                "</div></div>";
        }
        draw($imgArray);
    }
    if (!is_null($result) & !is_bool($result)){
        mysqli_free_result($result);
    }
    mysqli_close($connection);
}
function draw($imgArray){
    $pages = min(ceil(count($imgArray) / 12), 5);
    if ($imgArray == null){
        echo "<strong>没有图片</strong>";
    }
    elseif (isset($_GET["page"]) && $page = $_GET["page"]){
        for ($i = 0;$i < min(12,count($imgArray) - 12 * ($page - 1));$i++){
            echo $imgArray[12 * ($page - 1) + $i];
        }
        $previous = $page + $pages;
        echo "<div class='pageFooter'>" . "<a href='Depository.php?page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous))
            . "'>《</a>" . "&nbsp;&nbsp;&nbsp;";
        for ($p = 1;$p <= $pages;$p++){
            if($p == $page)
                echo "<span class='currentPageFooter'>$p</span>&nbsp;&nbsp;&nbsp;";
            else
                echo "<a href='Depository.php?page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
        }
        $next = $page + 1;
        echo "<a href='Depository.php?page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>》</a>";
    }
    else
        header("Refresh:0.1;url=Depository.php?page=1");
}
?>