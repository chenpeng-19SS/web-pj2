<?php
define('DBHOST', 'localhost');
define('DBNAME', 'new-travel');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBCONNSTRING', 'mysql:host=localhost;dbname=new-travel');

//加盐后用md5散列
function do_hash($pwd) {
    $salt = '1rha2Md4g3te';
    return md5($pwd.$salt);
}

?>