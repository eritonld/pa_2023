<?php
include("conf/conf.php");
include("tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$nama_atasan1 = isset($_GET['superior']) ? $_GET['superior'] : '';
$nama_atasan2 = isset($_GET['headsuperior']) ? $_GET['headsuperior'] : '';
$email_atasan1 = isset($_GET['superioremail']) ? $_GET['superioremail'] : '';
$email_atasan2 = isset($_GET['headsuperioremail']) ? $_GET['headsuperioremail'] : '';
$statbawah = isset($_GET['statbawah']) ? $_GET['statbawah'] : '';
$statmember = isset($_GET['statmember']) ? $_GET['statmember'] : '';

if($id=='')
{?>
	<script language="JavaScript">
		alert('Dilarang Refresh/Masukan NIK');
		document.location='home.php?link=dashboard';
	</script>
<?php	
exit;
}
try {
    $sql = "SELECT k.id AS idkar, k.NIK, k.Nama_Lengkap, k.Mulai_Bekerja, dp.Nama_Perusahaan, dep.Nama_Departemen, dg.Nama_Golongan, dg.fortable, k.Nama_Jabatan, du.Nama_OU, a.id_atasan1, a.id_atasan2, a.id_atasan3, a1.email as email_atasan1, a2.email as email_atasan2, a3.email as email_atasan3
            FROM $karyawan AS k
            LEFT JOIN daftarperusahaan AS dp ON k.Kode_Perusahaan = dp.Kode_Perusahaan
            LEFT JOIN daftardepartemen AS dep ON k.Kode_Departemen = dep.Kode_Departemen
            LEFT JOIN daftargolongan AS dg ON k.Kode_Golongan = dg.Kode_Golongan
            LEFT JOIN daftarjabatan AS dj ON k.Kode_Jabatan = dj.Kode_Jabatan
            LEFT JOIN daftarou AS du ON k.Kode_OU = du.Kode_OU
			LEFT JOIN atasan AS a ON a.idkar= k.id
			LEFT JOIN $karyawan AS a1 ON a1.id= a.id_atasan1
			LEFT JOIN $karyawan AS a2 ON a2.id= a.id_atasan2
			LEFT JOIN $karyawan AS a3 ON a3.id= a.id_atasan3
            WHERE k.id = :id";

    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    $ckaryawan = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ckaryawan) {
        // Process the data here
    } else {
        echo "No data found for the provided NIK.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if($ckaryawan['fortable']=='nonstaff')
{
	//$bahasa='ind';
	if($statmember=='Y'){
		$fortable='staff';
		if($bahasa=='eng')		
			$fortable_select='staff_english';
		else
			$fortable_select='staff';
	}else{
		$fortable='nonstaff';
		if($bahasa=='eng')		
			$fortable_select='nonstaff_english';
		else
			$fortable_select='nonstaff';
	}
}
else if($ckaryawan['fortable']=='staff')
{
	if($statbawah=='Y'){
		$fortable='staffb';
		if($bahasa=='eng')		
			$fortable_select='staffb_english';
		else
			$fortable_select='staffb';
	}else{
		$fortable='staff';
		if($bahasa=='eng')		
			$fortable_select='staff_english';
		else
			$fortable_select='staff';
	}
}
else if($ckaryawan['fortable']=='managerial')
{
	$fortable='managerial';
	if($bahasa=='eng')		
		$fortable_select='managerial_english';
	else
		$fortable_select='managerial';
		
	?>
	<div class="Top Nav Example">
		<marquee><h2 style="color:red;background-color:white;"> Sebagai Informasi, apabila proses penilaian dibiarkan terlalu lama maka Anda harus mengulang prosesnya dari awal. Dimohon untuk menyiapkan data-data yang diperlukan sebelum melakukan penilaian. Terima kasih</h2></marquee>
	</div>
	<?php
}


if($bahasa=='eng')
{
	$tabel_prosedure="prosedure_english";
	$a0='Employee Detail';
	$a1='Performance Appraisal';
	$a2='Employee Name';
	$a3='Company / Location';
	$a4='Employee ID';
	$a5='Division / Department';
	$a6='Designation';
	$a7='Section / SubSection';
	$a8='Join Date';
	$a9='Period of Assessment';
	$a10='Grade';
	$a11='SP/period';
	$a12='Rating';
	$a13='On Rating';
	$title_a='Work Results';
	$title_aa='Work Objectives';
	$add_btn_name='Objective';
	$alertRow='Sorry, you has reached maximum row.';
}
else
{	
	$tabel_prosedure="prosedure";
	$a0='Detail Karyawan';
	$a1='Penilaian Kinerja Karyawan';
	$a2='Nama Karyawan';
	$a3='Nama PT / Lokasi';
	$a4='NIK';
	$a5='Divisi / Departemen';
	$a6='Jabatan';
	$a7='Seksi / SubSeksi';
	$a8='TMK';
	$a9='Periode Penilaian';
	$a10='Golongan';
	$a11='SP/Periode';
	$a12='Bobot';
	$a13='Pembobotan';
	$title_a='Hasil Kerja';
	$title_aa='Objektif Kerja';
	$add_btn_name='Objektif';
	$alertRow='Maaf, kolom objektif sudah maksimal.';
}


try {
    $sql = "SELECT statussp, periode FROM sp_2022 WHERE `id` = :id";
    
    $stmt = $koneksi->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    $cgetsp = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cgetsp) {
        // Process the data here
    } else {
        // echo "No data found for the provided NIK.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$statussp = isset($cgetsp['statussp']) ? $cgetsp['statussp'] : '';
$periode = isset($cgetsp['periode']) ? $cgetsp['periode'] : '';
?>
<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('dist/img/ellipsis.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
</style>
<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

<!-- +"&id_atasan1="+id_atasan1+"&email_atasan1="+email_atasan1+"&id_atasan2="+id_atasan2+"&email_atasan2="+email_atasan2+"&id_atasan3="+id_atasan3+"&email_atasan3="+email_atasan3 -->

<div class="row">
<div id="proses" class="proses" style="display: none"></div>
<section class="col-lg-12">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?="<b>$a0</b>";?></h3>
        </div>
        <div class="box-body">
			<div class="container-fluid">
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-2 text-bold"><?="$a2";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Nama_Lengkap]";?></div>
					<div class="col-md-2 text-bold"><?="$a3";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Nama_Perusahaan] / $ckaryawan[Nama_OU]";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a4";?></div>
					<div class="col-md-4">: <?="$ckaryawan[NIK]";?></div>
					<div class="col-md-2 text-bold"><?="$a5";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Nama_Departemen]";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a6";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Nama_Jabatan]";?></div>
					<div class="col-md-2 text-bold"><?="$a7";?></div>
					<div class="col-md-4">: <?="-";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a8";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Mulai_Bekerja]";?></div>
					<div class="col-md-2 text-bold"><?="$a9";?></div>
					<div class="col-md-4">: <?= Date('Y');?></div>
				</div>
				<div class="row" style="margin-top: 10px; margin-bottom: 20px;">
					<div class="col-md-2 text-bold"><?="$a10";?></div>
					<div class="col-md-4">: <?="$ckaryawan[Nama_Golongan]";?></div>
					<div class="col-md-2 text-bold"><?="$a11";?></div>
					<div class="col-md-4">: <?="$statussp / $periode";?></div>
				</div>				
			</div>
			<?php
			if($fortable=='managerial')
			{
				if($bahasa=='eng')
				{
					$a14='SECTION II SELF-EVALUATION';
					$a15='Describe your primary duties and additional work (if any) undertaken';
					$a16='Provide a self-assessment of your performance in the past year and suggest areas of improvement';
				}
				else
				{
					$a14='BAGIAN II PENILAIAN DIRI';
					$a15='Tuliskan tugas utama Anda dan tugas tambahan (jika ada)';
					$a16='Berikan penilaian terhadap diri Anda atas kinerja pada tahun lalu dan usulan area mana yang perlu diperbaiki.';
					
				}
			?>
			<tr>
				<th colspan="4" style="border:none;"><?="$a14";?></th> 
			</tr>
			<tr>
				<th colspan="4" style="border:none;">1. <?="$a15";?><br />
				<textarea name="tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control"></textarea>
				</th> 
			</tr>
			<tr>
				<th colspan="4" style="border:none;">2. <?="$a16";?><br />
				<textarea name="penilaian_tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control"></textarea></th> 
			</tr>
			<?php
			}?>
        </div>
    </div>
	<form name="forminput" method="POST" action="apiController.php?code=submitNilaiAwal" onsubmit="return cekEmptyValue()">
	<input type="hidden" name="pic" value="<?="$scekuser[pic]";?>">
	<input type="hidden" name="idpic" value="<?="$scekuser[id]";?>">
	<input type="hidden" name="idkar" value="<?="$ckaryawan[idkar]";?>">
	<input type="hidden" name="id_atasan1" value="<?="$ckaryawan[id_atasan1]";?>" readonly />
	<input type="hidden" name="email_atasan1" value="<?="$ckaryawan[email_atasan1]";?>" readonly />
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?="<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
			<div class="container-fluid" id="container">
				<div class="row" style="margin-top: 20px;">
					<h1 class="col-md-2 text-bold h4">A. <?= $title_a; ?></h1>
				</div>
				<div class="row" style="margin-top: 10px; margin-bottom: 20px;">
					<h1 class="col-md-2 text-bold h5"><?= $title_aa; ?></h1>
				</div>
				<?php for ($i=1; $i <= 5; $i++) { 
				?>
				<div class="row" id="row-<?= $i; ?>" style="margin-bottom: 40px;">
					<div class="form-horizontal">
						<label for="value<?= $i; ?>" class="col-md-1 control-label"><?= $i.'.'; ?></label>
						<div class="col-md-8">
							<!-- <input type="test" class="form-control" id="value<?= $i; ?>" placeholder="..."> -->
							<textarea class="form-control" name="value<?= $i; ?>" id="value<?= $i; ?>" style="resize: none; height: 100px;" placeholder="..."></textarea>
						</div>
						<div class="col-md-2">
							<select class="form-control" name="score<?= $i; ?>" id="score<?= $i; ?>">
								<option value="">- score -</option>
								<option value="5">5</option>
								<option value="4">4</option>
								<option value="3">3</option>
								<option value="2">2</option>
								<option value="1">1</option>
							</select>
						</div>
					</div>
				</div>
				<script>
					// Add an event listener to the select element
					document.getElementById('score<?= $i; ?>').addEventListener('change', function () {
						calculateAverage();
					});
				</script>
				<?php
				} ?>
			</div>
			<div class="container-fluid" style="margin-bottom: 20px;">
				<div class="row" style="margin-top: 10px; display: none;">
					<div class="form-horizontal">
						<div class="col-md-offset-1 col-md-8">
						<button type="button" class="btn btn-success btn-sm" id="addRow" onclick="addRows(this)"><i class="fa fa-plus"></i></button>
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="form-horizontal">
						<div class="col-md-offset-1 col-md-2" style="padding-right: 0;">
							<h1 class="h4">Average Score : </h1>
						</div>
						<div class="col-md-2" style="padding-left: 0;">
							<input type="text" name="total_score" id="total_score" class="form-control text-center text-bold" style="background: #FFFFCC;" value="-" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="container-fluid">
				<div class="row text-center">
					<button type="submit" class="btn btn-primary text-bold" style="width: 20%; margin-block: 10px;">SUBMIT</button>
				</div>
			</div>
		</div>
	</div>
	</form>

</section>
</div>
<script>
        function cekEmptyValue() {
            // Loop through the textareas
			var emptyFieldFound = false;
			var textValue = document.getElementById('value1').value;
			if (textValue.trim() === '') {
				alert('Please fill in the field.');
				document.getElementById('value1').focus();
				return false; // Prevent form submission
			}
            for (var i = 1; i <= 5; i++) {
                var textareaValue = document.getElementById('value' + i).value;
                var scoreValue = document.getElementById('score' + i).value;
                if (textareaValue.trim() != '' && scoreValue === '' || textareaValue.trim() === '' && scoreValue != '') {
					if(scoreValue === ''){
						alert('Please select the score.');
						document.getElementById('score' + i).focus();
					}
					if(textareaValue.trim() === ''){
						alert('Please fill in the field.');
						document.getElementById('value' + i).focus();
					}
					emptyFieldFound = true;
                    return false; // Prevent form submission
                }
            }
            return true; // Allow form submission
        }
    </script>
<script>
  
  var currentRow = <?= $i; ?>; // Initialize with the last value of $i
  var alertRow = '<?= $bahasa=='eng' ? 'Sorry, you has reached maximum row.' : 'Maaf, kolom objektif sudah maksimal.'; ?>';

  // Function to show an alert
  function addRow() {
	var newRow = `
	<div class="row" id="row-${currentRow}" style="margin-top: 10px;">
	  <div class="form-horizontal">
		<label for="value${currentRow}" class="col-md-1 control-label">${currentRow}.</label>
		<div class="col-md-8">
		  <input type="text" class="form-control" id="value${currentRow}" placeholder="...">
		</div>
		<div class="col-md-2">
		  <select class="form-control" name="score${currentRow}" id="score${currentRow}" required>
			<option value="">- pilih -</option>
			<option value="5">5</option>
			<option value="4">4</option>
			<option value="3">3</option>
			<option value="2">2</option>
			<option value="1">1</option>
		  </select>
		</div>
		<div class="col-md-1">
          <button type="button" id="button1" onclick="deleteRow(this)" class="btn btn-danger btn-sm btn-circle" ><i class="fa fa-times"></i></button>
        </div>
	  </div>
	</div>
  `;
	if(currentRow>10){
		alert(alertRow);
		return;
	}
	$("#container").append(newRow); // Append the new row to the container
    currentRow++; // Increment the current row number
    }
	// Get the button element by its ID
	var button = document.getElementById("addRow");
	
	// Add a click event listener to the button
	button.addEventListener("click", addRow);


  function deleteRow(row) {
	let closestRow = $(row).closest('.row')
	let rowId = closestRow.attr('id')
	var rowParts = rowId.split('-');
	console.log(rowParts[1])
	
	closestRow.remove()
}
</script>
<script>
    function calculateAverage() {
        var total = 0;
        var count = 0;

        // Loop through the select elements and calculate the total
        for (var i = 1; i <= 5; i++) {
            var score = document.getElementById('score' + i).value;
            if (score !== "") {
                total += parseInt(score);
                count++;
            }
        }

        // Calculate the average
        var average = count === 0 ? 0 : total / count;

        // Update the input element with the result
        document.getElementById('total_score').value = average.toFixed(2); // Displaying the average with 2 decimal places
    }
</script>