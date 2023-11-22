<?php
if (isset($_COOKIE['id'])) {
	$idmaster_pa = $_COOKIE['id'];
	$pic = $_COOKIE['pic'];
	// Use $id and $pic to maintain the session or personalize content
  } else {
	?>
	  <script>
		  alert('Your session has ended, please Signin');
		  window.location= '<?= "$base_url"; ?>';
	  </script>
	  <?php
  }
include("tabel_setting.php");
include("function.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

if(!$id)
{
?>
<script>
	document.location='home.php?link=mydata';
</script>";
<?php
}
try {
    $sql = "SELECT k.id AS idkar, k.NIK, k.Nama_Lengkap, k.Mulai_Bekerja, dp.Nama_Perusahaan, dep.Nama_Departemen, dg.fortable, dg.Nama_Golongan, dg.fortable, k.Nama_Jabatan, du.Nama_OU, a1.id_atasan AS id_atasan1, a2.id_atasan AS id_atasan2, ka1.email AS email_atasan1, ka2.email AS email_atasan2, k.pen_q1, k.pen_q2, k.pen_q3, k.pen_q4, k.pen_q5, k.pen_q6, k.pen_q7, k.pen_q8, k.pen_q9, k.pen_q10, k.pen_q11, k.pen_q12 , (
		SELECT COUNT(idkar)
		FROM atasan
		WHERE id_atasan = :id AND layer = 'L1') AS jumlah_subo
		FROM $karyawan AS k
		LEFT JOIN daftarperusahaan AS dp ON k.Kode_Perusahaan = dp.Kode_Perusahaan
		LEFT JOIN daftardepartemen AS dep ON k.Kode_Departemen = dep.kode_departemen
		LEFT JOIN daftargolongan AS dg ON k.Kode_Golongan = dg.Kode_Golongan
		LEFT JOIN daftarjabatan AS dj ON k.Kode_Jabatan = dj.Kode_Jabatan
		LEFT JOIN daftarou AS du ON k.Kode_OU = du.Kode_OU
		LEFT JOIN atasan AS a1 ON a1.idkar= k.id AND a1.layer = 'L1'
		LEFT JOIN atasan AS a2 ON a2.idkar= k.id AND a2.layer = 'L2'
		LEFT JOIN $karyawan AS ka1 ON ka1.id= a1.id_atasan
		LEFT JOIN $karyawan AS ka2 ON ka2.id= a2.id_atasan
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
			$step = 2;
		}
		else if($fortable=='staffb')
		{
			$step = 3;
		}
		else if($fortable=='managerial')
		{
			$step = 3;
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
<div id="loader" class="proses" style="display: none"></div>
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
<form name="addAppraisal" id="addAppraisal" method="POST" action="apiController.php?code=submitNilaiAwal">
	<input type="hidden" name="pic" value="<?="$scekuser[pic]";?>">
	<input type="hidden" id="idpic" name="idpic" value="<?="$scekuser[id]";?>">
	<input type="hidden" id="idkar" name="idkar" value="<?="$ckaryawan[idkar]";?>">
	<input type="hidden" name="id_atasan" value="<?="$ckaryawan[id_atasan1]";?>" readonly />
	<input type="hidden" name="email_atasan" value="<?="$ckaryawan[email_atasan1]";?>" readonly />
	<input type="hidden" name="fortable" id="fortable" value="<?="$fortable";?>" readonly />
	<input type="hidden" name="layer" id="layer" value="L1" readonly />
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
			  <?php include 'self_review_description.php'; ?>
                <h4 class="text-center text-bold">Self Review</h4>
                <div class="row">
					<div class="container-fluid" id="container">
						<div class="row" style="margin-top: 20px;">
							<h1 class="col-md-3 text-bold h4">A. <?= $title_a; ?></h1>
						</div>
						<?php
						$quartal = "";
						
						if($ckaryawan['pen_q1']<>""){
							$quartal = $quartal."Q1 : <b>$ckaryawan[pen_q1]</b>";
						}
						if($ckaryawan['pen_q2']<>""){
							$quartal = $quartal." / Q2 : <b>$ckaryawan[pen_q2]</b>";
						}
						if($ckaryawan['pen_q3']<>""){
							$quartal = $quartal." / Q3 : <b>$ckaryawan[pen_q3]</b>";
						}
						if($ckaryawan['pen_q4']<>""){
							$quartal = $quartal." / Q4 : <b>$ckaryawan[pen_q4]</b>";
						}
						if($ckaryawan['pen_q5']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q5]</b>";
						}
						if($ckaryawan['pen_q6']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q6]</b>";
						}
						if($ckaryawan['pen_q7']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q7]</b>";
						}
						if($ckaryawan['pen_q8']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q8]</b>";
						}
						if($ckaryawan['pen_q9']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q9]</b>";
						}
						if($ckaryawan['pen_q10']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q10]</b>";
						}
						if($ckaryawan['pen_q11']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q11]</b>";
						}
						if($ckaryawan['pen_q12']<>""){
							$quartal = $quartal." / Q5 : <b>$ckaryawan[pen_q12]</b>";
						}
						
						if($quartal<>""){
							?>
							<div class="row" style="margin-top: 10px; margin-bottom: 20px;">
								<div class="col-md-1 text-bold">Quartal</div>
								<div class="col-md-4">: <?php echo "$quartal"; ?></div>
							</div>
							<?php
						}
						?>
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
						<div class="row hidden" style="margin-top: 10px;">
							<div class="form-horizontal">
								<div class="col-md-offset-1 col-md-2" style="padding-right: 0;">
									<h1 class="h4 text-bold">Average Score :</h1>
								</div>
								<div class="col-md-2" style="padding-left: 0;">
									<input type="text" name="total_score" id="total_score" class="form-control text-center text-bold" style="background: #FFFFCC;" value="-" readonly>
								</div>
								<div class="col-md-2" style="padding-left: 0;">
									<input type="hidden" name="rating" id="rating" class="form-control text-center text-bold"  value="-" readonly>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top: 50px; display: <?= $scekuser['id']===$ckaryawan['idkar'] ? 'none' : '';?>">
							<div class="form-horizontal">
								<div class="col-md-offset-1 col-md-6" style="padding-right: 0;">
									<h1 class="h5 text-bold"><?= $title_comment; ?> : </h1>
									<textarea class="form-control" name="comment" id="comment" style="resize: none; height: 100px; background: #FFFFCC;" placeholder="<?= $comment_placeholder; ?>..."></textarea>
								</div>
							</div>
						</div>
					</div>
                </div>
                <ul class="list-inline pull-right">
                  <li><button type="button" class="btn btn-success next-step-1">Continue to next step</button></li>
                </ul>
              </div>
			<!-- Self Review End -->
              <div class="tab-pane" role="tabpanel" id="step2">
			  <?php include 'culture_description.php'; ?>
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
				  <li><button type="button" class="btn btn-success <?= $step==2 ? "final-step-2" : "next-step-2"; ?>"><?= $step==2 ? "Submit" : "Continue"; ?></button></li>                
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
							$lNumber = $y++;
							if($bahasa=='eng'){ $item_leadership=$data['item_en']; }else{ $item_leadership=$data['item']; }
							?>
							<div class="row" style="margin-bottom: 20px;">
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
			// if (!commentA1.value&&idPic!=idKar){
			// 	alert('Please fill Komentar Atasan Langsung.');
			// 	commentA1.focus();
			// 	return false;
			// }			
			if(value=='final'){
				let confirm = window.confirm("Penilaian akan di Submit, klik OK untuk melanjutkan dan klik Cancel apabila ada yang belum sesuai.");
				if (confirm){
        			$('#loader').css('display', 'block');
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
						$('#loader').css('display', 'block');
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
					$('#loader').css('display', 'block');
					document.getElementById('addAppraisal').submit();
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

        // Calculate the average
        var average = count === 0 ? 0 : total / count;

		// Update the input element with the result
		document.getElementById('total_score').value = average;
    }
</script>