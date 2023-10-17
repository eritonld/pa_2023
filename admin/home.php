<?php
include("../conf/conf.php");
include("tabel_setting.php");

session_start();

if(isset($_SESSION["idmaster_pa_admin"])){
	$idmaster_pa_admin=$_SESSION["idmaster_pa_admin"];
}else{
	$idmaster_pa_admin="";
}

if ($idmaster_pa_admin=="")
{
	?>
	<script>
		alert('Login First');
		window.location="http://localhost/pa_2023/admin/";
	</script>
	<?php
}

// $cekuser=mysqli_query($koneksi,"select * from user_pa_admin where id='$idmaster_pa_admin'");
// $scekuser=mysqli_fetch_array($cekuser);
try {
	$sql = "SELECT * FROM user_pa_admin WHERE id = :id";
	$stmt = $koneksi->prepare($sql);
	$stmt->bindParam(':id', $idmaster_pa_admin, PDO::PARAM_INT);
	$stmt->execute();
	$scekuser = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$link = $_GET['link'];

$menudataapp		= "deactive";
$menunotassessed	= "deactive";
$menudataemp		= "deactive";
$menudatareport		= "deactive";

if ($link=="dataapp")
{
  $includefile		= "allappraisal.php";
  $menudataapp		= "active";
  $linkmark			= " > All Data Appraisal";
}
else if ($link=="notassessed")
{
  $includefile		= "employeenotassessed.php";
  $menunotassessed	= "active";	
  $linkmark			= " > Employee Not Assessed";
}
else if ($link=="dataemp")
{
  $includefile		= "alldataemployee.php";
  $menudataemp		= "active";	
  $linkmark			= " > All Data Employee";
}
else if ($link=="datareport")
{
  $includefile		= "reportapp.php";
  $menudatareport	= "active";	
  $linkmark			= " > Report Stastical";
}
else if ($link=="formpa_edit")
{
  $includefile		= "form_appraisal_edit.php";
  $menudataapp		= "active";	
  $linkmark			= " > Update Appraisal";
}
else if ($link=="karyawan_edit")
{
  $includefile		= "karyawan_edit.php";
  $menudataemp		= "active";	
  $linkmark			= " > Update Karyawan";
}
else if ($link=="input_karyawan")
{
  $includefile		= "input_karyawan.php";
  $menudatainemp		= "active";	
  $linkmark			= " > Tambah Karyawan";
}
else if ($link=="update_sup")
{
  $includefile		= "update_superior.php";
  $menudataupdsup		= "active";	
  $linkmark			= " > Update";
}
else if ($link=="preview_pdf")
{
  $includefile		= "preview_pdf.php";
  $menudataapp		= "active";	
  $linkmark			= " > view";
}
else if ($link=="fu_superior")
{
  $includefile		= "form_update_superior.php";
  $menudataapp		= "active";	
  $linkmark			= " > view";
}
else 
{
	 $includefile		= "alldataemployee.php";
	 $menudataemp		= "active";	
	 $linkmark			= " > All Data Employee";
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Administrator Performance Appraisal</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel="icon" type="image/png" href="../img/favicon.PNG">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" /> 

    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="../dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="../plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	
	
	
	<link rel="stylesheet" href="../plugins/select2/multiple-select.css"/>
	<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	
    <script src="../bootstrap/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	
	<!--
	<link rel="stylesheet" href="../plugins/select2/multiple-select.css"/>
	<link href="../dist/js/select2.min.css" rel="stylesheet" />
	<script src="../dist/js/select2.min.js"></script>
	-->
  </head>
  <body class="skin-black">
    <div class="wrapper">
      <header class="main-header">
        <a class="logo"><img src="../img/logokpn.PNG" width="70%"></a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">             
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../dist/img/<?php echo $scekuser['profile']; ?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $scekuser['pic']; ?></span>
                </a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
	  
      <aside class="main-sidebar" style="height:670px">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../dist/img/<?php echo $scekuser['profile']; ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $scekuser['pic']; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
			<?php
			if(isset($_COOKIE['bahasa'])){
				$bahasa=$_COOKIE['bahasa'];
			}else{
				$bahasa="ind";
			}
			
			if($bahasa=='eng'){
				$menu1="All Data Appraisal";
				$menu2="Employee Not Been Assessed";
				$menu3="All Data Employee";
				$menu4="Stastical Report";
				$menu5="Logout";
				$menu6="Input Employee";
				$menu7="Review Superior";
			}else{
				$menu1="Data Penilaian";
				$menu2="Karyawan Belum dinilai";
				$menu3="Data Karyawan";
				$menu4="Laporan Statistik";
				$menu5="Keluar";
				$menu6="Tambah Karyawan";
				$menu7="Ubah Atasan";
			}
			?>
          <ul class="sidebar-menu" >
            <li class="header">MAIN NAVIGATION</li>
			<?php if($scekuser['level']=='admin'){?>
				<li class="<?php echo $menudataapp?>">
				  <a href="?link=dataapp">
					<i class="fa fa-dashboard"></i><span><?php echo "$menu1"; ?></span>
				  </a>
				</li>
			<?php } ?>
			<li class="<?php echo $menunotassessed?>">
              <a href="?link=notassessed">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu2"; ?></span>
              </a>
            </li>
			<li class="<?php echo $menudataemp?>">
              <a href="?link=dataemp">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu3"; ?></span>
              </a>
            </li>
			<?php if($scekuser['level']=='admin'){?>
			<li class="<?php echo $menudatareport?>">
              <a href="?link=datareport">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu4"; ?></span>
              </a>
            </li>
			<?php } ?>
			<?php if($scekuser['username']=='adminhomaster'){?>
				<li class="<?php echo $menudatainemp?>">
				  <a href="?link=input_karyawan">
					<i class="fa fa-dashboard"></i><span><?php echo "$menu6"; ?></span>
				  </a>
				</li>
				<li class="<?php echo $menudataupdsup?>">
				  <a href="?link=update_sup">
					<i class="fa fa-dashboard"></i><span><?php echo "$menu7"; ?></span>
				  </a>
				</li>
			<?php } ?>
			<li class="<?php echo $menulogout?>">
              <a href="ceklogout.php">
                <i class="fa fa-times"></i><span><?php echo "Logout"; ?></span>
              </a>
            </li>			
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            PA 
            <small><?php echo $linkmark; ?></small>
          </h1>
          <ol class="breadcrumb" style="padding-right: 66px">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $linkmark; ?></li>
          </ol>
        </section>

        <section class="content">
      		<?php
      			include ($includefile);
      		?>
         </section>
		 
        </div>
        <footer class="main-footer" style="height:40px">
          <div class="pull-right hidden-xs">
            <b>Version</b> 2.0
          </div>
          <strong>Developed by HR System Development</strong>
        </footer>
    </div>

    
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    
    <script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="../plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../dist/js/app.min.js" type="text/javascript"></script>

    <!--
	<script src="../bootstrap/js/raphael-min.js"></script>
	<script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="../plugins/knob/jquery.knob.js" type="text/javascript"></script>
	
    <script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<script src="../plugins/fastclick/fastclick.min.js"></script>
	<script src="../dist/js/pages/dashboard.js" type="text/javascript"></script>
    <script src="../dist/js/demo.js" type="text/javascript"></script>-->
	
	<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<script type="text/javascript">
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>
	<?php
	if($link == "dataemp" || $link == "dataapp" || $link == "notassessed" || $link == "datareport" || $link == "update_sup"){
	?>
	<!-- <script src="../libs/jquery.min.js"></script> -->
	<script src="../libs/jquery.multiple.select.js"></script>
	<script>
		$(document).ready(function(){
			$('#aksesou').multipleSelect({
				placeholder: "Pilih Unit",
				filter:true
			});
		});	
		$(document).ready(function(){
			$('#aksespt').multipleSelect({
				placeholder: "Pilih Perusahaan",
				filter:true
			});
		});
		$(document).ready(function(){
			$('#aksesdept').multipleSelect({
				placeholder: "Pilih Departemen",
				filter:true
			});
		});
		$(document).ready(function(){
			$('#akseslevel').multipleSelect({
				placeholder: "Pilih Golongan",
				filter:true
			});
		});
		$(document).ready(function(){
			$('#aksesbisnis').multipleSelect({
				placeholder: "Pilih Bisnis Unit",
				filter:true
			});
		});
		$(document).ready(function(){
			$('#superior').multipleSelect({
				placeholder: "Pilih Superior",
				filter:true
			});
		});
	</script>
	<?php
	}
	?>
	
	<script src="../plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
  </body>
</html>