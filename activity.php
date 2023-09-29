<?php
$qinsertact	= mysqli_query ($koneksi,"insert into activity (iduser, nik, activity, date, ip) values ($iduseract, '$nikpa', '$activity', now(), '".$_SERVER['REMOTE_ADDR']."')");
//test
?>