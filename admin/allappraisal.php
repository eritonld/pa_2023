<?php
if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng')
{
	$a1='All Data Appraisal';
}
else
{	
	$a1='Data Penilaian';
}

$where="";
if(isset($_GET['generate']) && $_GET['generate']=='T'){

	//data unit
	$unit = "";
	$allunit = "all";
	if(isset($_GET['aksesou'])){
		$values_unit=$_GET['aksesou'];
		if ($values_unit <> ''){
				$xx=0;
				$unit = "";
				$allunit = "";
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
				$allunit="('".str_replace(",","','",$d_unit)."')";
			$where=$where." and k.Kode_OU in $unit";
		}
	}else{
			$unit = $scekuser['ou'];
			$allunit = $scekuser['ou'];
			$where=$where." and k.Kode_OU in $unit";
		}
	
	//data perusahaan
	$pt = "";
	$allpt = "all";
	if(isset($_GET['aksespt'])){
		$values_pt=$_GET['aksespt'];
		if ($values_pt <> ''){
				$xx=0;
				$pt = "";
				$allpt = "";
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
				$allpt="('".str_replace(",","','",$d_pt)."')";
			$where=$where." and k.Kode_Perusahaan in $pt";
		}
	}else{
			$pt = $scekuser['pt'];
			$allpt = "all";
			$where=$where." and k.Kode_Perusahaan in $pt";
		}
	
	//data dept
	$dept = "";
	$alldept = "all";
	if(isset($_GET['aksesdept'])){
		$values_dept=$_GET['aksesdept'];
		if ($values_dept <> ''){
				$xx=0;
				$dept = "";
				$alldept = "";
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
				$alldept="('".str_replace(",","','",$d_dept)."')";
			$where=$where." and k.Kode_Departemen in $dept";
		}
	}else{
			$dept = $scekuser['dept'];
			$alldept = "all";
			$where=$where." and k.Kode_Departemen in $dept";
		}
	
	//data grade
	$grade = "";
	$allgrade = "all";
	if(isset($_GET['akseslevel'])){
		$values_grade=$_GET['akseslevel'];
		if ($values_grade <> ''){
				$xx=0;
				$grade = "";
				$allgrade = "";
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
				$allgrade="('".str_replace(",","','",$d_grade)."')";
			$where=$where." and k.Kode_Golongan in $grade";
		}
	}else{
			$grade = $scekuser['gol'];
			$allgrade = "all";
			$where=$where." and k.Kode_Golongan in $grade";
		}
	
	//data bisnis
	$bisnis = "";
	$allbisnis = "all";
	if(isset($_GET['aksesbisnis'])){
		$values_bisnis=$_GET['aksesbisnis'];
		if ($values_bisnis <> ''){
				$xx=0;
				$bisnis = "";
				$allbisnis = "";
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
				$allbisnis="('".str_replace(",","','",$d_bisnis)."')";
			$where=$where." and do.BU in $bisnis";
		}
	}else{
			$bisnis = $scekuser['bisnis'];
			$allbisnis = "all";
			$where=$where." and do.BU in $bisnis";
		}
	
	if(isset($_GET['carinama']) && $_GET['carinama'] <> ''){
		$where=$where." and k.Nama_Lengkap like '%$_GET[carinama]%'";
	}
}

function getGrade($nilai)
{
	include("../conf/conf.php");
	$tahun=date('Y');
	
	$sql = "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();
	$ak=0;
	while($ccekkriteria = $stmt->fetch(PDO::FETCH_ASSOC))
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
//echo "$where<br>";
?>
<script>
	function viewdata(nik)
	{
		window.open("papdf.php?nik="+nik);
	}	
	function preview_pdf(nik)
	{
		window.open("home.php?link=preview_pdf&kode=preview_pdf&nik="+nik);
	}
	function editdata(nik,form)
	{
		window.open("home.php?link=formpa_edit&nik="+nik);
	}
	//alert("test");
	function reportexcel()
	{
		window.open("reportexcel.php?bisnis=<?php echo $bisnis ?>&grade=<?php echo $grade ?>&dept=<?php echo $dept ?>&pt=<?php echo $pt ?>&unit=<?php echo $unit ?>");
	}
	function reportexceldetail()
	{
		window.open("reportexcel_detail.php?bisnis=<?php echo $bisnis ?>&grade=<?php echo $grade ?>&dept=<?php echo $dept ?>&pt=<?php echo $pt ?>&unit=<?php echo $unit ?>");
	}
</script>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
		<div class="box-body">
		<form name="formcek" action="" method="get">
		<input type="hidden" name="generate" value="T" />
		<input type="hidden" name="link" value="dataapp" />
		<table style="width:100%" border=0>
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
				<td style="width:26%">
					<label>Cari Nama</label><br>
					<input type="text" id="carinama" name="carinama" value="<?php if(isset($_GET['generate'])){ echo $_GET['carinama']; } ?>" class="form-control" />
				</td>
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
				<td><br><b>Rekap Penilaian :</b> <img src="../img/excel2.png" onClick="reportexcel()" style="padding-top:0px;cursor:pointer;width:15%;" title="Recapitulation on Excel"></img></td>
			</tr>
			<!--<tr>
				<td><b>Rekap Detail Penilaian :</b> <img src="../img/excel2.png" onClick="reportexceldetail()" style="padding-top:0px;cursor:pointer;width:15%;" title="Recapitulation on Excel"></img></td>
			</tr>-->
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
				    <th>Departemen</th>
				    <th>Jabatan</th>
					<th>Golongan</th>
					<th>PT</th>
					<th>Lokasi Unit</th>
					<th style="background:#ffffaa;">Final Total Score</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>
					<?php					
					$no = 1;
					$yearnow	= Date('Y');
					$cutoff		= $yearnow."-06-30";
					
					$sql = "select k.id,k.nik_baru,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
					dg.Nama_Golongan,k.Nama_Jabatan, tp.created_date, do.Nama_OU, tp.total_score
					from $karyawan as k 
					left join daftarou as do on k.Kode_OU = do.Kode_OU 
					left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan 
					left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
					left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan 
					left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan 
					left join $transaksi_pa_final as tp on k.id = tp.idkar 
					where tp.created_by<>'' and k.Kode_StatusKerja<>'SKH05' $where and k.Mulai_Bekerja <= '$cutoff' order by k.Nama_Lengkap ASC";
					
					$stmt = $koneksi->prepare($sql);
					$stmt->execute();

					while($scekpa = $stmt->fetch(PDO::FETCH_ASSOC)){

					?>
					<tr>
						<td><?php echo "$no"; ?></td>
						<td><?php echo "$scekpa[nik_baru]"; ?></td>
						<td><?php echo "$scekpa[Nama_Lengkap]"; ?></td>
						<td><?php echo "$scekpa[Nama_Departemen]"; ?></td>
						<td><?php echo "$scekpa[Nama_Jabatan]"; ?></td>
						<td><?php echo "$scekpa[Nama_Golongan]"; ?></td>
						<td><?php echo "$scekpa[Nama_Perusahaan]"; ?></td>
						<td><?php echo "$scekpa[Nama_OU]"; ?></td>
						<td><?php echo "<b>".$scekpa['total_score']." (".getGrade($scekpa['total_score']).")</b>"; ?></td>
						<td>
							
							<button class="label label-primary" data-toggle="modal" data-target="#modalupload1" data-backdrop="static" data-id="<?php echo $scekpa['id'];?>"><i class="fa fa-search"></i>
							<!--<button class="btn btn-info btn-xs" onclick = "preview_pdf('<?php //echo $scekpa['NIK']?>')"><i class="fa fa-search"></i> pdf</button>-->
							
							<?php if($scekuser['level']=="admin"){ ?>
							<!--<button class="btn btn-danger btn-xs" onclick = "editdata('<?php //echo $scekpa['NIK']?>')"><i class="fa fa-pencil"></i></button>-->
							<?php } ?>
						</td>
						
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
<div class="modal fade" id="modalupload" tabindex="-1" class="modal" role="dialog">
	<div class="modal-dialog" style="width:75%">
	  <!-- konten modal-->
	  <div class="modal-content">
		<!-- heading modal -->
		<div align="center" class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <label style="padding-left: 10px">Preview PDF</label><br>
		</div>
		<div class="modal-body">
		  <div class="modal-data"></div>
		</div>
	  </div>
	</div>
</div>
<div class="modal fade" id="modalupload1" tabindex="-1" class="modal" role="dialog" >
	<div class="modal-dialog" style="width:60%">
	  <!-- konten modal-->
	  <div class="modal-content">
		<!-- heading modal -->
		<div align="center" class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <label style="padding-left: 10px">View Detail</label><br>
		</div>
		<div class="modal-body">
		  <div class="modal-data"></div>
		</div>
	  </div>
	</div>
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
	$(document).ready(function(){
        $('#modalupload').on('show.bs.modal', function (e) {
            var id  = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'preview_pdf.php',
                data :  'kode=preview_pdf&id='+ id,
                success : function(data){
                $('.modal-data').html(data);//menampilkan data ke dalam modal
                // console.log(data);
                }
            });
         });
    }); 
	$(document).ready(function(){
        $('#modalupload1').on('show.bs.modal', function (e) {
            var id  = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'set_modal.php',
                data :  'kode=review_atasan&id='+ id,
                success : function(data){
                $('.modal-data').html(data);//menampilkan data ke dalam modal
                // console.log(data);
                }
            });
         });
    });
</script>