<?php
include("../conf/conf.php");
include("../tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng')
{
	$tabel_prosedure="prosedure_english";
	$a1='Update Employee';
	$a2='Employee Name';
	$a3='Company';
	$a4='Employee No';
	$a5='Division/Department';
	$a6='Designation';
	$a7='Section/SubSection';
	$a8='Work Begin';
	$a9='Period of Assessment';
	$a10='Grade';
	$a11='SP/period';
	$a12='Rating';
	$a13='On Rating';
	$a14='Unit';
}
else
{	
	$tabel_prosedure="prosedure";
	$a1='Edit Karyawan';
	$a2='Nama Karyawan';
	$a3='Nama PT';
	$a4='Nomor Induk';
	$a5='Divisi/Departemen';
	$a6='Jabatan';
	$a7='Seksi/SubSeksi';
	$a8='Mulai bekerja';
	$a9='Periode Penilaian';
	$a10='Golongan';
	$a11='SP/Periode';
	$a12='Bobot';
	$a13='Pembobotan';
	$a14='Lokasi Kerja';
}
if(isset($_POST['generatekar']) && $_POST['generatekar']=='T'){
	$nik=$_POST['nik'];
	$cekkar=mysqli_query($koneksi, "select NIK from $karyawan where NIK='$nik'");
	$scekkar=mysqli_fetch_array($cekkar);

	if(isset($scekkar['NIK'])){
		?>
			<script>alert("Gagal, NIK sudah ada");</script>
		<?php
	}else{
		$nama=$_POST['nama'];
		$mulai=$_POST['mulai'];
		$dept=$_POST['dept'];
		$jabatan=$_POST['jabatan'];
		$gol=$_POST['gol'];
		$pt=$_POST['pt'];
		$unit=$_POST['unit'];
		$email=$_POST['email'];
		
		$ins=mysqli_query($koneksi, "insert into $karyawan (NIK,note_nik,Nama_Lengkap,Mulai_Bekerja,Kode_Departemen,Kode_StatusKerja,Nama_Jabatan,Kode_Golongan,Kode_Perusahaan,Kode_OU,Email) values ('$nik','tambahan_pa_2022','$nama','$mulai','$dept','','$jabatan','$gol','$pt','$unit','$email')");
		
		if($gol>'GL011'){
			$ins=mysqli_query($koneksi, "insert into user_pa (pic,username,password) values ('$nama','$nik','ec028a30c5d949fe8548cf244639584c')");
		}
		
		if($ins){
			?>
			<script>alert("Berhasil");</script>
			<?php
		}else{
			?>
			<script>alert("Gagal");</script>
			<?php
		}
	}
}
?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
<form name="forminputeos" method="post" action="">
<table class="table table-bordered">
	<tr>
		<td style="width:20%;"><?php echo"NIK";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="nik" id="nik" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a2";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="nama" id="nama" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a8";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="mulai" id="mulai" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a5";?></td>
		<td>
		<select id="dept" name="dept" class="form-control" style="width:50%;">
		  <option value="">- Pilih -</option>
		  <?php 
		  $q_datadept = mysqli_query ($koneksi, "SELECT kode_departemen, Nama_Departemen FROM `daftardepartemen` ORDER BY Nama_Departemen asc;");
		  while ($r_dept	= mysqli_fetch_array ($q_datadept))
		  {
		  ?>
			<option value="<?php echo $r_dept['kode_departemen']; ?>"><?php echo $r_dept['Nama_Departemen']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"$a6";?></td>
		<td>
			<input class="form-control" style="width:50%;" type="text" name="jabatan" id="jabatan" />
		</td> 
	</tr>
	<tr>
		<td><?php echo"$a10";?></td>
		<td>
		<select id="gol" name="gol" class="form-control" style="width:50%;">
		  <option value="">- Pilih -</option>
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_Golongan, Nama_Golongan FROM `daftargolongan` where active='T' ORDER BY Nama_Golongan asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  ?>
			<option value="<?php echo $r_gol['Kode_Golongan']; ?>" ><?php echo $r_gol['Nama_Golongan']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"$a3";?></td>
		<td>
		<select id="pt" name="pt" class="form-control" style="width:50%;">
		  <option value="">- Pilih -</option>
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_Perusahaan, Nama_Lkp_Perusahaan FROM `daftarperusahaan` where active='T' ORDER BY Nama_Lkp_Perusahaan asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  ?>
			<option value="<?php echo $r_gol['Kode_Perusahaan']; ?>" ><?php echo $r_gol['Nama_Lkp_Perusahaan']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"$a14";?></td>
		<td>
		<select id="unit" name="unit" class="form-control" style="width:50%;">
		  <option value="">- Pilih -</option>
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  ?>
			<option value="<?php echo $r_gol['Kode_OU']; ?>" ><?php echo $r_gol['Nama_OU']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"Email";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="email" id="email" /></td> 
	</tr>
	<tr>
		<td><button type="submit" name="btnsave" class="btn btn-success">Submit</button></td>
		<td><input type="hidden" name="generatekar" value="T"></td> 
	</tr>
</table>
</form>
</div>
    </div>
  </div>
</section>
</div>

<script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script src="../plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="../plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function () {
		$('#mulai').datepicker({format:'yyyy-mm-dd'});
		$('#tanggal_kembali').datepicker({format:'yyyy-mm-dd'});
	});
</script>