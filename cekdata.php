<?php
require "conf/conf.php";
include("tabel_setting.php");
$yearnow	= Date('Y');
$cutoff		= $yearnow."-07-01";

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng'){
	$menu1="My Data";
	$menu2="Add Appraisal";
	$menu3="Change Password";
	$menu4="Logout";
	$mydata1="My Appraisal";
	$mydata2="My Subordinate (one-level) Appraisal";
	$mydata3="My Subordinate (two-level) Appraisal";
	$unitlokasi="Work Location";
	$karyawandinilai="Employee to be Assessed";
	$pilihunit="Chosee";
	$atasan1="Direct Superior";
	$atasan2="Indirect Superior";
	$pilihnama="Chosee";
	$pilihatasan="Chosee";
}else{
	$menu1="Data Saya";
	$menu2="Tambah Penilaian";
	$menu3="Ubah Password";
	$menu4="Keluar";
	$mydata1="Penilaian Saya";
	$mydata2="Nilai Bawahan Saya (1 Level)";
	$mydata3="Nilai Bawahan Saya (2 Level)";
	$unitlokasi="Unit/Lokasi Kerja";
	$karyawandinilai="Karyawan dinilai";
	$pilihunit="Pilih Unit";
	$atasan1="Atasan 1";
	$atasan2="Atasan 2";
	$pilihnama="Pilih Nama";
	$pilihatasan="Pilih Atasan";
}

if($_GET['asal']=="unit1"){ //pilih unit karyawan yang akan di nilai
$data=$_GET['dataunit'];
?>
<select id="nik" name="nik" class="form-control" onchange="statusbawahan(this.value)" required>
	<option value="" > -- <?php echo "$pilihnama"; ?> -- </option>
	<?php
	// Assuming you have already established a PDO database connection ($koneksi)

	$cekkar = $koneksi->prepare("SELECT NIK, Nama_Lengkap FROM $karyawan WHERE Kode_StatusKerja <> 'SKH05' AND Mulai_Bekerja <= :cutoff AND Kode_OU = :data ORDER BY Nama_Lengkap ASC");
	$cekkar->bindParam(':cutoff', $cutoff, PDO::PARAM_STR);
	$cekkar->bindParam(':data', $data, PDO::PARAM_STR);
	$cekkar->execute();

	while ($scekkar = $cekkar->fetch(PDO::FETCH_ASSOC)) {
		$nik = htmlspecialchars($scekkar['NIK'], ENT_QUOTES, 'UTF-8'); // Sanitize NIK if needed
		$namaLengkap = htmlspecialchars($scekkar['Nama_Lengkap'], ENT_QUOTES, 'UTF-8'); // Sanitize Name if needed
		echo "<option value=\"$nik\">$namaLengkap - $nik</option>";
	}
	?>

</select>
<?php
}else if($_GET['asal']=="unit2"){ //pilih unit atasan 1 karyawan
$data=$_GET['dataunit'];
$nik=$_GET['nik'];
try {
    $sql = "SELECT Kode_Golongan FROM $karyawan WHERE Kode_StatusKerja <> 'SKH05' AND Kode_OU = :data AND nik = :nik";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':data', $data, PDO::PARAM_STR);
    $stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
    $stmt->execute();

    $scekgol = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($scekgol) {
        // Process the data here
    } else {
        echo "No data found for the provided criteria.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<select id="superior" name="superior" class="form-control" onchange="isi_emailatasan(this.value,'emailsuperior')" required>
	<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
	<?php
	// Assuming you have already established a PDO database connection ($koneksi)

	$cekkar = $koneksi->prepare("SELECT NIK, Nama_Lengkap FROM $karyawan WHERE Kode_StatusKerja <> 'SKH05' AND Kode_OU = :data AND Kode_Golongan >= :scekgol ORDER BY Nama_Lengkap ASC");
	$cekkar->bindParam(':data', $data, PDO::PARAM_STR);
	$cekkar->bindParam(':scekgol', $scekgol['Kode_Golongan'], PDO::PARAM_STR); // Assuming $scekgol is an associative array
	$cekkar->execute();

	while ($scekkar = $cekkar->fetch(PDO::FETCH_ASSOC)) {
		$nik = htmlspecialchars($scekkar['NIK'], ENT_QUOTES, 'UTF-8'); // Sanitize NIK if needed
		$namaLengkap = htmlspecialchars($scekkar['Nama_Lengkap'], ENT_QUOTES, 'UTF-8'); // Sanitize Name if needed
		echo "<option value=\"$nik\">$namaLengkap - $nik</option>";
	}
	?>

</select>
<?php
}else if($_GET['asal']=="unit3"){ //pilih unit atasan 2 karyawan
$data=$_GET['dataunit'];
$nik=$_GET['nik'];
try {
    $sql = "SELECT Kode_Golongan FROM $karyawan WHERE Kode_StatusKerja <> 'SKH05' AND Kode_OU = :data AND nik = :nik";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':data', $data, PDO::PARAM_STR);
    $stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
    $stmt->execute();

    $scekgol = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($scekgol) {
        // Process the data here
    } else {
        echo "No data found for the provided criteria.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<select id="headsuperior" name="headsuperior" class="form-control" onchange="isi_emailatasan(this.value,'heademailsuperior')" required>
	<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
	<?php 
	try {
		$sql = "SELECT NIK, Nama_Lengkap FROM $karyawan WHERE Kode_StatusKerja <> 'SKH05' AND Kode_OU = :data AND Kode_Golongan >= :scekgol ORDER BY Nama_Lengkap ASC";
		
		$stmt = $koneksi->prepare($sql);
		$stmt->bindParam(':data', $data, PDO::PARAM_STR);
		$stmt->bindParam(':scekgol', $scekgol['Kode_Golongan'], PDO::PARAM_STR); // Assuming $scekgol is an associative array
		$stmt->execute();
	
		while ($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$nik = htmlspecialchars($scekkar['NIK'], ENT_QUOTES, 'UTF-8'); // Sanitize NIK if needed
			$namaLengkap = htmlspecialchars($scekkar['Nama_Lengkap'], ENT_QUOTES, 'UTF-8'); // Sanitize Name if needed
			echo "<option value=\"$nik\">$namaLengkap - $nik</option>";
		}
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	?>
</select>
<?php
}else if($_GET['asal']=="otomatis"){ //lempar data atasan 1 dan 2
	$nik = $_GET['nikpa'];
	try {
		// Fetch data for nik_atasan1
		$sql1 = "SELECT NIK, Nama_Lengkap, Kode_OU, Email FROM $karyawan WHERE NIK IN (SELECT nik_atasan1 FROM atasan WHERE nik = :nik)";
		$stmt1 = $koneksi->prepare($sql1);
		$stmt1->bindParam(':nik', $nik, PDO::PARAM_STR);
		$stmt1->execute();
		$scekatasan1 = $stmt1->fetch(PDO::FETCH_ASSOC);
	
		// Fetch data for nik_atasan2
		$sql2 = "SELECT NIK, Nama_Lengkap, Kode_OU, Email FROM $karyawan WHERE NIK IN (SELECT nik_atasan2 FROM atasan WHERE nik = :nik)";
		$stmt2 = $koneksi->prepare($sql2);
		$stmt2->bindParam(':nik', $nik, PDO::PARAM_STR);
		$stmt2->execute();
		$scekatasan2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	
		// Process the data here, e.g., display or use the fetched data
	
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	
	$data = array(
				'unitsuperior'    	=>  $scekatasan1['Kode_OU'],
				'superior'    		=>  $scekatasan1['NIK'],
				'superioremail'  	=>  $scekatasan1['Email'],
				'unithsuperior'    	=>  $scekatasan2['Kode_OU'],
				'headsuperior'  	=>  $scekatasan2['NIK'],
				'headsuperioremail' =>  $scekatasan2['Email'],);
	 echo json_encode($data);
}else if($_GET['asal']=="emailsuperior"){ //lempar data email superior
	$nik = $_GET['nikpa'];
	
	try {
		// Fetch data for the specified NIK
		$sql = "SELECT NIK, Nama_Lengkap, Kode_OU, Email FROM $karyawan WHERE NIK = :nik";
		$stmt = $koneksi->prepare($sql);
		$stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
		$stmt->execute();
		$scek_superior = $stmt->fetch(PDO::FETCH_ASSOC);
	
		// Process the data here, e.g., display or use the fetched data
	
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	// $data = array(
				// 'superioremail'  	=>  $scek_superior['Email'],);
	 // echo json_encode($data);
}else if($_GET['asal']=="heademailsuperior"){ //lempar data email head superior
	$nik = $_GET['nikpa'];
	
	try {
		// Fetch data for the specified NIK
		$sql = "SELECT NIK, Nama_Lengkap, Kode_OU, Email FROM $karyawan WHERE NIK = :nik";
		$stmt = $koneksi->prepare($sql);
		$stmt->bindParam(':nik', $nik, PDO::PARAM_STR);
		$stmt->execute();
		$scekatasan1 = $stmt->fetch(PDO::FETCH_ASSOC);
	
		// Process the data here, e.g., display or use the fetched data
	
	} catch (PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	// $data = array(
				// 'headsuperioremail'  	=>  $scekatasan1['Email'],);
	 // echo json_encode($data);
}
?>