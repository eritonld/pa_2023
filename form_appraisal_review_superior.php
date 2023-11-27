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
    $sql = "SELECT k.id AS idkar, k.NIK, k.Nama_Lengkap, k.Mulai_Bekerja, dp.Nama_Perusahaan, dep.Nama_Departemen, dg.fortable, dg.Nama_Golongan, dg.fortable, k.Nama_Jabatan, du.Nama_OU, a.id_atasan1, a.id_atasan2, a.id_atasan3, a1.email as email_atasan1, a2.email as email_atasan2, a3.email as email_atasan3, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan1 = :id OR id_atasan2 = :id OR id_atasan3 = :id) as jumlah_subo
            FROM $karyawan AS k
            LEFT JOIN daftarperusahaan AS dp ON k.Kode_Perusahaan = dp.Kode_Perusahaan
            LEFT JOIN daftardepartemen AS dep ON k.Kode_Departemen = dep.kode_departemen
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
		$fortable = $ckaryawan['fortable'] != "staff" ? $ckaryawan['fortable'] : ($ckaryawan['jumlah_subo'] > 0 ? "staffb" : "staff");
		
		if($fortable=='nonstaff')
		{
			$step = 2;
		}
		else if($fortable=='staff')
		{
			$step = 1;
		}
		else if($fortable=='staffb')
		{
			$step = 2;
		}
		else if($fortable=='managerial')
		{
			$step = 2;
		}

		if($step==1){
			$margin = array('','margin: auto','','margin: auto');
			$steptitle = array('','Culture','','');
		}else{
			$margin = array('','margin-left: 0','margin-right: 0','');
			$steptitle = array('','Culture','Leadership','');
		}

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


try {
    $queryLeadershipTitle = "SELECT title FROM question_pa WHERE `group` = 'leadership' AND `role`='$fortable' GROUP BY title ORDER BY `id` ASC";

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
.culture::first-letter {
  font-size: 150%;
  color: #BF2B26;
}
</style>
<link href="dist/css/stepper.css" rel="stylesheet" type="text/css" />
<script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="dist/js/stepper.js"></script>

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
        </div>
    </div>
<form name="addAppraisal" id="addAppraisal" method="POST" action="apiController.php?code=submitReviewSuperior">
	<input type="hidden" name="pic" value="<?="$scekuser[pic]";?>">
	<input type="hidden" id="idpic" name="idpic" value="<?="$scekuser[id]";?>">
	<input type="hidden" id="idkar" name="idkar" value="<?="$ckaryawan[idkar]";?>">
	<input type="hidden" name="id_atasan1" value="<?="$ckaryawan[id_atasan1]";?>" readonly />
	<input type="hidden" name="email_atasan1" value="<?="$ckaryawan[email_atasan1]";?>" readonly />
	<input type="hidden" name="fortable" id="fortable" value="<?="$fortable";?>" readonly />
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
				  <a class="disabled-tab" href="#step<?= $i; ?>" data-toggle="tab" aria-controls="step<?= $i; ?>" role="tab" aria-expanded="true"><span class="round-tab"><?= $i; ?> </span> <i><?= $steptitle[$i]; ?></i></a>
				</li>
			<?php
			} 
			?>
            </ul>
          </div>
            <div class="tab-content" id="main_form">
				<!-- Self Review Start -->
              <div class="tab-pane active" role="tabpanel" id="step1">
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
								$queryCulture = "SELECT * FROM question_pa WHERE `group` = 'culture' AND title='$title' AND `role`='$fortable' ORDER BY `id` ASC";
							
								$stmtCulture = $koneksi->prepare($queryCulture);
								$stmtCulture->execute();
							
								$cultureValue = $stmtCulture->fetchAll(PDO::FETCH_ASSOC);
							
								$totalRows = $stmtCulture->rowCount();
								$no = 1;

							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
							}
							foreach ($cultureValue as $data) { 
							if($bahasa=='eng'){ $item_culture=$data['item_en']; }else{ $item_culture=$data['item']; }
							?>
								<div class="row" style="margin-bottom: 20px;">
									<div class="col-md-9">
										<span class="h4"><?= $item_culture; ?></span>
									</div>
									<div class="col-md-3">
										<select class="form-control" name="<?= $data['name'].$no++; ?>">
											<option value="">- scale -</option>
											<option value="5">Expert</option>
                                        	<option value="4">Advanced</option>
                                        	<option value="3">Practitioner</option>
                                        	<option value="2">Comprehension</option>
                                        	<option value="1">Basic</option>
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
                  <li><button type="button" class="btn btn-default prev-step" onclick="window.location.href = '/hcis-pa-2023/home.php?link=mydata';">Cancel</button></li>
				  <li><button type="button" class="btn btn-success next-step-2">Continue to next step</button></li>                
				</ul>
              </div>
			<!-- Self Review End -->
              <div class="tab-pane" role="tabpanel" id="step2">
			  <h4 class="text-center">Employee Leadership</h4>
				<div class="row" style="margin-bottom: 30px;">
					<div class="container-fluid container-leadership">
							<!-- // Process the data here -->
							<?php 
							$y = 1;
							foreach ($leadershipTitles as $title) {
							
							?>
							<div class="row" style="margin-top: 30px; margin-bottom: 5px;">
								<h1 class="col-md-3 text-bold h4"><?= $title; ?></h1>
							</div>
							<?php
							try {
								$queryLeadership = "SELECT * FROM question_pa WHERE `group` = 'leadership' AND title='$title' AND `role`='$fortable' ORDER BY `id` ASC";
								$stmtLeadership = $koneksi->prepare($queryLeadership);
								$stmtLeadership->execute();
							
								$leadershipValue = $stmtLeadership->fetchAll(PDO::FETCH_ASSOC);
							
								$totalRows = $stmtLeadership->rowCount();

							} catch (PDOException $e) {
								echo "Error: " . $e->getMessage();
							}
							foreach ($leadershipValue as $data) { 
							if($bahasa=='eng'){ $item_leadership=$data['item_en']; }else{ $item_leadership=$data['item']; }
							$lNumber = $y++;
							?>
							<div class="row">
								<div class="col-md-9">
									<span class="h4"><?= $item_leadership; ?></span>
								</div>
								<div class="col-md-3">
									<select class="form-control" name="<?= $data['name'].$lNumber; ?>">
										<option value="">- scale -</option>
										<option value="1">Basic</option>
										<option value="2">Comprehension</option>
										<option value="3">Practitioner</option>
										<option value="4">Advanced</option>
										<option value="5">Expert</option>
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
                  <li><button type="button" class="btn btn-success final-step-3">Submit</button></li>
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
					document.getElementById('addAppraisal').submit();
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
						document.getElementById('addAppraisal').submit();
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
				let confirm = window.confirm("Penilaian akan di Submit, klik OK untuk melanjutkan dan klik Cancel apabila ada yang belum sesuai.");
				if (confirm){
					document.getElementById('addAppraisal').submit();
				}
			}
			return false;
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
        let total = 0;
        let count = 0;

        // Loop through the select elements and calculate the total
        for (let i = 1; i <= 5; i++) {
            let score = document.getElementById('score' + i).value;
            if (score !== "") {
                total += parseInt(score);
                count++;
            }
        }

        // Calculate the average
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