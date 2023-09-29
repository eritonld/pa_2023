<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng')
{
	$a1='Recapitulation PA';
}
else
{	
	$a1='Hasil Rekap PA';
}


$where="";
if(isset($_GET['generate']) && $_GET['generate']=='T'){

	//data unit
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

function getGrade($nilai)
{
	include("../conf/conf.php");
	$tahun=date('Y');
	$cekkriteria=mysqli_query($koneksi, "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc");
	$ak=0;
	while($ccekkriteria=mysqli_fetch_array($cekkriteria))
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
//echo "$where";
?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
		<div class="box-body">
		<form name="formcek" action="" method="get">
		<input type="hidden" name="generate" value="T" />
		<input type="hidden" name="link" value="datareport" />
		<table style="width:100%">
			<tr>
				<td>
					<label>Daftar Unit</label><br>
					<select id="aksesou" name="aksesou[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						
						$cekou=mysqli_query($koneksi, "select Kode_OU,Nama_OU from daftarou where aktif='T' and Kode_OU in $scekuser[ou] order by Nama_OU asc");
						while($scekou=mysqli_fetch_array($cekou)){
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
						$cekpt=mysqli_query($koneksi, "select Kode_Perusahaan,Nama_Perusahaan from daftarperusahaan where active='T' and Kode_Perusahaan in $scekuser[pt] order by Nama_Perusahaan asc");
						while($scekpt=mysqli_fetch_array($cekpt)){
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
						$cekdept=mysqli_query($koneksi, "select kode_departemen,Nama_Departemen from daftardepartemen where active='T' and kode_departemen in $scekuser[dept] order by Nama_Departemen asc");
						while($scekdept=mysqli_fetch_array($cekdept)){
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
						$cekgrade=mysqli_query($koneksi, "select Kode_Golongan,Nama_Golongan from daftargolongan where active='T' and Kode_Golongan in $scekuser[gol] order by Kode_Golongan asc");
						while($scekgrade=mysqli_fetch_array($cekgrade)){
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
						$cekbisnis=mysqli_query($koneksi, "select kode_bisnis,nama_bisnis from daftarbisnis where kode_bisnis in $scekuser[bisnis] order by nama_bisnis asc");
						while($scekbisnis=mysqli_fetch_array($cekbisnis)){
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
			<table class="table table-bordered table-striped" style="width:40%">
				<thead>
					<tr>
						<th align="center">Nilai Mutu</th>	
						<th align="center">Jumlah</th>
						<th align="center">%</th>
					</tr>
				</thead>
				<tbody>
				<?php
				set_time_limit(0);
				$yearnow	= Date('Y');
				$cutoff		= $yearnow."-07-01";
				
				$q_grade = mysqli_query($koneksi, "select * from kriteria 
				where tahun='$yearnow' order by grade asc");
				while($r_grade = mysqli_fetch_array($q_grade))
				{
				?>
					<tr>
						<td ><?php echo $r_grade['grade'] ?></td>
						<td >
							<?php  
								$yearnow	= Date('Y');
								$cutoff		= $yearnow."-07-01";
								$q_cekdata = mysqli_query($koneksi, "select k.*,tp.edit_by, tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen, dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU, tp.total,
								(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.input_by))as inputby,
								(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by))as editby,
								(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by2))as editby2,
								(Select Nama_Lengkap from $karyawan where nik = (select nik_atasan1 from atasan where nik = k.nik))as atasan1,
								(Select Nama_Lengkap from $karyawan where nik = (select nik_atasan2 from atasan where nik = k.nik))as atasan2,
								tp.date_edit, tp.date_edit2
								from $karyawan as k 
								left join daftarou as do on k.Kode_OU = do.Kode_OU 
								left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan 
								left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
								left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan 
								left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan 
								left join $transaksi_pa as tp on k.NIK = tp.NIK 
								where tp.input_by <>'' $where and k.Mulai_Bekerja <= '$cutoff' and k.Kode_StatusKerja<>'SKH05' order by k.Nama_Lengkap ASC");
								
								
								//and k.Mulai_Bekerja <= '$cutoff'
								
								$cekcount	= 0;
								$j_cekdata	= mysqli_num_rows($q_cekdata); 
								while ($r_cekdata = mysqli_fetch_array($q_cekdata))
								{
									$getgrade = getGrade($r_cekdata['total']);
									
									if ($getgrade == $r_grade['grade'])
									{
										$cekcount++;
									}
								}
								$totalgrade = $cekcount;
								echo $totalgrade;
								
							?>
						</td>
						<td>
							<?php
								if($j_cekdata==0){
									echo number_format(0,1)." %";
								}else{
									echo number_format((($totalgrade/$j_cekdata)*100),1)." %";
								}
							?>
						</td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td>Total</td>
					<td colspan = "2" align="center"><?php echo $j_cekdata ?></td>
					
				</tr>
				</tbody>
			</table>
			<br><br>
			<table id="daftar_table" class="table table-bordered table-striped" style="width:40%">
				<thead>
					<tr>
						<th >Data</th>	
						<th >Jumlah</th>
						<th >%</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$yearnow	= Date('Y');
				$cutoff		= $yearnow."-07-01";
				$q_data = mysqli_query ($koneksi, "Select k.*, dpt.Nama_Departemen, do.Nama_OU, dg.Nama_Golongan, k.Nama_Jabatan, dp.Nama_Perusahaan from $karyawan k 
										left join daftardepartemen dpt on k.Kode_Departemen = dpt.Kode_Departemen 
										left join daftarou do on k.Kode_OU = do.Kode_OU
										left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
										left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan 
										left join daftarjabatan dj on k.Kode_Jabatan = dj.Kode_Jabatan 
										where nik <> '' $where and k.Mulai_Bekerja <= '$cutoff' and k.Kode_StatusKerja<>'SKH05' order by k.Nama_Lengkap ASC
										");	
				$j_data = mysqli_num_rows($q_data);
				?>
				<tr>
					<td >Karyawan yang sudah dinilai</td>	
					<td ><?php echo $j_cekdata ?></td>	
					<td ><?php echo number_format((($j_cekdata/$j_data)*100),2). " %" ?></td>			
				</tr>
				<tr>
					<td >Karyawan yang belum dinilai</td>	
					<td ><?php echo ($j_data-$j_cekdata)  ?></td>	
					<td ><?php echo number_format(((($j_data-$j_cekdata)/$j_data)*100),2). " %" ?></td>			
				</tr>
				<tr>
					<td>Total</td>
					<td colspan = "2" align="center"><?php echo $j_data ?></td>
					
				</tr>
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