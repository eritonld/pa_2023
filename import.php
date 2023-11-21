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
if(isset($_POST['add_pass'])){
	if($_POST['add_pass']=='T'){
		if(mysqli_query($koneksi, "start transaction"))
		{
			try
			{
			
			$passbaru	= $_POST['passbaru'];
			$passulang	= $_POST['passulang'];
            $pengacak	="HJBDSUYGQ783242BHJSSDFSD";
            
            $passmd5 = md5($pengacak . md5($passbaru) . $pengacak);
				
				if($passbaru==$passulang && $passbaru<>""){
					
					$update = mysqli_query($koneksi,"update user_pa set password='$passmd5' where id='$idmaster_pa'");
					
					if($update){
						$ket = "success";
						$isi_ket = "Sukses";
						$ket_isi = "Password baru berhasil diupdate";
					} else {
						$ket = "danger";
						$isi_ket = "Gagal";
						$ket_isi = "Password yang di isikan gagal tersimpan";
					}
				}else{
					$ket = "danger";
					$isi_ket = "Gagal";
					$ket_isi = "Password yang di isikan tidak sesuai";
				}
			
				if($update)
				{
					mysqli_query($koneksi, "COMMIT");
				}
				else
				{
					throw new Exception('Errorr');					
				}
			}
			catch(Exception $e)
			{
				mysqli_query($koneksi, "ROLLBACK");
				?>
				<script language="JavaScript">
					alert('Gagal');
				</script>
				<?php
			}
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
          <h3 class="box-title"><?php echo "Import Non Staff"; ?></h3>
        </div>
		<form role="form" method="post" action="">
        <div class="box-body">			
			<div class="form-group">
			  <label><?php echo "File"; ?></label>
			  <input type="file" id="userfile" name="userfile" requaired>
			  
			</div>
			<div class="form-group">
			  <input type="hidden" name="add_pass" value="T" />
			  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> <?php echo "Import"; ?></button>
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