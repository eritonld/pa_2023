<?php
echo "test di read";
require_once("dbcontroller.php");
$db_handle = new DBController();
session_start();
if(session_is_registered('idmaster_pa'))
{
	$user_pa=unserialize($_SESSION[idmaster_pa]);
	$idmaster_pa=$user_pa[mas];
}
include("../tabel_setting.php");

$qcekgrademaster 	= mysql_query("select k.Kode_Golongan from user u left join $karyawan k on u.username = k.NIK where u.id =$idmaster_pa");
$rcekgrademaster	= mysql_fetch_array($qcekgrademaster);

if(!empty($_POST["keyword"])) {
if ($idmaster_pa==1||$idmaster_pa==2)
{
	$query ="SELECT * FROM $karyawan WHERE Nama_Lengkap like '%" . $_POST["keyword"] . "%' ORDER BY LENGTH(Nama_Lengkap) ASC LIMIT 0,25";
	echo "SELECT * FROM $karyawan WHERE Nama_Lengkap like '%" . $_POST["keyword"] . "%' ORDER BY LENGTH(Nama_Lengkap) ASC LIMIT 0,25";
}
else
{
	$query ="SELECT * FROM $karyawan WHERE Nama_Lengkap like '%" . $_POST["keyword"] . "%' and Kode_Golongan <= '$rcekgrademaster[Kode_Golongan]' ORDER BY LENGTH(Nama_Lengkap) LIMIT 0,25";
}	
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
<?php } }else {echo "error";} ?>