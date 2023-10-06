<?php
include("conf/conf.php");
include("tabel_setting.php");
$id 			= $_GET['id'];
$superior		= $_GET['superior'];
$headsuperior	= $_GET['headsuperior'];

// $var1 	= explode("(", $nik);
// $varid = trim(str_replace(")","",$var1[1]));

// $var2 			= explode("(", $superior);
// $varsuperior 	= trim(str_replace(")","",$var2[1]));

// $var3 				= explode("(", $headsuperior);
// $varheadsuperior 	= trim(str_replace(")","",$var3[1]));

$varid 		 = $id;
$varsuperior 	 = $superior;
$varheadsuperior = $headsuperior;

try {
    // Check if a record with the specified NIK exists
    $sql = "SELECT `id` FROM $karyawan WHERE `id` = :varid";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':varid', $varid, PDO::PARAM_STR);
    $stmt->execute();
    
    $jcekkaryawan = $stmt->rowCount();

    if ($jcekkaryawan > 0) {
        // Record with NIK exists
    } else {
        // Record with NIK does not exist
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($jcekkaryawan  <> 1)
{
	$cekvalid = 0;
}
else
{
	try {
		// Check if records with the specified NIK exist and retrieve the 'pic' column from 'user_pa' table
		$sql = "SELECT `id`, (SELECT pic FROM user_pa WHERE id = input_by) AS namainput FROM $transaksi_pa WHERE `id` = :varid";
		
		$stmt = $koneksi->prepare($sql);
		$stmt->bindParam(':varid', $varid, PDO::PARAM_STR);
		$stmt->execute();
		
		$jcektrans = $stmt->rowCount();
	
		if ($jcektrans > 0) {
			$rcektrans = $stmt->fetch(PDO::FETCH_ASSOC);
			// Process the data here
		} else {
			// No records found for the specified NIK
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}	
	
	if ($jcektrans>=1)
	{
		$cekvalid = 2;
	}
	else
	{
		$cekvalid = 1;
	}
	
}
echo $cekvalid."|".$varid."|".$varsuperior."|".$varheadsuperior."|".$rcektrans['namainput'];




?>