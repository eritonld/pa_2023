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
		window.open("reportexcelempnotssessed.php?bisnis=<?php echo $bisnis ?>&grade=<?php echo $grade ?>&dept=<?php echo $dept ?>&pt=<?php echo $pt ?>&unit=<?php echo $unit ?>");
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
				<td><br><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Generate </button></td>
			</tr>
			<?php
			if(isset($_GET['generate']) && $_GET['generate']=='T'){
			//echo "isinya adalah $where";
			?>
			<tr>
				<td><br><b>Export Data Karyawan :</b> <img src="../img/excel2.png" onClick="empnotexcel()" style="padding-top:0px;cursor:pointer;width:15%;" title="Employee Not Assessed on Excel"></img></td>
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
				    <th>Mulai Bekerja</th>
				    <th>Departemen</th>
				    <th>Jabatan</th>
					<th>Golongan</th>
					<th>PT</th>
					<th>Lokasi Unit</th>
				  </tr>
				</thead>
				<tbody>
					<?php					
					$no = 1;
					$yearnow	= Date('Y');
					$cutoff		= $yearnow."-07-01";
					
					$sql = "Select k.*, dpt.Nama_Departemen, do.Nama_OU, dg.Nama_Golongan, k.Nama_Jabatan, dp.Nama_Perusahaan from $karyawan k 
					left join daftardepartemen dpt on k.Kode_Departemen = dpt.Kode_Departemen 
					left join daftarou do on k.Kode_OU = do.Kode_OU
					left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
					left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan 
					left join daftarjabatan dj on k.Kode_Jabatan = dj.Kode_Jabatan 
					where k.Kode_StatusKerja<>'SKH05' $where and k.Mulai_Bekerja <= '$cutoff' and k.id not in (select idkar from $transaksi_pa where input_by<>'') order by k.Nama_Lengkap ASC";
					
					$stmt = $koneksi->prepare($sql);
					$stmt->execute();
					
					while($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td><?php echo "$no"; ?></td>
						<td><?php echo "$scekkar[NIK]"; ?></td>
						<td><?php echo "$scekkar[Nama_Lengkap]"; ?></td>
						<td><?php echo "$scekkar[Mulai_Bekerja]"; ?></td>
						<td><?php echo "$scekkar[Nama_Departemen]"; ?></td>
						<td><?php echo "$scekkar[Nama_Jabatan]"; ?></td>
						<td><?php echo "$scekkar[Nama_Golongan]"; ?></td>
						<td><?php echo "$scekkar[Nama_Perusahaan]"; ?></td>
						<td><?php echo "$scekkar[Nama_OU]"; ?></td>
					</tr>
					<?php
					$no++;
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