<?php
include("../conf/conf.php");

// Replace these with your database credentials
// $username = mysqli_real_escape_string($koneksi, $_GET['username']);
// $password = mysqli_real_escape_string($koneksi, $_GET['password']);
$username = $_GET['username'];
$password = $_GET['password'];

$pengacak="HJBDSUYGQ783242BHJSSDFSD";

try {

    $stmt = $koneksi->prepare("SELECT * FROM user_pa_admin WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $r_cek = $stmt->fetch(PDO::FETCH_ASSOC);

	$hashedPassword = md5($pengacak . md5($password) . $pengacak);

	if ($hashedPassword == $r_cek['password'] && $r_cek['active'] == 'Y') {
		session_start();
		$_SESSION['idmaster_pa_admin'] = $r_cek['id'];

		$datetime = date('Y-m-d H:i:s');
		$stmt = $koneksi->prepare("UPDATE user_pa_admin SET lastip = :remote_addr, lastlogin = :datetime WHERE id = :id");
		$stmt->bindParam(':remote_addr', $_SERVER['REMOTE_ADDR']);
		$stmt->bindParam(':datetime', $datetime);
		$stmt->bindParam(':id', $r_cek['id']);
		$update = $stmt->execute();

		if ($update) {
			echo "1";
		} else {
			echo "0";
		}
	} else {
		echo "0";
	}
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}


?>