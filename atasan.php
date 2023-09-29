<?php 
$qatasan	= mysqli_query ($koneksi,"Select * from atasan where nik =  '$nik'");
$jatasan	= mysqli_num_rows($qatasan);

if ($jatasan < 1)
{
	$h_ins = "insert into atasan (nik, nik_atasan1, nik_atasan2, lastupdate, edit_by) values ('$nik', '$atasan1', '$atasan2', now(), '$idmaster_pa')";	
}
else
{
	$h_ins = "update atasan set  nik_atasan1='$atasan1', nik_atasan2 = '$atasan2', lastupdate = now(), edit_by='$idmaster_pa' where nik = '$nik'";
} 

$q_ins	= mysqli_query($koneksi,$h_ins);

$upd=mysqli_query($koneksi,"update $karyawan set Email='$emailatasan1' where nik='$atasan1'");
$upd=mysqli_query($koneksi,"update $karyawan set Email='$emailatasan2' where nik='$atasan2'");
?>