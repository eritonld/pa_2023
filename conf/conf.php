<?php
date_default_timezone_set('Asia/Jakarta');

$db_host = 'localhost';
$db_name = 'pa_2023';
$db_user = 'root';
$db_pass = '';

try {
    $koneksi = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}
?>