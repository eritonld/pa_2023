<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<?php
if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

// if($bahasa=='eng')
// {
	// $a1='Employee Not Been Assessed';
// }
// else
// {	
	// $a1='Data Karyawan Belum di Nilai';
// }


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
	
	//data superior
	$sup = "";
	if(isset($_GET['superior'])){
		$values_sup=$_GET['superior'];
		if ($values_sup <> ''){
				$xx=0;
				$sup = "";
				$d_sup = "";
				foreach ($values_sup as $ksup)
				{
					if($xx==0)
						$d_sup = $ksup;
					else
						$d_sup = $d_sup.",".$ksup;
					$xx++;
				}
				$sup="('".str_replace(",","','",$d_sup)."')";
			$where=$where." and (ka1.NIK in $sup or ka1.NIK in $sup or ka1.NIK in $sup)";
		}
	}else{
			
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
	function updatesuperior(nik)
	{
		
		window.open("home.php?link=fu_superior&nik="+nik);
	}
</script>
<?php
	if(isset($_POST['update_superior'])){
		$idkar = $_POST['idkar'];
		$ida1 = $_POST['ida1'];
		$ida2 = $_POST['ida2'];
		$ida3 = $_POST['ida3'];

		try {
			$koneksi->beginTransaction();

			$stmt = $koneksi->prepare("SELECT * FROM atasan WHERE idkar = :idkar");
			$stmt->bindParam(':idkar', $idkar);
			$stmt->execute();
			$count_user = $stmt->rowCount();

			if($count_user > 0){
				$stmt = $koneksi->prepare("UPDATE atasan SET id_atasan1 = :ida1, id_atasan2 = :ida2, id_atasan3 = :ida3 WHERE idkar = :idkar");
			} else {
				$stmt = $koneksi->prepare("INSERT INTO atasan (idkar, id_atasan1, id_atasan2, id_atasan3) VALUES (:idkar, :ida1, :ida2, :ida3)");
			}

			$stmt->bindParam(':idkar', $idkar);
			$stmt->bindParam(':ida1', $ida1);
			$stmt->bindParam(':ida2', $ida2);
			$stmt->bindParam(':ida3', $ida3);
			$stmt->execute();

			$koneksi->commit();
			// echo "Transaction successful!";
		} catch(PDOException $e) {
			$koneksi->rollBack();
			?>
			<script language="JavaScript">
				alert('Gagal');
			</script>
			<?php
			echo "Transaction failed: " . $e->getMessage();
		}
	}


?>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
		<div class="box-body">
		<form name="formcek" action="" method="get">
		<input type="hidden" name="generate" value="T" />
		<input type="hidden" name="link" value="update_sup" />
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
					<label>Superior</label><br>
					<select id="superior" name="superior[]" class="form-control" multiple="multiple" style="width:26%">
						<?php
						$sql = "SELECT ats.id_atasan1, k.Nama_Lengkap, k.nik_baru, d.Nama_OU, k.NIK FROM `atasan` as ats 
						left join $karyawan as k on k.id=ats.id_atasan1
						left join daftarou as d on d.Kode_OU=k.Kode_OU
						GROUP BY ats.id_atasan1 ORDER BY k.Nama_Lengkap asc";
						$stmt = $koneksi->prepare($sql);
						$stmt->execute();
						
						while($sceksuperior = $stmt->fetch(PDO::FETCH_ASSOC)){
						$selectednya="";
						if (preg_match('/'.$sceksuperior['NIK'].'/',$d_sup))
							$selectednya="selected";
						?>
							<option value="<?php echo "$sceksuperior[NIK]"; ?>" <?php echo"$selectednya";?>> <?php echo "$sceksuperior[Nama_Lengkap] ($sceksuperior[nik_baru])"; ?> </option>
						<?php
						}
						?>
					</select>
				</td>
				<td style="width:1%"></td>
			<?php if($scekuser['username']=='adminhomaster'){ ?>
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
				</td>
			<?php } ?>
			<tr>
				<td><br><button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Generate </button></td>
			</tr>
			<?php
			if(isset($_GET['generate']) && $_GET['generate']=='T'){
			//echo "isinya adalah $where";
			?>
			<tr>
				<!--<td><br><b>Export Data Karyawan :</b> <img src="../img/excel2.png" onClick="empnotexcel()" style="padding-top:0px;cursor:pointer;width:15%;" title="Employee Not Assessed on Excel"></img></td>-->
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
          <h3 class="box-title"><?php echo"<b>Update Superior</b>";?></h3>
        </div>
        <div class="box-body">
			<table id="daftar_table" class="table table-bordered table-striped">
				<thead>
				  <tr>
					<th style="width: 10px">No</th>
				    <th>NIK</th>
				    <th>Nama</th>
				    <th>Lokasi</th>
				    <th>Superior 1</th>
				    <th>Superior 2</th>
					<th>Superior 3</th>
					<th>Action</th>
				  </tr>
				</thead>
				<tbody>
					<?php					
					$no = 1;
					$yearnow	= Date('Y');
					$cutoff		= $yearnow."-07-01";

					$sql = "SELECT DISTINCT ats.idkar, ats.id_atasan1, k.nik_baru, k.Nama_Lengkap, ka1.Nama_Lengkap as atasan1, ka2.Nama_Lengkap as atasan2, ka3.Nama_Lengkap as atasan3, do.Nama_OU  FROM `atasan` as ats
					left join $karyawan as k on k.id=ats.idkar
					left join $karyawan as ka1 on ka1.id=ats.id_atasan1
					left join $karyawan as ka2 on ka2.id=ats.id_atasan2
					left join $karyawan as ka3 on ka3.id=ats.id_atasan3
					left join daftardepartemen dpt on k.Kode_Departemen = dpt.Kode_Departemen 
					left join daftarou do on k.Kode_OU = do.Kode_OU
					left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
					left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan
					where 
					k.Kode_StatusKerja<>'SKH05' $where ORDER BY ats.id_atasan1 asc";
					$stmt = $koneksi->prepare($sql);
					$stmt->execute();
					
					while($scekkar = $stmt->fetch(PDO::FETCH_ASSOC)){
					?>
					<tr>
						<td><?php echo "$no"; ?></td>
						<td><?php echo "$scekkar[nik_baru]"; ?></td>
						<td><?php echo "$scekkar[Nama_Lengkap]"; ?></td>
						<td><?php echo "$scekkar[Nama_OU]"; ?></td>
						<td><?php echo "$scekkar[atasan1]"; ?></td>
						<td><?php echo "$scekkar[atasan2]"; ?></td>
						<td><?php echo "$scekkar[atasan3]"; ?></td>
						<td><button class="label label-primary" data-toggle="modal" data-target="#modalupload" data-backdrop="static" data-id="<?php echo $scekkar['idkar'];?>"><i class="fa fa-pencil"></i></button>
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
<div class="modal fade" id="modalupload" tabindex="-1" class="modal" role="dialog" >
	<div class="modal-dialog" style="width:60%">
	  <!-- konten modal-->
	  <div class="modal-content">
		<!-- heading modal -->
		<div align="center" class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <label style="padding-left: 10px">Update Superior</label><br>
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
                url : 'set_modal.php',
                data :  'kode=update_superior&id='+ id,
                success : function(data){
                $('.modal-data').html(data);//menampilkan data ke dalam modal
                // console.log(data);
                }
            });
         });
    }); 
	function isi_atasan1(){
		var ida1 = $("#ida1").val();
		$.ajax({
			url: 'set_modal.php',
			data:"ida1="+ida1+"&asal=email1",
		}).success(function (data) {
			var json = data,
			obj = JSON.parse(json);
			$('#email1').val(obj.email1);
		});
	};
	function isi_atasan2(){
		var ida2 = $("#ida2").val();
		$.ajax({
			url: 'set_modal.php',
			data:"ida2="+ida2+"&asal=email2",
		}).success(function (data) {
			var json = data,
			obj = JSON.parse(json);
			$('#email2').val(obj.email2);
		});
	};
	function isi_atasan3(){
		var ida3 = $("#ida3").val();
		$.ajax({
			url: 'set_modal.php',
			data:"ida3="+ida3+"&asal=email3",
		}).success(function (data) {
			var json = data,
			obj = JSON.parse(json);
			$('#email3').val(obj.email3);
		});
	};
</script>