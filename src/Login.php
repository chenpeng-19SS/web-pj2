<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/login_register.css"/>
</head>
<body>
    <form name="loginForm" method="post" action="loginReg.php">
        <fieldset>
            <p><input type="text" autocomplete="off" name="username" placeholder="用户名/邮箱" pattern="^([a-zA-Z][a-zA-Z0-9]{4,})|([a-zA-Z0-9_-]{5,}@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+)$" required></p>
            <p><input type="password" autocomplete="off" name="password" placeholder="密码" pattern="^[a-zA-Z0-9_.]+$" required></p>
            <?php
            if (isset($_GET['wrong']) && $_GET['wrong'] == true){
                echo "用户名不存在或密码错误<br>";
            }
            ?>
            <input type="submit" value="登录" id="login"><br>
            <p>没有账户？立即<a href="Register.php">注册</a>！</p>
        </fieldset>
    </form>
</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>