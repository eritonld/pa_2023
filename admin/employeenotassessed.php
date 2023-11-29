<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng')
{
	$a1='Employee Not Been Assessed';
}
else
{	
	$a1='Data Karyawan Belum di Nilai';
}


$where="";
if(isset($_GET['generate']) && $_GET['generate']=='T'){

	//data unit
	$unit = "";
	if(isset($_GET['aksesou'])){
		$values_unit=$_GET['aksesou'];
		if ($values_unit <> ''){
				$xx=0;
				$unit = "";
				$d_unit = "";
				foreach ($values_unit as $kunit)
				{
					if($xx==0)
						$d_unit = $kunit;
					else
						$d_unit = $d_unit.",".$kunit;
					$xx++;
				}
				$unit="('".str_replace(",","','",$d_unit)."')";
			$where=$where." and k.Kode_OU in $unit";
		}
	}else{
			$unit = $scekuser['ou'];
			$where=$where." and k.Kode_OU in $unit";
		}
	
	//data perusahaan
	$pt = "";
	if(isset($_GET['aksespt'])){
		$values_pt=$_GET['aksespt'];
		if ($values_pt <> ''){
				$xx=0;
				$pt = "";
				$d_pt = "";
				foreach ($values_pt as $kpt)
				{
					if($xx==0)
						$d_pt = $kpt;
					else
						$d_pt = $d_pt.",".$kpt;
					$xx++;
				}
				$pt="('".str_replace(",","','",$d_pt)."')";
			$where=$where." and k.Kode_Perusahaan in $pt";
		}
	}else{
			$pt = $scekuser['pt'];
			$where=$where." and k.Kode_Perusahaan in $pt";
		}
	
	//data dept
	$dept = "";
	if(isset($_GET['aksesdept'])){
		$values_dept=$_GET['aksesdept'];
		if ($values_dept <> ''){
				$xx=0;
				$dept = "";
				$d_dept = "";
				foreach ($values_dept as $kdept)
				{
					if($xx==0)
						$d_dept = $kdept;
					else
						$d_dept = $d_dept.",".$kdept;
					$xx++;
				}
				$dept="('".str_replace(",","','",$d_dept)."')";
			$where=$where." and k.Kode_Departemen in $dept";
		}
	}else{
			$dept = $scekuser['dept'];
			$where=$where." and k.Kode_Departemen in $dept";
		}
	
	//data grade
	$grade = "";
	if(isset($_GET['akseslevel'])){
		$values_grade=$_GET['akseslevel'];
		if ($values_grade <> ''){
				$xx=0;
				$grade = "";
				$d_grade = "";
				foreach ($values_grade as $kgrade)
				{
					if($xx==0)
						$d_grade = $kgrade;
					else
						$d_grade = $d_grade.",".$kgrade;
					$xx++;
				}
				$grade="('".str_replace(",","','",$d_grade)."')";
			$where=$where." and k.Kode_Golongan in $grade";
		}
	}else{
			$grade = $scekuser['gol'];
			$where=$where." and k.Kode_Golongan in $grade";
		}
	
	//data bisnis
	$bisnis = "";
	if(isset($_GET['aksesbisnis'])){
		$values_bisnis=$_GET['aksesbisnis'];
		if ($values_bisnis <> ''){
				$xx=0;
				$bisnis = "";
				$d_bisnis = "";
				foreach ($values_bisnis as $kbisnis)
				{
					if($xx==0)
						$d_bisnis = $kbisnis;
					else
						$d_bisnis = $d_bisnis.",".$kbisnis;
					$xx++;
				}
				$bisnis="('".str_replace(",","','",$d_bisnis)."')";
			$where=$where." and do.BU in $bisnis";
		}
	}else{
			$bisnis = $scekuser['bisnis'];
			$where=$where." and do.BU in $bisnis";
		}
}
?>
<script>
	function empnotexcel()
	{
		window.open("reportexcelprogressapp.php?bisnis=<?php echo $bisnis ?>&grade=<?php echo $grade ?>&dept=<?php echo $dept ?>&pt=<?php echo $pt ?>&unit=<?php echo $unit ?>");
	}
</script>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
		<div class="box-body">
		<form name="formcek" action="" method="get">
		<input type="hidden" name="generate" value="T" />
		<input type="hidden" name="link" value="notassessed" />
		<table style="width:100%">
			<tr>
				<td>
					<label>Daftar Unit</label><br>
					<select id="aksesou" name="aksesou[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "select Kode_OU,Nama_OU from daftarou where aktif='T' and Kode_OU in $scekuser[ou] order by Nama_OU asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($scekou = $stmt->fetch(PDO::FETCH_ASSOC)){
						$selectednya="";
						if (preg_match('/'.$scekou['Kode_OU'].'/',$d_unit))
							$selectednya="selected";
						?>
							<option value="<?php echo "$scekou[Kode_OU]"; ?>" <?php echo"$selectednya";?>> <?php echo "$scekou[Nama_OU]"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
				<td style="width:1%"></td>
				<td>
					<label>Daftar Perusahaan</label><br>
					<select id="aksespt" name="aksespt[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "select Kode_Perusahaan,Nama_Perusahaan from daftarperusahaan where active='T' and Kode_Perusahaan in $scekuser[pt] order by Nama_Perusahaan asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($scekpt = $stmt->fetch(PDO::FETCH_ASSOC)){
						
						$selectednya="";
						if (preg_match('/'.$scekpt['Kode_Perusahaan'].'/',$d_pt))
							$selectednya="selected";
						?>
							<option value="<?php echo "$scekpt[Kode_Perusahaan]"; ?>" <?php echo"$selectednya";?>> <?php echo "$scekpt[Nama_Perusahaan]"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
				<td style="width:1%"></td>
				<td>
					<label>Daftar Departemen</label><br>
					<select id="aksesdept" name="aksesdept[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "select kode_departemen,Nama_Departemen from daftardepartemen where active='T' and kode_departemen in $scekuser[dept] order by Nama_Departemen asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($scekdept = $stmt->fetch(PDO::FETCH_ASSOC)){
						$selectednya="";
						if (preg_match('/'.$scekdept['kode_departemen'].'/',$d_dept))
							$selectednya="selected";
						?>
							<option value="<?php echo "$scekdept[kode_departemen]"; ?>" <?php echo"$selectednya";?>> <?php echo "$scekdept[Nama_Departemen]"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
				<td style="width:1%"></td>
				<td>
					<label>Daftar Grade</label><br>
					<select id="akseslevel" name="akseslevel[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "select Kode_Golongan,Nama_Golongan from daftargolongan where active='T' and Kode_Golongan in $scekuser[gol] order by Kode_Golongan asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($scekgrade = $stmt->fetch(PDO::FETCH_ASSOC)){
						$selectednya="";
						if (preg_match('/'.$scekgrade['Kode_Golongan'].'/',$d_grade))
							$selectednya="selected";
						?>
							<option value="<?php echo "$scekgrade[Kode_Golongan]"; ?>" <?php echo"$selectednya";?>> <?php echo "$scekgrade[Nama_Golongan]"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<?php if($scekuser['username']=='adminhomaster'){ ?>
			<tr>
				<td>
					<label>Daftar Bisnis</label><br>
					<select id="aksesbisnis" name="aksesbisnis[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "select kode_bisnis,nama_bisnis from daftarbisnis where kode_bisnis in $scekuser[bisnis] order by nama_bisnis asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($scekbisnis = $stmt->fetch(PDO::FETCH_ASSOC)){
						$selectednya="";
						if (preg_match('/'.$scekbisnis['kode_bisnis'].'/',$d_bisnis))
							$selectednya="selected";
						?>
							<option value="<?php echo "$scekbisnis[kode_bisnis]"; ?>" <?php echo"$selectednya";?>> <?php echo "$scekbisnis[nama_bisnis]"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
				<td style="width:1%"></td>
			</tr>
			<?php } ?>
			<tr>
				<td>
					<label>Status</label><br>
					<select id="status_completed" name="status_completed" class="form-control" multiple="multiple" style="width:26%">
						<option value="All"> Completed </option>
						<option value="Completed"> Completed </option>
						<option value="Not Completed"> Completed </option>
					</select>
				</td>
				<td style="width:1%"></td>
			</tr>
			<tr>
				<td><br><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Generate </button></td>
			</tr>
			<?php
			if(isset($_GET['generate']) && $_GET['generate']=='T'){
			//echo "isinya adalah $where";
			?>
			<tr>
				<td><br><b>Export Data Karyawan :</b> <img src="../img/excel2.png" onClick="empnotexcel()" style="padding-top:0px;cursor:pointer;width:15%;" title="Progress Appraisal"></img></td>
			</tr>
			<?php
			}
			?>
		</table>
		</form>
		</div>
	</div>
  </div>
</section>
</div>
<?php
if(isset($_GET['generate']) && $_GET['generate']=='T'){
?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
			<table id="daftar_table" class="table table-bordered table-striped">
				<thead>
				  <tr>
					<th style="width: 10px">No</th>
				    <th>NIK</th>
				    <th>Nama</th>
				    <th>Jabatan</th>
					<th>L1</th>
					<th>L2</th>
					<th>L3</th>
					<th>L4</th>
					<th>L5</th>
					<th>L6</th>
					<th>L7</th>
					<th>L8</th>
					<th>Status</th>
				  </tr>
				</thead>
				<tbody>
					<?php					
					$nodata = 1;
					$nourut = 1;
					$yearnow	= Date('Y');
					$cutoff		= $yearnow."-06-30";
					$idkar		= "";
					
					$layer1="";
					$layer2="";
					$layer3="";
					$layer4="";
					$layer5="";
					$layer6="";
					$layer7="";
					$layer8="";
					
					$bcg1="";
					$bcg2="";
					$bcg3="";
					$bcg4="";
					$bcg5="";
					$bcg6="";
					$bcg7="";
					$bcg8="";
					
					$sql = "SELECT k.id,k.nik_baru, k.Nama_Lengkap, k.Nama_Jabatan, do.Nama_OU, dg.Nama_Golongan, dp.Nama_Perusahaan, aa.layer, kk.Nama_Lengkap as nama_atasan, ku.kpi_unit, t.approval_status, t.updated_date, tf.approver_rating_id FROM `karyawan_2023` as k
					left join daftarou do on k.Kode_OU = do.Kode_OU
					left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
					left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan
					left join atasan as aa on aa.idkar=k.id
					left join kpi_unit_2023 as ku on ku.idkar=aa.id_atasan and ku.status_aktif='T'
					left join karyawan_2023 as kk on kk.id=aa.id_atasan
					left join transaksi_2023 as t on t.idkar=k.id and t.layer=aa.layer and aa.id_atasan=t.approver_id
					left join transaksi_2023_final as tf on tf.idkar=k.id
					where k.Kode_StatusKerja<>'SKH05' $where and k.Mulai_Bekerja <= '$cutoff' ORDER BY k.Nama_Lengkap, k.id, aa.layer ASC";
					
					$stmt = $koneksi->prepare($sql);
					$stmt->execute();
					
					while($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)){

					if(($scekkar['layer']=='L1' || $scekkar['layer']==null) && $nodata<>1){
						?>
						<tr>
							<td><?php echo "$nourut"; ?></td>
							<td><?php echo "$nikbaru"; ?></td>
							<td><?php echo "$namakar"; ?></td>
							<td><?php echo "$namajab"; ?></td>
							<td style="background-color: <?php echo $bcg1; ?>"><?php echo "$layer1"; ?></td>
							<td style="background-color: <?php echo $bcg2; ?>"><?php echo "$layer2"; ?></td>
							<td style="background-color: <?php echo $bcg3; ?>"><?php echo "$layer3"; ?></td>
							<td style="background-color: <?php echo $bcg4; ?>"><?php echo "$layer4"; ?></td>
							<td style="background-color: <?php echo $bcg5; ?>"><?php echo "$layer5"; ?></td>
							<td style="background-color: <?php echo $bcg6; ?>"><?php echo "$layer6"; ?></td>
							<td style="background-color: <?php echo $bcg7; ?>"><?php echo "$layer7"; ?></td>
							<td style="background-color: <?php echo $bcg8; ?>"><?php echo "$layer8"; ?></td>
							<td><?php echo "$detail_status"; ?></td>
						</tr>
						<?php
						$nourut++;
						$detail_status="";
						$layer1="";
						$layer2="";
						$layer3="";
						$layer4="";
						$layer5="";
						$layer6="";
						$layer7="";
						$layer8="";
						$bcg1="";
						$bcg2="";
						$bcg3="";
						$bcg4="";
						$bcg5="";
						$bcg6="";
						$bcg7="";
						$bcg8="";
					}
					
					$nikbaru = $scekkar['nik_baru'];
					$namakar = $scekkar['Nama_Lengkap'];
					$namajab = $scekkar['Nama_Jabatan'];
					
					//detail status
					if($scekkar['layer']==null){
						$detail_status="<b>no layer</b>";
					}else if($scekkar['approval_status']==null){
						$detail_status="<b>no appraisal</b>";
					}else if($scekkar['approver_rating_id']==0){
						$detail_status="<b>Completed</b>";
					}else{
						$detail_status="";
					}
					
					//detail layer
					if($scekkar['layer']=='L1'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer1="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer1="<i class='fa fa-fw fa-minus' style='color: red;'></i>";
						}
						if($scekkar['kpi_unit']<>null){$bcg1="#E3FAD8";}else{$bcg1="#FFF5EE";}
					}
					if($scekkar['layer']=='L2'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer2="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer2="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg2="#E3FAD8";}else{$bcg2="#FFF5EE";}
					}
					if($scekkar['layer']=='L3'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer3="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer3="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg3="#E3FAD8";}else{$bcg3="#FFF5EE";}
					}
					if($scekkar['layer']=='L4'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer4="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer4="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg4="#E3FAD8";}else{$bcg4="#FFF5EE";}
					}
					if($scekkar['layer']=='L5'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer5="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer5="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg5="#E3FAD8";}else{$bcg5="#FFF5EE";}
					}
					if($scekkar['layer']=='L6'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer6="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer6="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg6="#E3FAD8";}else{$bcg6="#FFF5EE";}
					}
					if($scekkar['layer']=='L7'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer7="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer7="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg7="#E3FAD8";}else{$bcg7="#FFF5EE";}
					}
					if($scekkar['layer']=='L8'){
						if($scekkar['approval_status']=='Approved'){ 
							$layer8="<i class='fa fa-fw fa-check-circle' style='color: green;'></i>"; 
						}else if($scekkar['approval_status']=='Pending'){ 
							$layer8="<i class='fa fa-fw fa-minus' style='color: red;'></i>"; 
						}
						if($scekkar['kpi_unit']<>null){$bcg8="#E3FAD8";}else{$bcg8="#FFF5EE";}
					}

					$nodata++;
					}
					?>
				</tbody>
			</table>
        </div>
    </div>
  </div>
</section>
</div>
<?php
}
?>
<script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(function () {
		$("#daftar_table").dataTable();
	});
</script>