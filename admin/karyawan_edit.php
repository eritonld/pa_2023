<?php
include("../conf/conf.php");
include("../tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if(isset($_GET['nik'])){
	$nik=$_GET['nik'];
}else{
	$nik="";
}
if($nik=='')
{?>
	<script language="JavaScript">
		alert('Dilarang Refresh/Masukan NIK');
		document.location='home.php?link=dashboard';
	</script>
<?php	
exit;
}
$karyawanx=mysqli_query($koneksi, "select k.*,dp.Nama_Perusahaan,dep.Nama_Departemen,
dg.Nama_Golongan,k.Nama_Jabatan,du.Nama_OU from $karyawan as k
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
left join daftarou as du on k.Kode_OU=du.Kode_OU
where k.NIK='$nik'");
$ckaryawan=mysqli_fetch_array($karyawanx);

$cekuser=mysqli_query($koneksi, "select * from user_pa where username='$nik'");
$scekuser=mysqli_fetch_array($cekuser);

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
?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
<form name="forminputeos" method="post" action="?link=dataemp">
<table class="table table-bordered">
	<tr>
		<td style="width:20%;"><?php echo"NIK";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="nik" id="nik" value="<?php echo"$ckaryawan[NIK]";?>" readonly /></td> 
	</tr>
	<tr>
		<td><?php echo"$a2";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="nama" id="nama" value="<?php echo"$ckaryawan[Nama_Lengkap]";?>" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a8";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="mulai" id="mulai" value="<?php echo"$ckaryawan[Mulai_Bekerja]";?>" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a5";?></td>
		<td>
		<select id="dept" name="dept" class="form-control" style="width:50%;">
		  <?php 
		  $q_datadept = mysqli_query ($koneksi, "SELECT kode_departemen, Nama_Departemen FROM `daftardepartemen` ORDER BY Nama_Departemen asc;");
		  while ($r_dept	= mysqli_fetch_array ($q_datadept))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Departemen']==$r_dept['kode_departemen']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_dept['kode_departemen']; ?>" <?php echo $selected; ?>><?php echo $r_dept['Nama_Departemen']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"$a6";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="jabatan" id="jabatan" value="<?php echo"$ckaryawan[Nama_Jabatan]";?>" /></td> 
	</tr>
	<tr>
		<td><?php echo"$a10";?></td>
		<td>
		<select id="gol" name="gol" class="form-control" style="width:50%;">
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_Golongan, Nama_Golongan FROM `daftargolongan` where active='T' ORDER BY Nama_Golongan asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Golongan']==$r_gol['Kode_Golongan']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_Golongan']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_Golongan']; ?></option>
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
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_Perusahaan, Nama_Lkp_Perusahaan FROM `daftarperusahaan` where active='T' ORDER BY Nama_Lkp_Perusahaan asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  $selected="";
		  if($ckaryawan['Kode_Perusahaan']==$r_gol['Kode_Perusahaan']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_Perusahaan']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_Lkp_Perusahaan']; ?></option>
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
		  <?php 
		  $q_datagol = mysqli_query ($koneksi, "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc;");
		  while ($r_gol	= mysqli_fetch_array ($q_datagol))
		  {
		  $selected="";
		  if($ckaryawan['Kode_OU']==$r_gol['Kode_OU']){$selected="selected";}
		  ?>
			<option value="<?php echo $r_gol['Kode_OU']; ?>" <?php echo $selected; ?>><?php echo $r_gol['Nama_OU']; ?></option>
		  <?php
		  }
		  ?>
		</select>
		</td> 
	</tr>
	<tr>
		<td><?php echo"Email";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="email" id="email" value="<?php echo"$ckaryawan[Email]";?>" /></td> 
	</tr>
	<?php if($ckaryawan['Kode_Golongan']>='GL012'){?>
	<tr>
		<td><?php echo"Username";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="username" id="username" value="<?php echo"$scekuser[username]";?>" readonly /></td> 
	</tr>
	<tr>
		<td><?php echo"Password";?></td>
		<td><input class="form-control" style="width:50%;" type="text" name="password" id="password" value="<?php echo"$scekuser[password]";?>" /> 12345678 = ec028a30c5d949fe8548cf244639584c</td> 
	</tr>
	<?php } ?>
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