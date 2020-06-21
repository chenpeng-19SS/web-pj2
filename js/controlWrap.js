function control(){
    if (document.cookie.indexOf("username") > -1)
        document.write("<span class=\"accountText\">我的</span>\n<div class=\"account_wrap\"><ul>"+
            "<li><a href=\"Upload.php\"><img width=\"15\" height=\"15\" src=\"../images/uploadLogo.jpeg\" alt=\"上传\">&nbsp;上传</a></li>" +
            "<li><a href=\"Depository.php?page=1\"><img width=\"15\" height=\"15\" src=\"../images/depositoryLogo.jpeg\" alt=\"我的照片\">&nbsp;我的照片</a></li>" +
            "<li><a href=\"Favor.php?page=1\"><img width=\"15\" height=\"15\" src=\"../images/favorLogo.jpeg\" alt=\"收藏\">&nbsp;我的收藏</a></li>" +
            "<li><a href=\"logout.php\"><img width=\"15\" height=\"15\" src=\"../images/loginLogo.jpeg\" alt=\"登出\">&nbsp;登出</a></li>" +
            "</ul> </div>");
    else
        document.write("<a href=\"Login.php\"><span class=\"accountText\">登录</span></a>");
    document.close();
}
control();