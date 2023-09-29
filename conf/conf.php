<?php
date_default_timezone_set('Asia/Jakarta');

$koneksi = mysqli_connect("localhost","root","","pa_2023");
 
// Check connection Sysdev@100619
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>