<?php
$dbname = 'plantation-forum';
$link = mysql_connect("hrd-wip","plantation-forum","forum123") or die("Couldn't make connection.");
$db = mysql_select_db($dbname, $link) or die("Couldn't select database");
?>