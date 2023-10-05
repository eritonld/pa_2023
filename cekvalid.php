<?php
include("conf/conf.php");
include("tabel_setting.php");
$nik 			= $_GET['nik'];
$id_atasan1			= $_GET['id_atasan1'];
$email_atasan1		= $_GET['email_atasan1'];
$id_atasan2			= $_GET['id_atasan2'];
$email_atasan2		= $_GET['email_atasan2'];
$id_atasan3			= $_GET['id_atasan3'];
$email_atasan3		= $_GET['email_atasan3'];

$qcekkaryawan = mysqli_query($koneksi,"Select NIK from $karyawan where NIK = '$nik'");

$jcekkaryawan = mysqli_num_rows($qcekkaryawan);

if ($jcekkaryawan  <> 1)
{
	$cekvalid = 0;
}
else
{
	$qcektrans = mysqli_query($koneksi,"Select NIK, (Select pic from user_pa where id = input_by) as namainput  from $transaksi_pa where nik = '$nik'");

	$rcektrans = mysqli_fetch_array($qcektrans);
	$jcektrans = mysqli_num_rows($qcektrans);	
	
	if ($jcektrans>=1)
	{
		$cekvalid = 2;
	}
	else
	{
		$cekvalid = 1;
	}
	
}
echo $cekvalid."|".$nik."|".$id_atasan1."|".$email_atasan1."|".$id_atasan2."|".$email_atasan2."|".$id_atasan3."|".$email_atasan3."|".$rcektrans['namainput'];




?>