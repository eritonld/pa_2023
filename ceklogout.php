<?php 
include("conf/conf.php");
include("function.php");

//setCookieLogout('id');
//setCookieLogout('pic');
//setCookieLogout('id_admin');
//setCookieLogout('pic_admin');

setcookie('id', '', time() - 3600, '/');
setcookie('pic', '', time() - 3600, '/');
setcookie('id_admin', '', time() - 3600, '/');
setcookie('pic_admin', '', time() - 3600, '/');

header('Location: http://localhost/pa_2023/');
exit;
?>