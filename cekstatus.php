<?php
include("conf/conf.php");
include("tabel_setting.php");

$nik=$_GET['nik'];
$cekstatus=mysqli_query($koneksi,"SELECT dg.fortable,dg.Nama_Golongan FROM $karyawan as k left join daftargolongan as dg on dg.Kode_Golongan=k.Kode_Golongan where k.nik='$nik'");
$scekstatus=mysqli_fetch_array($cekstatus);

if($scekstatus['Nama_Golongan']=='Member'){
	echo "$scekstatus[Nama_Golongan]";
}else{
	echo "$scekstatus[fortable]";
}
?>