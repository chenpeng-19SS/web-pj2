<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <title>上传</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/navigation.css">
    <link rel="stylesheet" type="text/css" href="../css/upload.css">
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
            <span class="accountText">我的</span>
            <!--account_wrap在CSS中设置为默认隐藏,列表布局-->
            <div class="account_wrap">
                <ul>
                    <li><a href="Login.php"><img width="15" height="15" src="../images/loginLogo.jpeg" alt="登录">&nbsp;登录</a></li>
                    <li><a href="Upload.php"><img width="15" height="15" src="../images/uploadLogo.jpeg" alt="上传">&nbsp;上传</a></li>
                    <li><a href="Depository.php"><img width="15" height="15" src="../images/depositoryLogo.jpeg" alt="库">&nbsp;库</a></li>
                    <li><a href="Favor.php"><img width="15" height="15" src="../images/favorLogo.jpeg" alt="收藏">&nbsp;收藏</a></li>
                </ul>
            </div>
        </div>
    </div>
</h1>
    <section class="mainSection">
        <?php
        if (isset($_GET["modify"]) && $_GET["modify"] == 1){
            echo "<p class='headText'>修改图片</p>".
            "<form name='uploadImageForm' id='uploadImageForm' method='post' action='modify.php?imageID=". $_GET["imageID"] ."&modify=1'>";
        }
        else{
            echo "<p class='headText'>上传图片</p>".
            "<form name='uploadImageForm' id='uploadImageForm' method='post' action='modify.php'>";
        }
        ?>
            <div class="uploadImage">
                <div class="imageArea">
                    <?php
                    require_once ("config.php");
                    $connection = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME);
                    if (isset($_GET["imageID"]) && ($id = $_GET["imageID"]) && isset($_GET["modify"]) && $_GET["modify"] == 1){
                        $sql = "select * from travelimage where ImageID = '$id'";
                        $result = mysqli_query($connection,$sql);
                        $row = mysqli_fetch_assoc($result);
                        echo "<img id='uploadedImage' src='../travel-images/square-medium/" . $row["PATH"] ."' alt=''>";
                        if (!is_null($result) & !is_bool($result)){
                            mysqli_free_result($result);
                        }
                    }
                    else{
                        echo "<img id='uploadedImage' alt='' src=''>".
                             "<div id='noImageText'>图片未上传</div>";
                    }
                    ?>
                </div>
                <label id="upload">
                    <input type="button" id="uploadBtn"  value="上传">
                    <input type='file' id='file' name='imagePath' onchange='changePic(this)' accept='image/jpg,image/jpeg,image/png,image/PNG' required>
                </label>
            </div>
            <?php
            if (isset($_GET["imageID"]) && ($id = $_GET["imageID"]) && isset($_GET["modify"]) && $_GET["modify"] == 1) {
                $sql = "select * from travelimage where ImageID = '$id'";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($result);
                echo "<h4>图片标题：</h4>".
                    "<input type='text' name='imageTitle' id='imageTitle' value='". $row["Title"] ."' autocomplete='off' required>".
                    "<h4>图片描述：</h4>".
                    "<textarea type='text' name='imageDescription' id='imageDescription' autocomplete='off' required>". (!is_null($row["Description"])?$row["Description"]:"No Description") ."</textarea>";
            }
            else{
                echo "<h4>图片标题：</h4>".
                    "<input type='text' name='imageTitle' id='imageTitle' autocomplete='off' required>".
                    "<h4>图片描述：</h4>".
                    "<textarea type='text' name='imageDescription' id='imageDescription' autocomplete='off' required></textarea>";
            }
            ?>
            <div class="chooses">
                <h4>主题：</h4>
                <select class="choose" name="content" id="chooseContent" required>
                    <option value="" disabled selected hidden>选择主题</option>
                    <option value="scenery">风景</option>
                    <option value="city">城市</option>
                    <option value="people">人物</option>
                    <option value="animal">动物</option>
                    <option value="building">建筑</option>
                    <option value="wonder">奇观</option>
                    <option value="other">其他</option>
                </select>
                <h4>地区：</h4>
                <select class="choose" name="country" id="filterByCountry" onchange="changeSelect()" required>
                <option value="" disabled selected hidden>选择地区</option>
                <?php
                $sql = "select Country_RegionName from geocountries_regions order by Country_RegionName";
                $result = mysqli_query($connection,$sql);
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<option value='". $row["Country_RegionName"] ."'>" . $row["Country_RegionName"] ."</option>";
                }
                ?>
                </select>
                <h4>城市：</h4>
                <select class="choose" name="city" id="filterByCity" required>
                <option value="" disabled selected hidden>选择城市</option>
                <?php
                $sql = "select geocities.AsciiName,geocountries_regions.Country_RegionName,count(*) as count from geocities,geocountries_regions,travelimage
                where geocities.Country_RegionCodeISO = geocountries_regions.ISO and travelimage.CityCode = geocities.GeoNameID group by geocities.GeoNameID order by count desc";
                $result = mysqli_query($connection,$sql);
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<option value='" . $row["AsciiName"] . "' name='" . $row["Country_RegionName"] . "'>" . $row["AsciiName"] . "</option>";
                }
                if (!is_null($result) & !is_bool($result)){
                    mysqli_free_result($result);
                }
                mysqli_close($connection);
                ?>
                </select><br>
            </div>
            <input type="submit" name="submit">
        </form>
    </section>
    <script src="../js/upload.js"></script>
    <script src="../js/filterLink.js"></script>

</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>