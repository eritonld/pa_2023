<?php
include("conf/conf.php");
include("tabel_setting.php");
include("function.php");

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

try {
    $queryCultureTitle = "SELECT title FROM question_pa WHERE `group` = 'culture' GROUP BY title ORDER BY `id` ASC";

    $stmtCultureTitle = $koneksi->prepare($queryCultureTitle);
    $stmtCultureTitle->execute();

	$cultureTitles = array(); // Create an empty array to store titles

    while ($row = $stmtCultureTitle->fetch(PDO::FETCH_ASSOC)) {
        $cultureTitles[] = $row['title']; // Store each title in the array
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$role='spv'; 

try {
    $queryLeadershipTitle = "SELECT title FROM question_pa WHERE `group` = 'leadership' AND `role`='$role' GROUP BY title ORDER BY `id` ASC";

    $stmtLeadershipTitle = $koneksi->prepare($queryLeadershipTitle);
    $stmtLeadershipTitle->execute();

	$leadershipTitles = array(); // Create an empty array to store titles

    while ($row = $stmtLeadershipTitle->fetch(PDO::FETCH_ASSOC)) {
        $leadershipTitles[] = $row['title']; // Store each title in the array
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
	$title_comment='Direct Manager Comment';
	$comment_placeholder='input your comment';
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
	$title_comment='Komentar Atasan Langsung';
	$comment_placeholder='masukkan komentar anda';
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
                $culture = $item['culture'];
                $leadership = $item['leadership'];
                $jumlah_subo = $item['jumlah_subo'];
                $fortable = $item['fortable'];
                $comment_a1 = $item['comment_a1'];
                $rating_a1 = $item['rating_a1']==0 ? $total_score : $item['rating_a1'];
            }
				$fortable = $fortable != "staff" ? $fortable : ($jumlah_subo > 0 ? "staffb" : "staff");
		
				if($fortable=='nonstaff')
				{
					$step = 2;
				}
				else if($fortable=='staff')
				{
					$step = $scekuser['id']==$ckaryawan['idkar'] ? 1 : 2;
				}
				else if($fortable=='staffb')
				{
					$step = $scekuser['id']==$ckaryawan['idkar'] ? 1 : 3;
				}
				else if($fortable=='managerial')
				{
					$step = $scekuser['id']==$ckaryawan['idkar'] ? 1 : 3;
				}

				if($step==1){
					$margin = array('','margin: auto','','margin: auto');
					$steptitle = array('','Self Review');
				}else if($step==2){
					$margin = array('','margin-left: 0','margin-right: 0','margin: auto');
					$steptitle = array('','Self Review','Culture');
				}else{
					$margin = array('','margin-left: 0','margin: auto','margin-right: 0');
					$steptitle = array('','Self Review','Culture','Leadership');
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
<link href="dist/css/stepper.css" rel="stylesheet" type="text/css" />
<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="dist/js/stepper.js"></script>

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
	<form name="updateAppraisal" id="updateAppraisal" method="POST" action="apiController.php?code=updateNilaiAwal" onsubmit="return cekEmptyValue()">
		<input type="hidden" name="pic" value="<?="$scekuser[pic]";?>">
		<input type="hidden" id="idpic" name="idpic" value="<?="$scekuser[id]";?>">
		<input type="hidden" id="idkar" name="idkar" value="<?="$idkar";?>">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?="<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
			<!-- start stepper -->
<section class="signup-step-container">
  <div class="container-fluid">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10">
        <div class="wizard">
		<div class="wizard-inner">
            <div class="connecting-line" style="display: <?= $step==1 ? "none" : ""; ?>;"></div>
            <ul class="nav nav-tabs" role="tablist">
			<?php 
			for ($i=1; $i <= $step; $i++) { 
			?>
				<li role="presentation" style="<?= $margin[$i]; ?>;" class="<?= $i==1 ? "active" : ""; ?>">
				  <a href="#step<?= $i; ?>" data-toggle="tab" aria-controls="step<?= $i; ?>" role="tab" aria-expanded="true"><span class="round-tab"><?= $i; ?> </span> <i><?= $steptitle[$i]; ?></i></a>
				</li>
			<?php
			} 
			?>
            </ul>
          </div>
            <div class="tab-content" id="main_form">
				<!-- Self Review Start -->
              <div class="tab-pane active" role="tabpanel" id="step1">
                <h4 class="text-center">Self Review</h4>
                <div class="row">
					<div class="container-fluid" id="container">
						<div class="row" style="margin-top: 20px;">
							<h1 class="col-md-3 text-bold h4">A. <?= $title_a; ?></h1>
						</div>
						<div class="row" style="margin-top: 10px; margin-bottom: 20px;">
							<h1 class="col-md-3 text-bold h5"><?= $title_aa; ?></h1>
						</div>
						<?php for ($i=1; $i <= 5; $i++) { 
						?>
						<div class="row" id="row-<?= $i; ?>" style="margin-bottom: 40px;">
							<div class="form-horizontal">
								<label for="value<?= $i; ?>" class="col-md-1 control-label"><?= $i.'.'; ?></label>
								<div class="col-md-9">
									<!-- <input type="test" class="form-control" id="value<?= $i; ?>" placeholder="..."> -->
									<textarea class="form-control" name="value<?= $i; ?>" id="value<?= $i; ?>" style="resize: none; height: 100px;" placeholder="..."><?= $objective['value'.$i]; ?></textarea>
								</div>
								<div class="col-md-2">
									<select class="form-control" name="score<?= $i; ?>" id="score<?= $i; ?>">
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
						<div class="row" style="margin-top: 10px;">
							<div class="form-horizontal">
								<div class="col-md-offset-1 col-md-2" style="padding-right: 0;">
									<h1 class="h4 text-bold">Average Score :</h1>
								</div>
								<div class="col-md-2" style="padding-left: 0;">
									<input type="text" name="total_score" id="total_score" class="form-control text-center text-bold" style="background: #FFFFCC;" value="<?= $total_score; ?>" readonly>
								</div>
								<div class="col-md-2" style="padding-left: 0;">
									<input type="text" name="rating" id="rating" class="form-control text-center text-bold" value="<?= convertRating($rating_a1); ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: 50px; display: <?= $scekuser['id']===$idkar ? 'none' : '';?>">
							<div class="form-horizontal">
								<div class="col-md-offset-1 col-md-6" style="padding-right: 0;">
									<h1 class="h5 text-bold"><?= $title_comment; ?> : </h1>
									<textarea class="form-control" name="comment" id="comment" style="resize: none; height: 100px; background: #FFFFCC;" placeholder="<?= $comment_placeholder; ?>..."><?= $comment_a1; ?></textarea>
								</div>
							</div>
						</div>
					</div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="button" class="btn btn-success <?= $step==1 ? "final-step-1" : "next-step-1"; ?>"><?= $step==1 ? "Update" : "Continue to next step"; ?></button></li>
                </ul>
              </div>
			<!-- Self Review End -->
              <div class="tab-pane" role="tabpanel" id="step2">
                <h4 class="text-center">Culture Value of SIGAP</h4>
				<div class="row">
					<div class="container-fluid container-culture">
						<?php 
						foreach ($cultureTitles as $title) {
						?>
							<!-- // Process the data here -->
							<div class="row" style="margin-top: 50px; margin-bottom: 20px;">
								<h1 class="col-md-5 text-bold h4 culture"><?= $title; ?></h1>
							</div>
						<?php
							try {
								$queryCulture = "SELECT * FROM question_pa WHERE `group` = 'culture' AND title='$title' ORDER BY `id` ASC";
							
								$stmtCulture = $koneksi->prepare($queryCulture);
								$stmtCulture->execute();
							
								$cultureValue = $stmtCulture->fetchAll(PDO::FETCH_ASSOC);
							
								$totalRows = $stmtCulture->rowCount();
								$no = 1;

							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
							}
							$x = 1;
							foreach ($cultureValue as $data) { 
							$cNumber = $x++;
							?>
								<div class="row" style="margin-bottom: 20px;">
									<div class="col-md-9">
										<span class="h4"><?= $data['item']; ?></span>
									</div>
									<div class="col-md-3">
										<select class="form-control" name="<?= $data['name'].$cNumber; ?>">
											<option value="">- scale -</option>
											<option value="1" <?= $culture[$data['name'].$cNumber]==1 ? 'selected' : ''; ?>>Basic</option>
											<option value="2" <?= $culture[$data['name'].$cNumber]==2 ? 'selected' : ''; ?>>Comprehension</option>
											<option value="3" <?= $culture[$data['name'].$cNumber]==3 ? 'selected' : ''; ?>>Practitioner</option>
											<option value="4" <?= $culture[$data['name'].$cNumber]==4 ? 'selected' : ''; ?>>Advanced</option>
											<option value="5" <?= $culture[$data['name'].$cNumber]==5 ? 'selected' : ''; ?>>Expert</option>
										</select>
									</div>
								</div>
							<?php
							}
						}
						?>
					</div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="button" class="btn btn-default prev-step">Back</button></li>
                  <li><button type="button" class="btn btn-success <?= $step==2 ? "final-step-2" : "next-step-2"; ?>"><?= $step==2 ? "Update" : "Continue"; ?></button></li>
                </ul>
              </div>
              <div class="tab-pane" role="tabpanel" id="step3">
			  <h4 class="text-center">Employee Leadership</h4>
				<div class="row" style="margin-bottom: 30px;">
					<div class="container-fluid container-leadership">
							<!-- // Process the data here -->
							<?php 
							$y = 1;
							foreach ($leadershipTitles as $title) {
							$lNumber = $y++;
							?>
							<div class="row" style="margin-top: 30px; margin-bottom: 5px;">
								<h1 class="col-md-3 text-bold h4"><?= $title; ?></h1>
							</div>
							<?php
							try {
								$queryLeadership = "SELECT * FROM question_pa WHERE `group` = 'leadership' AND title='$title' AND `role`='$role' ORDER BY `id` ASC";
								$stmtLeadership = $koneksi->prepare($queryLeadership);
								$stmtLeadership->execute();
							
								$leadershipValue = $stmtLeadership->fetchAll(PDO::FETCH_ASSOC);
							
								$totalRows = $stmtLeadership->rowCount();

							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
							}
								
							foreach ($leadershipValue as $data) { 
								?>
								<div class="row">
									<div class="col-md-9">
										<span class="h4"><?= $data['item']; ?></span>
									</div>
									<div class="col-md-3">
										<select class="form-control" name="<?= $data['name'].$lNumber; ?>">
											<option value="">- scale -</option>
											<option value="1" <?= $leadership[$data['name'].$lNumber]==1 ? 'selected' : ''; ?>>Basic</option>
											<option value="2" <?= $leadership[$data['name'].$lNumber]==2 ? 'selected' : ''; ?>>Comprehension</option>
											<option value="3" <?= $leadership[$data['name'].$lNumber]==3 ? 'selected' : ''; ?>>Practitioner</option>
											<option value="4" <?= $leadership[$data['name'].$lNumber]==4 ? 'selected' : ''; ?>>Advanced</option>
											<option value="5" <?= $leadership[$data['name'].$lNumber]==5 ? 'selected' : ''; ?>>Expert</option>
										</select>
									</div>
								</div>
								<?php
								}
							}
							?>
					</div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="button" class="btn btn-default prev-step">Back</button></li>
				  <li><button type="button" class="btn btn-success final-step">Update</button></li>                
				</ul>
              </div>
              <div class="clearfix"></div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end stepper -->

		</div>
	</div>
</form>

</section>
</div>
<script>
	function checkSelfReview(value) {
            // Loop through the textareas
			let emptyFieldFound = false;
			let textValue = document.getElementById('value1').value;
			let idPic = document.getElementById('idpic').value;
			let idKar = document.getElementById('idkar').value;
			let commentA1 = document.getElementById('comment');
			if (textValue.trim() === '') {
				alert('Please fill in the field.');
				document.getElementById('value1').focus();
				return false; // Prevent form submission
			}
            for (let i = 1; i <= 5; i++) {
                let textareaValue = document.getElementById('value' + i).value;
                let scoreValue = document.getElementById('score' + i).value;
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
			if (!commentA1.value&&idPic!=idKar){
				alert('Please fill Komentar Atasan Langsung.');
				commentA1.focus();
				return false;
			}
            if(value=='final'){
				let confirm = window.confirm("Penilaian akan di Submit, klik OK untuk melanjutkan dan klik Cancel apabila ada yang belum sesuai.");
				if (confirm){
					document.getElementById('updateAppraisal').submit();
				}
			}
			return true;
        }
		function checkCulture(value) {
			let cultureContainer = document.querySelector('.container-culture');
			let selectElements = cultureContainer.querySelectorAll('select');
			let foundEmpty = false;

			for (let i = 0; i < selectElements.length; i++) {
				let selectElement = selectElements[i];

				if (selectElement.value === "") {
					foundEmpty = true;
					alert("Please select a value for " + selectElement.name);
					selectElement.focus();
					break; // Exit the loop after displaying the first alert
				}
			}

			if (!foundEmpty) {
				if(value=='final'){
					let confirm = window.confirm("Penilaian akan di Submit, klik OK untuk melanjutkan dan klik Cancel apabila ada yang belum sesuai.");
					if (confirm){
						document.getElementById('updateAppraisal').submit();
					}
				}
				return true;
			}
		}
		function checkLeadership() {
			let cultureContainer = document.querySelector('.container-leadership');
			let selectElements = cultureContainer.querySelectorAll('select');
			let foundEmpty = false;

			for (let i = 0; i < selectElements.length; i++) {
				let selectElement = selectElements[i];

				if (selectElement.value === "") {
					foundEmpty = true;
					alert("Please select a value for " + selectElement.name);
					selectElement.focus();
					break; // Exit the loop after displaying the first alert
				}
			}

			if (!foundEmpty) {
				let confirm = window.confirm("Penilaian akan di Update, klik OK untuk melanjutkan dan klik Cancel apabila ada yang belum sesuai.");
				if (confirm){
					document.getElementById('updateAppraisal').submit();
				}
			}
			return false;
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

        let average = count === 0 ? 0 : total / count;
		let decimalValue = average.toFixed(2);
		if (decimalValue >= 4.50) {
			var roundValue = Math.ceil(decimalValue);
		} else if (decimalValue >= 3.50) {
			roundValue = 4;
		} else if (decimalValue >= 2.50) {
			roundValue = 3;
		} else if (decimalValue >= 1.50) {
			roundValue = 2;
		} else {
			roundValue = Math.floor(decimalValue);
		}
		let rating = roundValue == 0 ? "" : (roundValue == 1 ? "E" : (roundValue == 2 ? "D" : (roundValue == 3 ? "C" : (roundValue == 4 ? "B" : "A"))));

        // Update the input element with the result
        document.getElementById('total_score').value = decimalValue; // Displaying the average with 2 decimal places
        document.getElementById('rating').value = rating; // Displaying the average with 2 decimal places
    }
</script>