<?php
require_once("dbcontroller.php");
$db_handle = new DBController();



if(!empty($_POST["keyword"])) {


	$query ="SELECT * FROM $karyawan WHERE Nama_Lengkap like '%" . $_POST["keyword"] . "%' ORDER BY LENGTH(Nama_Lengkap) ASC LIMIT 0,15";

	
$result = $db_handle->runQuery($query);
if(!empty($result)) {
?>
<ul id="country-list">
<?php
foreach($result as $country) {
?>
<li onClick="selectCountry('<?php echo $country["Nama_Lengkap"]. " (".$country["NIK"].")"; ?>');"><?php echo $country["Nama_Lengkap"]. " (".$country["NIK"].")"; ?></li>
<?php } ?>
</ul>
<?php } } ?>