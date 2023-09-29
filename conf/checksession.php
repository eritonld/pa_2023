<?php
include("language/id.php");
//session_start();
if (!isset($_SESSION['nik']) || !isset($_SESSION['email']) || !isset($_SESSION['id']))
{
?>
	<script language="JavaScript">
	document.location='?page=noauth.php'
    </script>
    <noscript>
	<meta http-equiv="refresh" content="0; URL=?page=checkjs.php">
	</noscript>
<?php
exit;
}
?>