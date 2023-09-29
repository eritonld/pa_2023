<?php
include("conf/conf.php");
$name = $_GET[name];
$var1 	= explode("(", $name);
$varnik = trim(str_replace(")","",$var1[1]));

include("tabel_setting.php");

$qemail = mysqli_query($koneksi,"Select email from $karyawan where NIK = '$varnik'");
$remail	= mysqli_fetch_array($qemail);

echo trim($remail[email]);

?>