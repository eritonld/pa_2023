<link rel="stylesheet" href="../plugins/select2/multiple-select.css"/>
<link href="../plugins/select2/select2-4.0.6-rc.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../plugins/select2/multiple-select-master/multiple-select.css"/>


<style type="text/css">
	.select2-container--default .select2-selection--single{
    background-color: #FFFFCC;
	text-align: center;
}
</style>
<?php
include("../conf/conf.php");
include("../tabel_setting.php");

// session_start();
// if(session_is_registered('idmaster_hc'))
// {
	// $user_tes=unserialize($_SESSION['idmaster_hc']);
	// $idmaster=$user_tes['mas'];
// }

$id = $_POST['id']!=''?$_POST['id']:$_GET['id'];

if($_POST['kode']=='update_superior'){
	if($id<>'') {
		$sql = "SELECT di.idkar, k.id, k.NIK, k.Nama_Lengkap, k.Email, k.Kode_OU as Kode_Unit, kk.NIK as nik1, kk.Nama_Lengkap as nama1, kk.Email as email1, kk.Kode_OU as lokasi1, kkk.NIK as nik2, kkk.Nama_Lengkap as nama2, kkk.Email as email2, kkk.Kode_OU as lokasi2, kkkk.NIK as nik3, kkkk.Nama_Lengkap as nama3, kkkk.Email as email3, kkkk.Kode_OU as lokasi3 FROM $karyawan  as k 
		left join atasan as di on di.idkar=k.id
		left join $karyawan as kk on kk.id=di.id_atasan1
		left join daftarou as dd on dd.Kode_OU=kk.Kode_OU
		left join $karyawan as kkk on kkk.id=di.id_atasan2 
		left join daftarou as ddd on ddd.Kode_OU=kkk.Kode_OU 
		left join $karyawan as kkkk on kkkk.id=di.id_atasan3 
		left join daftarou as dddd on dddd.Kode_OU=kkkk.Kode_OU 
		where k.id='$id'";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();
		
		$scekkaryawan = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if($scekkaryawan['nik1']<>''){
				$lokasi1="$scekkaryawan[lokasi1]";
				$nik1="$scekkaryawan[nik1]";
				$email1="$scekkaryawan[email1]";
			}else{
				$lokasi1="";
				$nik1="";
				$email1="";
			}
			
			if($scekkaryawan['nik2']<>''){
				$lokasi2="$scekkaryawan[lokasi2]";
				$nik2="$scekkaryawan[nik2]";
				$email2="$scekkaryawan[email2]";
			}else{
				$lokasi2="";
				$nik2="";
				$email2="";
			}
			
			if($scekkaryawan['nik3']<>''){
				$lokasi3="$scekkaryawan[lokasi3]";
				$nik3="$scekkaryawan[nik3]";
				$email3="$scekkaryawan[email3]";
			}else{
				$lokasi3="";
				$nik3="";
				$email3="";
			}
	?>
	<form role="form" method="post" action="">
		<input type="hidden" class="form-control" name="idkar" id="idkar" value="<?php echo "$id"; ?>">
		<div class="form-group">
			<label>Nama</label>
			<input type="text" class="form-control" name="nama_p" id="nama_p" style="width:50%" value="<?php echo $scekkaryawan['Nama_Lengkap']; ?>" placeholder="Masukkan Nama..." readonly>
		</div>
		<div class="form-group">
		  <table>
		  <tr>
		   <td style="width:25%"><label>Unit/Lokasi Kerja</label></td><td style="width:1%"></td>
		   <td style="width:35%"><label>Atasan 1</label></td><td style="width:1%"></td>
		   <td style="width:40%; display:none"><label>Email</label></td>
		  </tr>
		  <tr>
		  <td>
			<select id="kode_ou1" name="kode_ou1" class="form-control" onchange="cmdtampildata(this.value,'unit1')" required>
				<option value="" > -- Pilih Unit -- </option>
			  <?php 
			  $sql = "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekunit = $stmt->fetch(PDO::FETCH_ASSOC)){
			  $selected="";
			  if($scekkaryawan['lokasi1']==$scekunit['Kode_OU']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekunit['Kode_OU']; ?>" <?php echo $selected; ?>><?php echo "$scekunit[Nama_OU]"; ?></option>
			  <?php
			  }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td>
			<select id="ida1" name="ida1" class="form-control" onchange="isi_atasan1()" required>
				<option value="" > -- Pilih -- </option>
			  <?php 
			  if($nik1<>''){
			  $sql = "SELECT id,NIK, Nama_Lengkap FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$scekkaryawan[lokasi1]' and Kode_Golongan>'$scekkaryawan[approval1]' ORDER BY Nama_Lengkap asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekkar1 = $stmt->fetch(PDO::FETCH_ASSOC)){
			  $selected="";
			  if($scekkaryawan['nik1']==$scekkar1['NIK']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekkar1['id']; ?>" <?php echo $selected; ?>><?php echo "$scekkar1[Nama_Lengkap] ($scekkar1[NIK])"; ?></option>
			  <?php
			  } }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td style="display:none">
			<input type="text" class="form-control" id ="email1" name="email1" value="<?php echo $scekkaryawan['email1']; ?>" placeholder="Email Atasan 1" readonly>
		  </td>
		  </tr></table>
		</div>
		<div class="form-group">
		  <table>
		  <tr>
		   <td style="width:25%"><label>Unit/Lokasi Kerja</label></td><td style="width:1%"></td>
		   <td style="width:35%"><label>Atasan 2</label></td><td style="width:1%"></td>
		   <td style="width:40%; display:none"><label>Email</label></td>
		  </tr>
		  <tr>
		  <td>
			<select id="kode_ou2" name="kode_ou2" class="form-control" onchange="cmdtampildata(this.value,'unit2')" required>
				<option value="" > -- Pilih Unit -- </option>
			  <?php 
			  $sql = "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekunit = $stmt->fetch(PDO::FETCH_ASSOC)){
			  $selected="";
			  if($scekkaryawan['lokasi2']==$scekunit['Kode_OU']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekunit['Kode_OU']; ?>" <?php echo $selected; ?>><?php echo "$scekunit[Nama_OU]"; ?></option>
			  <?php
			  }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td>
			<select id="ida2" name="ida2" class="form-control" onchange="isi_atasan2()" required>
				<option value="" > -- Pilih -- </option>
			  <?php 
			  if($nik1<>''){
			  $sql = "SELECT id,NIK, Nama_Lengkap FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$scekkaryawan[lokasi2]' and Kode_Golongan>'$scekkaryawan[approval2]' ORDER BY Nama_Lengkap asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)){
			   $selected="";
			  if($scekkaryawan['nik2']==$scekkar['NIK']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekkar['id']; ?>" <?php echo $selected; ?>><?php echo "$scekkar[Nama_Lengkap] ($scekkar[NIK])"; ?></option>
			  <?php
			  } }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td style="display:none">
			<input type="text" class="form-control" id ="email2" name="email2" value="<?php echo $scekkaryawan['email2']; ?>" placeholder="Email Atasan 2" readonly>
		  </td>
		  </tr></table>
		</div>
		
		<div class="form-group">
		  <table>
		  <tr>
		   <td style="width:25%"><label>Unit/Lokasi Kerja</label></td><td style="width:1%"></td>
		   <td style="width:35%"><label>Atasan 3</label></td><td style="width:1%"></td>
		   <td style="width:40%; display:none"><label>Email</label></td>
		  </tr>
		  <tr>
		  <td>
			<select id="kode_ou3" name="kode_ou3" class="form-control" onchange="cmdtampildata(this.value,'unit3')" required>
				<option value="" > -- Pilih Unit -- </option>
			  <?php 
			  $sql = "SELECT Kode_OU, Nama_OU FROM `daftarou` where aktif='T' ORDER BY Nama_OU asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekunit = $stmt->fetch(PDO::FETCH_ASSOC)){
			  $selected="";
			  if($scekkaryawan['lokasi3']==$scekunit['Kode_OU']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekunit['Kode_OU']; ?>" <?php echo $selected; ?>><?php echo "$scekunit[Nama_OU]"; ?></option>
			  <?php
			  }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td>
			<select id="ida3" name="ida3" class="form-control" onchange="isi_atasan3()" required>
				<option value="" > -- Pilih -- </option>
			  <?php 
			  if($nik1<>''){
			  $sql = "SELECT id,NIK, Nama_Lengkap FROM $karyawan where Kode_StatusKerja<>'SKH05' and Kode_OU='$scekkaryawan[lokasi3]' and Kode_Golongan>'$scekkaryawan[approval3]' ORDER BY Nama_Lengkap asc";
			  $stmt = $koneksi->prepare($sql);
			  $stmt->execute();
				
			  while($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)){
			  $selected="";
			  if($scekkaryawan['nik3']==$scekkar['NIK']){$selected="selected";}
			  ?>
				<option value="<?php echo $scekkar['id']; ?>" <?php echo $selected; ?>><?php echo "$scekkar[Nama_Lengkap] ($scekkar[NIK])"; ?></option>
			  <?php
			  } }
			  ?>
			</select>
		  </td><td style="width:1%"></td>
		  <td style="display:none">
			<input type="text" class="form-control" id ="email3" name="email3" value="<?php echo $scekkaryawan['email3']; ?>" placeholder="Email Atasan 3" readonly>
		  </td>
		  
		  </tr></table>
		</div>
		<div class="box-footer">
			<input type="hidden" name="update_superior" value="T" />
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		  </div>
	</form>
	<?php  
	}
}else if($_GET['asal']=="email1"){ //lempar data email superior
	$ida1 = $_GET['ida1'];
	
	$sql = "SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM karyawan where id='$ida1'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
	
    $scekatasan1 = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$data = array(
				'email1'  	=>  $scekatasan1['Email'],);
	 echo json_encode($data);
}else if($_GET['asal']=="email2"){ //lempar data email superior
	$ida2 = $_GET['ida2'];
	
	$sql = "SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM karyawan where id='$ida2'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
	
    $scekatasan2 = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$data = array(
				'email2'  	=>  $scekatasan2['Email'],);
	 echo json_encode($data);
}else if($_GET['asal']=="email3"){ //lempar data email superior
	$ida3 = $_GET['ida3'];
	
	$sql = "SELECT NIK,Nama_Lengkap, Kode_OU, Email FROM karyawan where id='$ida3'";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
	
    $scekatasan3 = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$data = array(
				'email3'  	=>  $scekatasan3['Email'],);
	 echo json_encode($data);
}
?>
 <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
 <script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
 <!-- <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script> -->
 <script src="../plugins/select2/select2-4.0.6-rc.1/dist/js/select2.min.js"></script>
 <script src="../plugins/select2/multiple-select-master/multiple-select.js" type="text/javascript"></script>
   
 <script>
  $(document).ready(function(){
	$('#unitCompany').multipleSelect({
	placeholder: "select company",
	filter:true,
	});
  });
  $(document).ready(function(){
	$('#unitCompanyupdate').multipleSelect({
	placeholder: "select company",
	filter:true,
	});
  });
</script>
