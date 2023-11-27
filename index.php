<?php
include("conf/conf.php");

if (isset($_COOKIE['id']) && isset($_COOKIE['pic'])) {
	header('Location: '.$base_url.'/home.php?link=mydata');
// Use $id and $pic to maintain the session or personalize content
}

$browser = $_SERVER['HTTP_USER_AGENT'];
$chrome = '/Chrome/';
$firefox = '/Firefox/';
$ie = '/MSIE/';
if (preg_match($chrome, $browser))
{
    $nambrow =  "Chrome/Opera";
}
else if (preg_match($firefox, $browser))
{
    $nambrow = "Firefox";
}
else if (preg_match($ie, $browser))
{
    $nambrow = "Ie";
}

		
if 	($nambrow=="Ie")
{
?>
	<script language="JavaScript">
		alert("Browser not Compatible");
		var brow = confirm("Do you want download recomended browser ?");
		if (brow == true) 
		{
			document.location='https://www.mozilla.org/id/firefox/new/';
			
		} 
		else 
		{
			window.location.assign("http://www.google.com")
		}
		
		
	</script>
<?php	
}

$username = isset($_COOKIE['username']) && isset($_COOKIE['cookieConsent']) ? $_COOKIE['username'] : '';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Performance Appraisal</title>
	<link rel="icon" type="image/png" href="img/favicon.PNG">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript"> 
	function createRequestObject() {
		var ro;
		var browser = navigator.appName;
		if(browser == "Microsoft Internet Explorer")
		{
			ro = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else
		{
			ro = new XMLHttpRequest();
		}
		 return ro;
	}

	var xmlhttp = createRequestObject();

	function entercode(event)
	{
		if(event.keyCode==13)
		{
			cekvalid();
		}
	}
	
	function cekvalid()
	{
		var letterNumber = /^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]+$/;
		
		if(document.getElementById('username').value=='')
		{
			alert("Input your NIK");
			document.getElementById('username').focus();
		}
		else if(document.getElementById('password').value=='')
		{	
			alert("Input your Password");
			document.getElementById('password').focus();
		}
		else
		{	
			var username = document.getElementById('username').value;
			var password = document.getElementById('password').value;

			if(password.match(letterNumber) && username.match(letterNumber)) 
			{
				document.getElementById('proses').style.display = 'inline';
				
				var http = new XMLHttpRequest();
				var url = 'ceklogin.php';
				var params = 'username='+username+'&password='+password;
				http.open('POST', url, true);

				//Send the proper header information along with the request
				http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

				http.onreadystatechange = function() {//Call a function when the state changes.
					if((http.readyState == 4) && (http.status == 200)) {
						let data = JSON.parse(http.response);
						
						if (data.code == 200)
						{
							alert(data.message);
							window.location='home.php?link=mydata';
						}	
						else
						{
							alert(data.message);
							window.location='';
						}
					}
					return false;
				}
				// xmlhttp.send(null);   
				http.send(params);
			}
			else
			{ 
				alert("Login Failed"); 
				return false; 
			}
		}
	}  

	function setlanguange(lang)
	{
		<?php
		$yearcookie = Date ('Y')+1;
		?>
		if(lang=="eng")
		{
			alert ("Set English Language");
			
			document.cookie="bahasa=eng; expires=31 Dec <?php echo $yearcookie ?> 12:00:00 GMT";
			location.reload(); 
			
		}
		else if(lang=="ind")
		{
			alert ("Pilih Bahasa Indonesia");
			document.cookie="bahasa=idn; expires=31 Dec  <?php echo $yearcookie ?> 12:00:00 GMT";
			location.reload(); 
		}
		
		
	}

	//var message="Function right click is Disabled!";
	function clickIE4(){
		if(event.button==2){
		  //alert(message);
		  return false;
		}
	}
	function clickNS4(e){
		if(document.layers||document.getElementById&&!document.all){
		  if(e.which==2||e.which==3){
			//alert(message);
			return false;
		  }
		}
	}
	if(document.layers){
		document.captureEvents(Event.MOUSEDOWN);
		document.onmousedown=clickNS4;
	}else if(document.all&&!document.getElementById){
		document.onmousedown=clickIE4;
	}
	document.oncontextmenu=new Function("return false");
	</script>
	<div class="Top Nav Example">
		<marquee><h2 style="color:red;background-color:white;"> Harap mengganti Password Guna menjaga keamanan data Performance Appraisal</h2></marquee>
	</div>
</head>
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
<div id="proses" class="proses" style="display: none"></div>
<body class="login-page" style="background-image:url(img/bg.jpg); background-size:100%;">
<div class="login-box">
  <div class="login-box-body" style="opacity:0.95;">
  <div class="login-logo">
	<!--<img src="../img/logokpn.png" width="80%"> action="ceklogin.php" type="submit"-->
	<h2>Performance Appraisal</h2>
  </div>
	<p class="login-box-msg">
		<img src="img/english.png" style="cursor:pointer;" onClick="setlanguange('eng')"> |
		<img src="img/indo.png" style="cursor:pointer;" onClick="setlanguange('ind')"> 
	</p>

	  <div class="form-group has-feedback">
		<input type="text" class="form-control" id="username" name="username" value="<?= $username; ?>" placeholder="User ID" autofocus>
		<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
	  </div>
	  <div class="form-group has-feedback">
		<input type="password" class="form-control" id="password" name="password"  placeholder="Password" onKeyPress="entercode(event)"/>
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>
	  <div class="row" >
		
		<div class="col-xs-12">
		  <button class="btn btn-danger btn-block btn-flat" onClick="cekvalid()">Sign In</button>
		</div>
	  </div>

  </div>
</div>
<!-- Modal -->
<div id="cookieConsentModal" class="modal fade" data-backdrop="static" role="dialog">
  <div class="modal-dialog" style="margin-top: 100px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cookies</h4>
      </div>
      <div class="modal-body">
        <p>We use cookies to enhance your experience on this website. By continuing to use this site, you consent to use of cookies.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="acceptCookies">Accept</button>
      </div>
    </div>
  </div>
</div>

<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<script>
  $(document).ready(function() {
    // Check if the 'cookieConsent' cookie is not set or doesn't have the value 'accepted'
	<?php if (!isset($_COOKIE['cookieConsent']) || $_COOKIE['cookieConsent'] !== 'accepted') : ?>
		$('#cookieConsentModal').modal('show'); // Show the modal if cookie consent is not given
	<?php endif; ?>
    // Set a cookie on 'Accept' button click
    $('#acceptCookies').click(function() {
		$('#cookieConsentModal').modal('hide');
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?= $base_url; ?>/setCookieConsent.php', true);
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4) {
				if (xhr.status === 200) {
					// Success, do something with xhr.responseText
					console.log(xhr.responseText);
				} else {
					// Handle error
					console.error('Request failed: ' + xhr.status);
				}
			}
		};
		xhr.send();

    });
  });
</script>
</body>
</html>
