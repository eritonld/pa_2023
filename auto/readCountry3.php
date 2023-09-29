<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_POST["keyword"])) {

$var1 	= explode("(",$_POST["nikemp"]);
$varnik = trim(str_replace(")","",$var1[1]));

include("../tabel_setting.php");

$query ="SELECT * FROM $karyawan WHERE Nama_Lengkap like '%" . $_POST["keyword"] . "%' and 
Kode_Golongan >= (select Kode_Golongan from $karyawan where NIK='$varnik') ORDER BY LENGTH(Nama_Lengkap) ASC, Nama_Lengkap ASC  LIMIT 0,25";
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectCountry3('<?php echo $country["Nama_Lengkap"]. " (".$country["NIK"].")"; ?>');"><?php echo $country["Nama_Lengkap"]. " (".$country["NIK"].")"; ?></li>
<?php } ?>
</ul>
<?php } } ?>