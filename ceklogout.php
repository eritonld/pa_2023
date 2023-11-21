<?php 
include("conf/conf.php");
include("function.php");

setCookieLogout('id');
setCookieLogout('pic');
setCookieLogout('id_admin');
setCookieLogout('pic_admin');

header('Location: '.$base_url);

?>