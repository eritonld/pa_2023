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
// try {
//     $sql = "SELECT k.id AS idkar, k.NIK, k.Nama_Lengkap, k.Mulai_Bekerja, dp.Nama_Perusahaan, dep.Nama_Departemen, dg.Nama_Golongan, dg.fortable, k.Nama_Jabatan, du.Nama_OU
//             FROM $karyawan AS k
//             LEFT JOIN daftarperusahaan AS dp ON k.Kode_Perusahaan = dp.Kode_Perusahaan
//             LEFT JOIN daftardepartemen AS dep ON k.Kode_Departemen = dep.Kode_Departemen
//             LEFT JOIN daftargolongan AS dg ON k.Kode_Golongan = dg.Kode_Golongan
//             LEFT JOIN daftarjabatan AS dj ON k.Kode_Jabatan = dj.Kode_Jabatan
//             LEFT JOIN daftarou AS du ON k.Kode_OU = du.Kode_OU
//             WHERE k.NIK = :nik";

//     $stmt = $koneksi->prepare($sql);
//     $stmt->bindParam(':nik', $id, PDO::PARAM_STR);
//     $stmt->execute();

//     $ckaryawan = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($ckaryawan) {
//         // Process the data here
//     } else {
//         echo "No data found for the provided NIK.";
//     }
// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }



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
	$a1='Penilaian Kinerja';
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

// try {
//     $sql = "SELECT statussp, periode FROM sp_2022 WHERE nik = :nik";
    
//     $stmt = $koneksi->prepare($sql);
//     $stmt->bindParam(':nik', $id, PDO::PARAM_STR);
//     $stmt->execute();

//     $cgetsp = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($cgetsp) {
//         // Process the data here
//     } else {
//         echo "No data found for the provided NIK.";
//     }
// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }

// $statussp = isset($cgetsp['statussp']) ? $cgetsp['statussp'] : '';
// $periode = isset($cgetsp['periode']) ? $cgetsp['periode'] : '';


$api_url = 'http://localhost:8080/hcis-pa-2023/apiController.php?code=getDataEditAwal&id='.$id; // Replace with your API endpoint URL

// Make an HTTP GET request to the API
$response = file_get_contents($api_url);

// Check if the request was successful
if ($response === false) {
    echo 'Failed to fetch data from the API.';
} else {
    // Parse the JSON response
    $data = json_decode($response, true);

    // Check if there's an error in the response
    if (isset($data['error'])) {
        echo 'API Error: ' . $data['error'];
    } else {
        // Process the retrieved data
        if (isset($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $item) {
                // Access individual data elements
                $id = $item['id'];
                $idkar = $item['idkar'];
                $name = $item['Nama_Lengkap'];
                $total_score = $item['total_score'];
                $periode = $item['periode'];
                $tmk = $item['tmk'];
                $nik = $item['nik_baru'] ? $item['nik_baru'] : $item['NIK'];
                $Nama_Lengkap = $item['Nama_Lengkap'];
                $Nama_Jabatan = $item['Nama_Jabatan'];
                $Nama_Golongan = $item['Nama_Golongan'];
                $Nama_OU = $item['Nama_OU'];
                $Nama_Departemen = $item['Nama_Departemen'];
                $Nama_Perusahaan = $item['Nama_Perusahaan'];
                $objective = $item['objective'];
                $score = $item['score'];
            }
        } else {
            echo 'No data found.';
        }
    }
}

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
					<div class="col-md-4">: <?="$name";?></div>
					<div class="col-md-2 text-bold"><?="$a3";?></div>
					<div class="col-md-4">: <?="$Nama_Perusahaan / $Nama_OU";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a4";?></div>
					<div class="col-md-4">: <?="$nik";?></div>
					<div class="col-md-2 text-bold"><?="$a5";?></div>
					<div class="col-md-4">: <?="$Nama_Departemen";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a6";?></div>
					<div class="col-md-4">: <?="$Nama_Jabatan";?></div>
					<div class="col-md-2 text-bold"><?="$a7";?></div>
					<div class="col-md-4">: <?="-";?></div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-2 text-bold"><?="$a8";?></div>
					<div class="col-md-4">: <?="$tmk";?></div>
					<div class="col-md-2 text-bold"><?="$a9";?></div>
					<div class="col-md-4">: <?= Date('Y');?></div>
				</div>
				<div class="row" style="margin-top: 10px; margin-bottom: 20px;">
					<div class="col-md-2 text-bold"><?="$a9";?></div>
					<div class="col-md-4">: <?="$Nama_Golongan";?></div>
					<div class="col-md-2 text-bold"><?="$a11";?></div>
					<div class="col-md-4">: <?="- / -";?></div>
				</div>				
			</div>
        </div>
    </div>
	<form name="formedit" method="POST" action="apiController.php?code=updateNilaiAwal" onsubmit="return cekEmptyValue()">
	<input type="hidden" name="idkar" value="<?="$idkar";?>">
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
							<textarea class="form-control" name="value<?= $i; ?>" id="value<?= $i; ?>" style="resize: none; height: 100px;" placeholder="..."><?= $objective['value'.$i]; ?></textarea>
						</div>
						<div class="col-md-2">
							<select class="form-control" style="background-color: #FFFFCC;" name="score<?= $i; ?>" id="score<?= $i; ?>">
								<option value="">- score -</option>
								<option value="5" <?= $score['score'.$i]==5 ? 'selected' : ''; ?>>5</option>
								<option value="4" <?= $score['score'.$i]==4 ? 'selected' : ''; ?>>4</option>
								<option value="3" <?= $score['score'.$i]==3 ? 'selected' : ''; ?>>3</option>
								<option value="2" <?= $score['score'.$i]==2 ? 'selected' : ''; ?>>2</option>
								<option value="1" <?= $score['score'.$i]==1 ? 'selected' : ''; ?>>1</option>
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
							<input type="text" name="total_score" id="total_score" class="form-control text-center text-bold" style="background: #FFFFCC;" value="<?= $total_score; ?>" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<div class="container-fluid">
				<div class="row text-center">
					<button type="submit" class="btn btn-primary text-bold" style="width: 20%; margin-block: 10px;">UPDATE</button>
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