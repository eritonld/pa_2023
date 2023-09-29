<?php
include("../conf/conf.php");

$username	= mysqli_real_escape_string($koneksi, $_GET['username']);
$password	= mysqli_real_escape_string($koneksi, $_GET['password']);

$pengacak="HJBDSUYGQ783242BHJSSDFSD";

$q_cek 	= mysqli_query ($koneksi, "Select * from user_pa_admin where username = '$username'");
$r_cek	= mysqli_fetch_array ($q_cek);

if(isset($r_cek['password'])){
	if (md5($pengacak . md5($password) . $pengacak) == $r_cek['password'] && $r_cek['active']=='Y')
	{	
		session_start();
		$_SESSION['idmaster_pa_admin']=$r_cek['id'];
		
		$datetime			= Date('Y-m-d H:i:s');
		$update = mysqli_query($koneksi, "update user_pa_admin set lastip = '".$_SERVER['REMOTE_ADDR']."',lastlogin='$datetime' where id =$r_cek[id] ");
		
		if ($update){
			echo "1";
		}
		else{
			echo "0";
		}
	}
	else
	{
		echo "0";
	}
}
?>