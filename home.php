<?php
include("conf/conf.php");

// session_start();
// if(session_is_registered('idmaster_pa'))
// {
	// $user_pa=unserialize($_SESSION[idmaster_pa]);
	// $idmaster_pa=$user_pa[mas];
// }

session_start();

// $operators['id']=$_SESSION["idmaster_pa"];

$idmaster_pa=$_SESSION["idmaster_pa"];

if ($idmaster_pa=="")
{
	?>
	<script>
		// alert('Login First');
		// window.location="http://localhost:8080/hcis-pa-2023/";
	</script>
	<?php
}

try {
  $stmt = $koneksi->prepare("SELECT * FROM user_pa WHERE id = :id");
  $stmt->bindParam(':id', $idmaster_pa, PDO::PARAM_INT);
  $stmt->execute();
  $scekuser = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

$link = $_GET['link'];

$menumydata			= "deactive";
$menuaddapp			= "deactive";
$menugantipas		= "deactive";
$menulogout			= "deactive";

if ($link=="mydata")
{
  $includefile		= "my_data.php";
  $menumydata		= "active";
  $linkmark			= " > My Data";
}
else if ($link=="addapp")
{
  $includefile		= "add_appraisal.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Add Appraisal";
}
else if ($link=="formpa")
{
  $includefile		= "form_appraisal.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Form Appraisal";
}
else if ($link=="formpa_edit")
{
  $includefile		= "form_appraisal_edit.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Form Appraisal";
}
else if ($link=="formpa_review")
{
  $includefile		= "form_appraisal_review.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Form Appraisal";
}
else if ($link=="formpa_review2")
{
  $includefile		= "form_appraisal_review2.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Form Appraisal";
}
else if ($link=="formpa_review3")
{
  $includefile		= "form_appraisal_review3.php";
  $menuaddapp		= "active";	
  $linkmark			= " > Form Appraisal";
}
else if ($link=="gantipas")
{
  $includefile		= "ubah_password.php";
  $menugantipas		= "active";	
  $linkmark			= " > Change Password";
}
else 
{
	$includefile		= "my_data.php";
	$menumydata			= "active";
	$linkmark       	= " > My Data";
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Performance Appraisal</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link rel="icon" type="image/png" href="img/favicon.PNG">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
    <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" /> 

    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/skin-black.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />

    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
	
	<link rel="stylesheet" href="plugins/select2/multiple-select.css"/>
	<script src="plugins/jQuery/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
	<!--
	
	-->
  </head>
  <body class="skin-black">
    <div class="wrapper">
      <header class="main-header">
        <a class="logo"><img src="img/logokpn.PNG" width="70%"></a>
        <nav class="navbar navbar-static-top" role="navigation">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">             
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/<?php echo $scekuser['profile']; ?>" class="user-image" alt="User Image"/>
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
              <img src="dist/img/<?php echo $scekuser['profile']; ?>" class="img-circle" alt="User Image" />
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
				$menu1="My Data";
				$menu2="Add Appraisal";
				$menu3="Change Password";
				$menu4="Logout";
				$mydata1="My Appraisal";
				$mydata2="My Subordinate (one-level) Appraisal";
				$mydata3="My Subordinate (two-level) Appraisal";
				$mydata4="My Subordinate (three-level) Appraisal";
				$unitlokasi="Work Location";
				$karyawandinilai="Employee to be Assessed";
				$pilihunit="Chosee";
				$atasan1="Direct Superior";
				$atasan2="Indirect Superior";
				$pilihnama="Chosee";
				$pilihatasan="Chosee";
				$anggota="The employee has subordinate?";
				$ya="Yes";
				$tidak="No";
				$staffno="Non Staff/Staff?";
				$pilih="Chosee";
			}else{
				$menu1="Data Saya";
				$menu2="Tambah Penilaian";
				$menu3="Ubah Password";
				$menu4="Keluar";
				$mydata1="Penilaian Saya";
				$mydata2="Nilai Bawahan Saya (1 Level)";
				$mydata3="Nilai Bawahan Saya (2 Level)";
				$mydata4="Nilai Bawahan Saya (3 Level)";
				$unitlokasi="Unit/Lokasi Kerja";
				$karyawandinilai="Karyawan dinilai";
				$pilihunit="Pilih Unit";
				$atasan1="Atasan 1 (Atasan Langsung)";
				$atasan2="Atasan 2";
				$pilihnama="Pilih Nama";
				$pilihatasan="Pilih Atasan";
				$anggota="Apakah Karyawan yang dinilai memiliki anggota?";
				$ya="Ya";
				$tidak="Tidak";
				$staffno="Apakah status ybs Non Staff/Staff?";
				$pilih="Pilih";
			}
			?>
          <ul class="sidebar-menu" >
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo $menumydata?>">
              <a href="?link=mydata">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu1"; ?></span>
              </a>
            </li>
			<li class="<?php echo $menuaddapp?>">
              <a href="?link=addapp">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu2"; ?></span>
              </a>
            </li>
			<li class="<?php echo $menugantipas?>">
              <a href="?link=gantipas">
                <i class="fa fa-dashboard"></i><span><?php echo "$menu3"; ?></span>
              </a>
            </li>
			<li class="<?php echo $menulogout?>">
              <a href="ceklogout.php">
                <i class="fa fa-times"></i><span><?php echo "$menu4"; ?></span>
              </a>
            </li>			
          </ul>
        </section>
      </aside>

      <div class="content-wrapper">
        <section class="content-header">
          <h1>
            Performance Appraisal 
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

    <script src="bootstrap/js/jquery-ui.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    
    <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="plugins/morris/morris.min.js" type="text/javascript"></script>
    <script src="plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="dist/js/app.min.js" type="text/javascript"></script>

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
	
	<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<script type="text/javascript">
      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        
        //bootstrap WYSIHTML5 - text editor
        $(".textarea").wysihtml5();
      });
    </script>
	<?php
	if($link == "inputpppkb" || $link == "editpppkb" || $link == "actionunit"){
	?>
	<script src="libs/jquery.min.js"></script>
	<script src="libs/jquery.multiple.select.js"></script>
	<script>
		$(document).ready(function(){
			$('#aksesou').multipleSelect({
				placeholder: "Pilih Unit",
				filter:true
			});
		});	
		$(document).ready(function(){
			$('#namapt').multipleSelect({
				placeholder: "Pilih Perusahaan",
				filter:true
			});
		});
	</script>
	<?php
	}
	?>
	
	<script src="plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
  </body>
</html>