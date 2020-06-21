<!DOCTYPE html>
<html lang="ch">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <link rel="stylesheet" type="text/css" href="../css/login_register.css"/>
</head>
<body>
    <form name="registerForm" method="post" action="registerReg.php">
        <fieldset>
            <p><input type="text" autocomplete="off" id="username" name="username" placeholder="昵称(至少5位字母数字下划线组合,以字母开头)" pattern="^[a-zA-Z][a-zA-Z0-9]{4,}$" required></p>
            <p><input type="password" autocomplete="off" id="pword" name="password" placeholder="密码(至少6位)" pattern="^[a-zA-Z0-9_.]{6,}$" required></p>
            <span id = "notice1"></span>
            <p><input type="password" autocomplete="off" id="repword" name="repassword" placeholder="确认密码" required></p>
            <span id = "notice2"></span>
            <p><input type="text" autocomplete="off" id = 'email' name="email" placeholder="邮箱" pattern="^[a-zA-Z0-9_-]{5,}@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$" required></p>
            <?php
            if (isset($_GET["repeated"]) && $_GET["repeated"] !== ""){
                switch ($_GET["repeated"]){
                    case "repeatedUserName" : echo "用户名重复<br>";break;
                    case "repeatedEmail" : echo "该邮箱已注册<br>";break;
                }
            }
            ?>
            <input type="submit" value="注册" name="register" id="register"><br>
            <p>已有账户？立即<a href="Login.php">登录</a>！</p>
        </fieldset>
    </form>
<script>
    let password = document.getElementById("pword"), repassword = document.getElementById("repword");
    repassword.onkeyup = function () {
        if (repassword.value !== password.value){
            document.getElementById("notice2").innerText = "两次密码不一致";
            document.getElementById("register").disabled = true;
        }
        else{
            document.getElementById("notice2").innerText = "";
            if (checkSafety(password.value))
            document.getElementById("register").disabled = false;
        }
    }
    password.onkeyup = function () {
        //安全级数2级以下不能提交
        if (checkSafety(password.value) < 4){
            document.getElementById("notice1").innerText = "密码太弱";
            document.getElementById("register").disabled = true;
        }
        else{
            document.getElementById("notice1").innerText = "";
            if (repassword.value === password.value)
            document.getElementById("register").disabled = false;
        }
    }
    //返回安全级数
    function checkSafety(pwd) {
        let n = 0;
        if (/\d/.test(pwd))
            n++;
        if (/[a-zA-Z]/.test(pwd))
            n++;
        if (/[_.]/.test(pwd))
            n++;
        if (pwd.length >= 6)
            n += 2;
        return n;
    }
</script>
</body>
<footer>
    <span class="copyrightText">Copyright © 2019-2020 SOFT130002 Project2. All Rights Reserved. 备案号：19302010028@fudan.edu.cn</span>
</footer>
</html>