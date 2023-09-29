<?php
include("conf/conf.php");

$yearnow	= Date('Y');
$data=$_GET['dataunit'];

?>
<select id="nik" name="nik" style="width:30%" class="form-control" required>
	<option value="" > -- Pilih Karyawan -- </option>
	<?php 
	$cekkar = mysqli_query ($koneksi,"SELECT k.NIK, k.Nama_Lengkap, k.Kode_StatusKerja, dd.Nama_Departemen FROM karyawan as k
	left join daftardepartemen as dd on dd.Kode_Departemen=k.Kode_Departemen
	where k.Kode_StatusKerja<>'SKH05' and k.Kode_OU='$data' order by k.Nama_Lengkap asc");
	while ($scekkar	= mysqli_fetch_array ($cekkar))
	{
	?>
		<option value="<?php echo $scekkar['NIK']; ?>"><?php echo "$scekkar[Nama_Lengkap] - $scekkar[Nama_Departemen]"; ?></option>
	<?php
	}
	?>
</select>
