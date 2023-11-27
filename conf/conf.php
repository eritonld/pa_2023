<?php
date_default_timezone_set('Asia/Jakarta');

// $base_url = 'http://localhost:8080/hcis-pa-2023';
// $base_url = 'http://172.30.1.38:8080/pa_2023/';
$base_url = 'http://localhost/pa_2023';

$db_host = 'localhost';
$db_name = 'pa_2023';
$db_user = 'root';
$db_pass = '';

$cuttOff = '2023-06-30';

try {
    $koneksi = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}
?>