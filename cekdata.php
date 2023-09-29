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
	$cekkar = mysqli_query ($koneksi,"SELECT NIK, Nama_Lengkap, Kode_StatusKerja FROM $karyawan where Kode_StatusKerja<>'SKH05' and Mulai_Bekerja <= '$cutoff' and Kode_OU='$data' order by Nama_Lengkap asc");
	while ($scekkar	= mysqli_fetch_array ($cekkar))
	{
	?>
		<option value="<?php echo $scekkar['NIK']; ?>"><?php echo "$scekkar[Nama_Lengkap] - $scekkar[NIK]"; ?></option>
	<?php
	}
	?>
</select>
<?php
}else if($_GET['asal']=="unit2"){ //pilih unit atasan 1 karyawan
$data=$_GET['dataunit'];
$nik=$_GET['nik'];
$cekgol = mysqli_query ($koneksi,"SELECT Kode_Golongan FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$data' and nik='$nik'");
$scekgol = mysqli_fetch_array($cekgol);
?>
<select id="superior" name="superior" class="form-control" onchange="isi_emailatasan(this.value,'emailsuperior')" required>
	<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
	<?php 
	$cekkar = mysqli_query ($koneksi,"SELECT NIK, Nama_Lengkap, Kode_StatusKerja FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$data' and Kode_Golongan>='$scekgol[Kode_Golongan]' order by Nama_Lengkap asc");
	while ($scekkar	= mysqli_fetch_array ($cekkar))
	{
	?>
		<option value="<?php echo $scekkar['NIK']; ?>"><?php echo "$scekkar[Nama_Lengkap] - $scekkar[NIK]"; ?></option>
	<?php
	}
	?>
</select>
<?php
}else if($_GET['asal']=="unit3"){ //pilih unit atasan 2 karyawan
$data=$_GET['dataunit'];
$nik=$_GET['nik'];
$cekgol = mysqli_query ($koneksi,"SELECT Kode_Golongan FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$data' and nik='$nik'");
$scekgol = mysqli_fetch_array($cekgol);
?>
<select id="headsuperior" name="headsuperior" class="form-control" onchange="isi_emailatasan(this.value,'heademailsuperior')" required>
	<option value="" > -- <?php echo "$pilihatasan"; ?> -- </option>
	<?php 
	$cekkar = mysqli_query ($koneksi,"SELECT NIK, Nama_Lengkap, Kode_StatusKerja FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$data' and Kode_Golongan>='$scekgol[Kode_Golongan]' order by Nama_Lengkap asc");
	while ($scekkar	= mysqli_fetch_array ($cekkar))
	{
	?>
		<option value="<?php echo $scekkar['NIK']; ?>"><?php echo "$scekkar[Nama_Lengkap] - $scekkar[NIK]"; ?></option>
	<?php
	}
	?>
</select>
<?php
}else if($_GET['asal']=="otomatis"){ //lempar data atasan 1 dan 2
	$nik = $_GET['nikpa'];
	$cekatasan = mysqli_query($koneksi,"select nik_atasan1,nik_atasan2 from atasan where nik='$nik'");
	$scekatasan = mysqli_fetch_array($cekatasan);
	
	$cekatasan1 = mysqli_query($koneksi,"SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM $karyawan where NIK='$scekatasan[nik_atasan1]'");
	$scekatasan1 = mysqli_fetch_array($cekatasan1);
	
	$cekatasan2 = mysqli_query($koneksi,"SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM $karyawan where NIK='$scekatasan[nik_atasan2]'");
	$scekatasan2 = mysqli_fetch_array($cekatasan2);
	
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
	
	$cek_superior = mysqli_query($koneksi,"SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM $karyawan where NIK='$nik'");
	$scek_superior = mysqli_fetch_array($cek_superior);
	echo $scek_superior['Email'];
	// $data = array(
				// 'superioremail'  	=>  $scek_superior['Email'],);
	 // echo json_encode($data);
}else if($_GET['asal']=="heademailsuperior"){ //lempar data email head superior
	$nik = $_GET['nikpa'];
	
	$cekatasan1 = mysqli_query($koneksi,"SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM $karyawan where NIK='$nik'");
	$scekatasan1 = mysqli_fetch_array($cekatasan1);
	echo $scekatasan1['Email'];
	// $data = array(
				// 'headsuperioremail'  	=>  $scekatasan1['Email'],);
	 // echo json_encode($data);
}
?>