<?php 
include("conf/conf.php");
session_start();
unset($_SESSION['idmaster_pa']);
// session_destroy('idmaster_pa');

?>
<script>
	window.location= '<?= "$base_url"; ?>';
</script>