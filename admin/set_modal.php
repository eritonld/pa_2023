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

$id = $_POST['id']!=''?$_POST['id']:$_GET['id'];

if($_POST['kode']=='update_superior'){
	if($id<>'') {
		$jml_layer = 1;
		
		$sql_cek_nama = "select Nama_Lengkap from $karyawan where id='$id'";
		$ssql_cek_nama = $koneksi->prepare($sql_cek_nama);
		$ssql_cek_nama->execute();
		$scek_nama = $ssql_cek_nama->fetch(PDO::FETCH_ASSOC);
		
		$sql = "SELECT ats.idkar, k.Nama_Lengkap, ats.layer, ats.id_atasan, kk.Nama_Lengkap as nama_atasan FROM `atasan` as ats 
		left join $karyawan as k on k.id=ats.idkar
		left join $karyawan as kk on kk.id=ats.id_atasan
		where ats.idkar in ('$id') ";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();
		
		$cek_total_layer = $stmt->rowCount();
		$cek_total_layer = $cek_total_layer+3;
	?>
	<form role="form" method="post" action="">
		<input type="hidden" class="form-control" name="idkar" id="idkar" value="<?php echo "$id"; ?>">
		<input type="hidden" class="form-control" name="total_layer" id="total_layer" value="<?php echo "$cek_total_layer"; ?>">
		<div class="form-group">
			<label>Nama Karyawan</label>
			<input type="text" class="form-control" name="namakar" id="namakar" style="width:50%" value="<?php echo $scek_nama['Nama_Lengkap']; ?>" placeholder="Masukkan Nama..." readonly>
		</div>
		<?php
		while($scekkaryawan = $stmt->fetch(PDO::FETCH_ASSOC)){
			$layer = "L$jml_layer";
			?>
			
			<div class="input-group margin">
				<div class="input-group-btn">
					<button type="button" class="btn btn-info" >Layer <?php echo "$jml_layer"; ?></button>
				</div><!-- /btn-group -->
				
				<select id="<?php echo $layer; ?>" name="<?php echo $layer; ?>" style="width:50%" class="form-control noEnterSubmit" >
					<option value="" > Pilih </option>
					<?php 
					$cek_sql = "SELECT k.id, k.Nama_Lengkap, d.Nama_OU FROM $karyawan as k 
					left join daftarou as d on d.Kode_OU=k.Kode_OU
					where 
					k.Kode_Golongan>'GL012' and k.Kode_StatusKerja<>'SKH05' ORDER BY k.Nama_Lengkap asc";
					$scek_sql = $koneksi->prepare($cek_sql);
					$scek_sql->execute();
					
					while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
						$selected="";
						if($scekkar['id']==$scekkaryawan['id_atasan']){$selected="selected";}
						?>
						<option value="<?php echo $scekkar['id']; ?>" <?php echo $selected; ?>><?php echo $scekkar['Nama_Lengkap']; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php
			$jml_layer++;
			
			$layer1 = "L$jml_layer";
		}
		?>
			<div class="input-group margin">
				<div class="input-group-btn">
					<button type="button" class="btn btn-info" >Layer <?php echo "$jml_layer"; ?></button>
				</div><!-- /btn-group -->
				
				<select id="<?php echo $layer1; ?>" name="<?php echo $layer1; ?>" style="width:50%" class="form-control noEnterSubmit" >
					<option value="" > Pilih </option>
					<?php 
					$cek_sql = "SELECT k.id, k.Nama_Lengkap, d.Nama_OU FROM $karyawan as k 
					left join daftarou as d on d.Kode_OU=k.Kode_OU
					where 
					k.Kode_Golongan>'GL012' and k.Kode_StatusKerja<>'SKH05' ORDER BY k.Nama_Lengkap asc";
					$scek_sql = $koneksi->prepare($cek_sql);
					$scek_sql->execute();
					
					while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
						?>
						<option value="<?php echo $scekkar['id']; ?>"><?php echo $scekkar['Nama_Lengkap']; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php $jml_layer++; $layer2 = "L$jml_layer"; ?>
			<div class="input-group margin">
				<div class="input-group-btn">
					<button type="button" class="btn btn-info" >Layer <?php echo "$jml_layer"; ?></button>
				</div><!-- /btn-group -->
				
				<select id="<?php echo $layer2; ?>" name="<?php echo $layer2; ?>" style="width:50%" class="form-control noEnterSubmit" >
					<option value="" > Pilih </option>
					<?php 
					$cek_sql = "SELECT k.id, k.Nama_Lengkap, d.Nama_OU FROM $karyawan as k 
					left join daftarou as d on d.Kode_OU=k.Kode_OU
					where 
					k.Kode_Golongan>'GL012' and k.Kode_StatusKerja<>'SKH05' ORDER BY k.Nama_Lengkap asc";
					$scek_sql = $koneksi->prepare($cek_sql);
					$scek_sql->execute();
					
					while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
						?>
						<option value="<?php echo $scekkar['id']; ?>"><?php echo $scekkar['Nama_Lengkap']; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php $jml_layer++; $layer3 = "L$jml_layer"; ?>
			<div class="input-group margin">
				<div class="input-group-btn">
					<button type="button" class="btn btn-info" >Layer <?php echo "$jml_layer"; ?></button>
				</div><!-- /btn-group -->
				
				<select id="<?php echo $layer3; ?>" name="<?php echo $layer3; ?>" style="width:50%" class="form-control noEnterSubmit" >
					<option value="" > Pilih </option>
					<?php 
					$cek_sql = "SELECT k.id, k.Nama_Lengkap, d.Nama_OU FROM $karyawan as k 
					left join daftarou as d on d.Kode_OU=k.Kode_OU
					where 
					k.Kode_Golongan>'GL012' and k.Kode_StatusKerja<>'SKH05' ORDER BY k.Nama_Lengkap asc";
					$scek_sql = $koneksi->prepare($cek_sql);
					$scek_sql->execute();
					
					while($scekkar = $scek_sql->fetch(PDO::FETCH_ASSOC)){
						?>
						<option value="<?php echo $scekkar['id']; ?>"><?php echo $scekkar['Nama_Lengkap']; ?></option>
					<?php } ?>
				</select>
			</div>
		<div class="box-footer">
			<input type="hidden" name="update_layer_superior" value="T" />
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		  </div>
	</form>
	<?php  
	}
}else if($_POST['kode']=="update_kpi"){

	$array_id = explode ("||",$id);
	$idkar = $array_id[0];
	$id_kpi = $array_id[1];
	
	$idmaster=$_POST['idmaster'];
	$sql = "Select k.*, dpt.Nama_Departemen, do.Nama_OU, dg.Nama_Golongan, k.Nama_Jabatan, dp.Nama_Perusahaan, kpu.kpi_unit, kpu.keterangan from  $karyawan k 
	left join kpi_unit_2023 as kpu on kpu.idkar=k.id and status_aktif='T'
	left join daftardepartemen dpt on k.Kode_Departemen = dpt.Kode_Departemen 
	left join daftarou do on k.Kode_OU = do.Kode_OU
	left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
	left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan 
	left join daftarjabatan dj on k.Kode_Jabatan = dj.Kode_Jabatan 
	where k.id='$id' order by k.Nama_Lengkap ASC";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();
	
	$scekkar = $stmt->fetch(PDO::FETCH_ASSOC);
	?>
	<form role="form" method="post" action="">
		<input type="hidden" class="form-control" name="idkar" id="idkar" value="<?php echo "$idkar"; ?>">
		<input type="hidden" class="form-control" name="id_kpi" id="id_kpi" value="<?php echo "$id_kpi"; ?>">
		<input type="hidden" class="form-control" name="idmaster" id="idmaster" value="<?php echo "$idmaster"; ?>">
		<div class="form-group">
			<label>Nama</label>
			<input type="text" class="form-control" name="nama_p" id="nama_p" style="width:50%" value="<?php echo $scekkar['Nama_Lengkap']; ?>" placeholder="Masukkan Nama..." readonly>
		</div>
		<div class="form-group">
			<label>KPI Unit</label>
			<select id="kpi_unit" name="kpi_unit" style="width:50%" class="form-control" onchange="isi_atasan3()" required>
				<option value="delete" > - </option>
				<option value="A" <?php if($scekkar['kpi_unit']=='A'){echo "selected";} ?>> A </option>
				<option value="B" <?php if($scekkar['kpi_unit']=='B'){echo "selected";} ?>> B </option>
				<option value="C" <?php if($scekkar['kpi_unit']=='C'){echo "selected";} ?>> C </option>
				<option value="D" <?php if($scekkar['kpi_unit']=='D'){echo "selected";} ?>> D </option>
				<option value="E" <?php if($scekkar['kpi_unit']=='E'){echo "selected";} ?>> E </option>
				
			</select>
			
		</div>
		<div class="form-group">
			<label>Keterangan</label>
			<input type="text" class="form-control" name="keterangan" id="keterangan" style="width:100%" value="<?php echo $scekkar['keterangan']; ?>" placeholder="Masukkan Nama..." >
		</div>
		<div class="box-footer">
			<input type="hidden" name="status_update_kpi" value="T" />
			<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
		</div>
	</form>
	<?php
}else if($_POST['kode']=="review_atasan"){

	function getGrade($nilai)
	{
		include("../conf/conf.php");
		$tahun=date('Y');
		
		$sql_kriteria = "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc";
		$stmt_kriteria = $koneksi->prepare($sql_kriteria);
		$stmt_kriteria->execute();
		$ak=0;
		while($ccekkriteria = $stmt_kriteria->fetch(PDO::FETCH_ASSOC))
		{
			$rngs[$ak]=$ccekkriteria['ranges'];
			$g[$ak]=$ccekkriteria['grade'];
			$ak++;
		}
		$gradenya="E";
		$warna="000000";
		for($aa=0;$aa<$ak;$aa++)
		{		
			if($nilai >= $rngs[$aa])
			{
				$gradenya=$g[$aa];
				break;
			}		
		}
		return $gradenya;
	}
	// echo "$id";
	$sql = "select k.id,k.nik_baru,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
	dg.Nama_Golongan,k.Nama_Jabatan, tp.created_date, do.Nama_OU, tp.total_score
	from $karyawan as k 
	left join daftarou as do on k.Kode_OU = do.Kode_OU 
	left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan 
	left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
	left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan 
	left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan 
	left join $transaksi_pa as tp on k.id = tp.idkar 
	where k.id='$id' order by k.Nama_Lengkap ASC";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
	
    $scekatasan1 = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$nilai_a1 = "";
	$nilai_a2 = "";
	$nilai_a3 = "";
	
	// if($scekatasan1['rating_a1']<>''){$nilai_a1=" - <b>".$scekatasan1['rating_a1']." (".getGrade($scekatasan1['rating_a1']).")</b>";}
	// if($scekatasan1['rating_a2']<>''){$nilai_a2=" - <b>".$scekatasan1['rating_a2']." (".getGrade($scekatasan1['rating_a2']).")</b>";}
	// if($scekatasan1['rating_a3']<>''){$nilai_a3=" - <b>".$scekatasan1['rating_a3']." (".getGrade($scekatasan1['rating_a3']).")</b>";}
	?>
	<table style="width:50%" class="table table-bordered table-striped">
		<tr>
			<td>NIK</td>
			<td><?php echo "$scekatasan1[nik_baru]"; ?></td>
		</tr>
		<tr>
			<td>Nama Karyawan</td>
			<td><?php echo "$scekatasan1[Nama_Lengkap]"; ?></td>
		</tr>
		<tr>
			<td>Tanggal Input</td>
			<td><?php echo "$scekatasan1[created_date]"; ?></td>
		</tr>
		<?php 
		$cek_atasan = "SELECT t.idkar, k.Nama_Lengkap, t.fortable, t.layer, t.approver_id, t.rating, kt.Nama_Lengkap as nama_atasan, t.approval_status, ku.kpi_unit 
		FROM `transaksi_2023` as t 
		left join kpi_unit_2023 as ku on ku.idkar=t.approver_id and status_aktif='T'
		left join karyawan_2023 as k on k.id=t.idkar
		left join karyawan_2023 as kt on kt.id=t.approver_id
		where t.idkar='2935' and layer<>'L0' and ku.kpi_unit<>'' ORDER BY layer asc";
		$stmt = $koneksi->prepare($cek_atasan);
		$stmt->execute();

		$scek_atasan = $stmt->fetch(PDO::FETCH_ASSOC);
		?>
		<tr>
			<td>Atasan 1</td>
			<td><?php echo ""; ?></td>
		</tr>
		<tr>
			<td>Atasan 2</td>
			<td><?php echo ""; ?></td>
		</tr>
		<tr>
			<td>Atasan 3</td>
			<td><?php echo ""; ?></td>
		</tr>
		<tr>
			<td><b>Final Score</b></td>
			<td><?php echo "<b>".$scekatasan1['total_score']." (".getGrade($scekatasan1['total_score']).")</b>"; ?></td>
		</tr>
	
	</table>
	<?php
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

