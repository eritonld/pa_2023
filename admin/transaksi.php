<?php
include("../conf/conf.php");
include("../tabel_setting.php");

$kode 		= $_GET['kode'];
$date		= Date('Y-m-d');
$datetime	= Date('Y-m-d H:i:s');

if($kode == 'hapuskaryawan'){
	$id = $_GET['id'];
	mysqli_query($koneksi,"update $karyawan set Kode_StatusKerja='SKH05' where NIK='$id'");	
}
?>