<?php
include("conf/conf.php");

include("tabel_setting.php");

$nik = $_GET['nik'];
$email1="";
$email2="";
$nama1="";
$nama2="";
$getatasan=mysqli_query($koneksi,"select nik_atasan1,nik_atasan2 from atasan where nik='$nik'");
$cgetatasan=mysqli_fetch_array($getatasan);


$qemail1 = mysqli_query($koneksi,"Select NIK,Nama_Lengkap,Email from $karyawan where NIK = '$cgetatasan[nik_atasan1]'");
$remail1	= mysqli_fetch_array($qemail1);
if($remail1['NIK']<>'')
{
	$nama1=$remail1['Nama_Lengkap'].' ('.$remail1['NIK'].')';
}
if($remail1['Email']<>'')
{
	$email1=$remail1['Email'];
}

$qemail2 = mysql_query("Select NIK,Nama_Lengkap,Email from $karyawan where NIK = '$cgetatasan[nik_atasan2]'");
$remail2	= mysql_fetch_array($qemail2);
if($remail2['NIK']<>'')
{
	$nama2=$remail2['Nama_Lengkap'].' ('.$remail2['NIK'].')';
}
if($remail2['Email']<>'')
{
	$email2=$remail2['Email'];
}

echo trim($nama1).'|'.trim($email1).'>'.trim($nama2).'|'.trim($email2);

?>