<?php
include("conf/conf.php");
include("tabel_setting.php");

$varid 		 = $_GET['id'];

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

if ($jcekkaryawan != 1)
{
	$cekvalid = 0;
}
else
{
	try {
		// Check if records with the specified NIK exist and retrieve the 'pic' column from 'user_pa' table
		$sql = "SELECT `id`, (SELECT pic FROM user_pa WHERE `id` = created_by) AS inputby FROM $transaksi_pa WHERE `idkar` = :varid";
		
		$stmt = $koneksi->prepare($sql);
		$stmt->bindParam(':varid', $varid, PDO::PARAM_STR);
		$stmt->execute();
		
		$jcektrans = $stmt->rowCount();
		$rcektrans = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$inputby = $rcektrans ? $rcektrans['inputby']:"";
	
		if ($jcektrans > 0) {
			$cekvalid = 2;
			// Process the data here
		} else {
			$cekvalid = 1;
			// No records found for the specified NIK
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}	
	
}
$result = array(
    'cekvalid' => $cekvalid,
    'varid' => $varid,
    'inputby' => $inputby,
);

echo json_encode($result);





?>