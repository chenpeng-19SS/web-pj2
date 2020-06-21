<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/search.css">
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
    <!--搜索栏-->
    <div class="searchSection">
        <p class="headText">搜索</p>
        <form action="Search.php?page=1" method="post" name="searchForm">
            <input type="radio" value="searchByTitle" name="searchMethod">&nbsp;按标题搜索<br>
            <input type="text" name="searchTitle" autocomplete="off"><br>
            <input type="radio" value="searchByDescription" name="searchMethod">&nbsp;按描述搜索<br>
            <input type="text" name="searchDescription" autocomplete="off"><br>
            <input type="submit" id="filterBtn" value="搜索">
        </form>
    </div>
    <!--展示结果-->
    <div class="resultSection">
        <p class="headText">搜索结果</p>
        <?php
            require_once ("config.php");
            search();
        ?>
    </div>
</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>
<?php
function search(){
    session_start();
    if (isset($_POST["searchMethod"]) && $searchMethod = $_POST["searchMethod"]) {
        if ($searchMethod == "searchByTitle" && isset($_POST["searchTitle"]) && ($title = trim($_POST["searchTitle"]))) {
            $vagueTitle = "%$title%";
            $sql = "select * from travelimage where Title like '$vagueTitle'";
            getResult($sql);
        } elseif ($searchMethod == "searchByDescription" && isset($_POST["searchDescription"]) && ($description = trim($_POST["searchDescription"]))) {
            $vagueDescription = "%$description%";
            $sql = "select * from travelimage where Description like '$vagueDescription'";
            getResult($sql);
        }
    }
    elseif (isset($_SESSION["imgCount"]) && isset($_GET["page"]) && $page = $_GET["page"]){
        $imgArray = array();$imgCount = $_SESSION["imgCount"];
        for ($a = 0;$a < $imgCount;$a++){
            $imgArray[] = $_SESSION["imgArray[$a]"];
        }
        draw($imgArray);
    }
    else
        echo "<strong>请输入搜索条件</strong>";
}
function getResult($sql){
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    $result = mysqli_query($connection,$sql);
    if ($result !== null) {
        $imgArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $imgArray[] = "<div class='result'>".
                "<a href='Details.php?id=" . $row["ImageID"] . "'><img src='../travel-images/square-medium/" . $row["PATH"] . "' class='resultElement resultImage' alt='图片已丢失'></a>".
                "<div class='resultElement'>".
                    "<h2 class='resultTitle'>". $row["Title"] ."</h2>".
                    "<span class='resultDescription'>". ($row["Description"] !== null ? $row["Description"] : "No Description") ."</span>".
                "</div></div>";
        }
        $_SESSION["imgCount"] = count($imgArray);
        for ($a = 0;$a < count($imgArray);$a++){
            $_SESSION["imgArray[$a]"]=$imgArray[$a];
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
        echo "<strong>没有符合条件的图片</strong>";
    }
    elseif (isset($_GET["page"]) && $page = $_GET["page"]){
        for ($i = 0;$i < min(12,count($imgArray) - 12 * ($page - 1));$i++){
            echo $imgArray[12 * ($page - 1) + $i];
        }
        $previous = $page + $pages;
        echo "<div class='pageFooter'>" . "<a href='Search.php?page=" . ($previous % ($pages + 1) + $pages * floor(($pages + 1) / $previous))
            . "'>《</a>" . "&nbsp;&nbsp;&nbsp;";
        for ($p = 1;$p <= $pages;$p++){
            if($p == $page)
                echo "<span class='currentPageFooter'>$p</span>&nbsp;&nbsp;&nbsp;";
            else
                echo "<a href='Search.php?page=$p'>$p</a>&nbsp;&nbsp;&nbsp;";
        }
        $next = $page + 1;
        echo "<a href='Search.php?page=" . ($next % ($pages + 1) + floor($next / ($pages + 1))) . "'>》</a>";
    }
}
?>