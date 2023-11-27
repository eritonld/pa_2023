<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../dist/img/loading7.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
</style>
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
if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

if($bahasa=='eng'){
	$header="Change Password";
	$pass1="New Password";
	$pass2="Confirm Password";
	$save="Save";
}else{
	$header="Ubah Password";
	$pass1="Password Baru";
	$pass2="Tulis Ulang Password";
	$save="Simpan";
}
if (isset($_POST['add_pass'])) {
    if ($_POST['add_pass'] == 'T') {
        try {
            $passbaru = $_POST['passbaru'];
            $passulang = $_POST['passulang'];
            $pengacak = "HJBDSUYGQ783242BHJSSDFSD";

            $passmd5 = md5($pengacak . md5($passbaru) . $pengacak);

            if ($passbaru == $passulang && $passbaru <> "") {
                $koneksi->beginTransaction();

                $stmt = $koneksi->prepare("UPDATE user_pa SET password = :passmd5 WHERE id = :idmaster_pa");
                $stmt->bindParam(':passmd5', $passmd5, PDO::PARAM_STR);
                $stmt->bindParam(':idmaster_pa', $idmaster_pa, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $ket = "success";
                    $isi_ket = "Sukses";
                    $ket_isi = "Password baru berhasil diupdate";
                    $koneksi->commit();
                } else {
                    $ket = "danger";
                    $isi_ket = "Gagal";
                    $ket_isi = "Password yang diisikan gagal tersimpan";
                    $koneksi->rollBack();
                }
            } else {
                $ket = "danger";
                $isi_ket = "Gagal";
                $ket_isi = "Password yang diisikan tidak sesuai";
            }
        } catch (PDOException $e) {
            $koneksi->rollBack();
            ?>
            <script language="JavaScript">
                alert('Gagal');
            </script>
            <?php
        }
    }
}

?>
<div class="row">
<section class="col-lg-6 connectedSortable">
<?php
if(isset($_POST['add_pass'])){
	if($_POST['add_pass']=='T'){
	?>
	<div class="alert alert-<?php echo $ket; ?> alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<h4><?php echo $isi_ket; ?></h4>
		<p><?php echo $ket_isi; ?></p>
	</div>
	<?php
	}
}
?>
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo "$header"; ?></h3>
        </div>
		<form role="form" method="post" action="?link=gantipas">
        <div class="box-body">			
			<div class="form-group">
			  <label><?php echo "$pass1"; ?></label>
			  <input type="password" class="form-control" id="passbaru" name="passbaru" placeholder="<?php echo "$pass1"; ?>">
			</div>
			<div class="form-group">
			  <label><?php echo "$pass2"; ?></label>
			  <input type="password" class="form-control" id="passulang" name="passulang" placeholder="<?php echo "$pass2"; ?>">
			</div>
			<div class="form-group">
			  <input type="hidden" name="add_pass" value="T" />
			  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo "$save"; ?></button>
			</div>
        </div>
		</form>
    </div>
  </div>
</section>
</div>

<script type="text/javascript" src="../plugins/jquery.min.js"></script>
<script type="text/javascript" src="../plugins/moment.min.js"></script>
<script type="text/javascript" src="../plugins/raphael-min.js"></script>
<script src="../plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="../plugins/chartjs/Chart.min.js" type="text/javascript"></script>
<script src="../plugins/bootstrap-select.js"></script>