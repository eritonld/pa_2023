<?php
include("conf/conf.php");
include("tabel_setting.php");
$nik 			= $_GET['nik'];
$superior		= $_GET['superior'];
$headsuperior	= $_GET['headsuperior'];

// $var1 	= explode("(", $nik);
// $varnik = trim(str_replace(")","",$var1[1]));

// $var2 			= explode("(", $superior);
// $varsuperior 	= trim(str_replace(")","",$var2[1]));

// $var3 				= explode("(", $headsuperior);
// $varheadsuperior 	= trim(str_replace(")","",$var3[1]));

$varnik 		 = $nik;
$varsuperior 	 = $superior;
$varheadsuperior = $headsuperior;

$qcekkaryawan = mysqli_query($koneksi,"Select NIK from $karyawan where NIK = '$varnik'");

$jcekkaryawan = mysqli_num_rows($qcekkaryawan);

if ($jcekkaryawan  <> 1)
{
	$cekvalid = 0;
}
else
{
	$qcektrans = mysqli_query($koneksi,"Select NIK, (Select pic from user_pa where id = input_by) as namainput  from $transaksi_pa where nik = '$varnik'");
	//echo "Select NIK, (Select pic from user where id = input_by) as namainput  from $transaksi_pa where nik = '$varnik'";
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
echo $cekvalid."|".$varnik."|".$varsuperior."|".$varheadsuperior."|".$rcektrans['namainput'];




?>