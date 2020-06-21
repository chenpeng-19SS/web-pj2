<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <title>主页</title>
    <link rel="stylesheet" type="text/css" href="css/reset.css">
    <link rel="stylesheet" type="text/css" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/navigation.css">
</head>
<body>
    <h1>
            <a href="index.php" id="logo"><img width="53" height="53" src="images/logo.jpeg" alt="logo"></a>
            <div class="navigation">
                <div class="jump" id="home">
                    <a href="index.php">主页</a>
                </div>
            </div>
            <div class="navigation">
                <div class="jump" id="browse">
                    <a href="src/Browse.php">浏览页</a>
                </div>
            </div>
            <div class="navigation">
                <div class="jump" id="search">
                    <a href="src/Search.php">搜索页</a>
                </div>
            </div>
            <div class="navigation">
                <div class="account">
                    <script src = js/controlWrapForHome.js></script>
                </div>
            </div>
    </h1>
    <!--设置一个100%展示的大图-->
    <img src="images/exhibition.jpeg" class="exhibitionImg">
    <!--示例小图的展示区域类-->
    <div class="examplesSection">
        <!--示例类,内有图片区域类（包含一个图片超链接）,描述类-->
    <?php
    require_once("src/config.php");
    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
    if (isset($_GET["refreshed"]) && $_GET["refreshed"] == true){
        $sql = "select distinct ImageID from travelimagefavor order by RAND() limit 8";
    }
    else {
        $sql = "select ImageID, count(*) as count from travelimagefavor group by ImageID order by count limit 8";
    }
        $result1 = mysqli_query($connection, $sql);
        while ($rowOfFavor = mysqli_fetch_assoc($result1)) {
            $imgID = $rowOfFavor["ImageID"];
            $sql = "select Description,PATH,Title,ImageID from travelimage where ImageID = '$imgID'";
            $result2 = mysqli_query($connection, $sql);
            $rowOfImage = mysqli_fetch_assoc($result2);
            $description = $rowOfImage["Description"] !== null ? $rowOfImage["Description"] : "No Description";
            echo "<div class=\"example\">".
                    "<div class=\"imgArea\">".
                    "<a href='src/Details.php?id=" . $rowOfImage["ImageID"] . "'><img src=travel-images/square-medium/" . $rowOfImage["PATH"] . " class=\"exImage\" alt='图片已丢失'></a>".
                    "</div>".
                    "<h2>" . $rowOfImage["Title"] . "</h2>".
                    "<span class=\"description\">" . $description . "</span>".
                    "</div>";
        }
    if (!is_null($result2) & !is_bool($result2)){
        mysqli_free_result($result2);
    }
    if (!is_null($result1) & !is_bool($result1)){
        mysqli_free_result($result1);
    }
        mysqli_close($connection);
    ?>
        <script src="js/helpingIcon.js"></script>
    </div>
    <!--用边栏存放辅助按钮-->
    <aside>
        <!--通过与backup()绑定onclick实现返回顶部-->
        <div id="backupBtn" onclick="backup()"><img width="50" height="50" src="images/icons/totop.jpg"></div>
        <!--刷新按钮指向refresh.php再重定向回index.php?refreshed=true-->
        <div id="refreshBtn"><a href="src/refresh.php"><img width="50" height="50" src="images/icons/reload.jpg"></a></div>
    </aside>
</body>
<footer>
    <div class="col">
        <p><a>使用条款  隐私保护  Cookie</a></p>
    </div>
    <div class="col">
        <p><a>关于  联系我们</a></p>
    </div>
    <div class="col">
        <div>
            <img src="images/icons/wechat.png" width="40px">
            <img src="images/icons/ins.png" width="40px">
            <img src="images/icons/qq.png" width="40px">
            <img src="images/icons/github.png" width="40px">
        </div>
    </div>
    <div class="col">
        <img src="images/icons/wechat2DCode%20.jpg" width="100px">
    </div>
    <div class="copyright">
        <p><a>Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</a></p>
    </div>
</footer>
</html>