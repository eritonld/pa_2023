<?php
include("conf/conf.php");

$username	= mysqli_real_escape_string($koneksi, $_POST['username']);
$password	= mysqli_real_escape_string($koneksi, $_POST['password']);

$pengacak="HJBDSUYGQ783242BHJSSDFSD";

$q_cek 	= mysqli_query ($koneksi,"Select * from user_pa where username = '$username' or nik_baru = '$username'");
$r_cek	= mysqli_fetch_array ($q_cek);

if(isset($r_cek['password'])){
	if (md5($pengacak . md5($password) . $pengacak) == $r_cek['password'] && $r_cek['active']=='Y')
	{	
		session_start();
		$_SESSION['idmaster_pa'] = $r_cek['id'];
		
		$datetime			= Date('Y-m-d H:i:s');
		$update = mysqli_query($koneksi,"update user_pa set lastip = '".$_SERVER['REMOTE_ADDR']."',lastlogin='$datetime' where id =$r_cek[id] ");
		
		
		if ($update){
			echo "1";
		}
		else
		{
			echo "0";
		}
	}
	else
	{
		echo "0";
	}
}else{
	echo "0";
}
?>