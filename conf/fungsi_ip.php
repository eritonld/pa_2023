<?php
class usersOnline 
{
	var $timeout = 600;
	var $count = 0;
	var $error;
	var $i = 0;
	
	function usersOnline () 
	{
		$this->timestamp = time();
		$this->ip = $this->ipCheck();
	}
	
	function ipCheck() 
	{
		if (getenv('HTTP_CLIENT_IP')) 
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR')) 
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED')) 
		{
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR')) 
		{
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED')) 
		{
			$ip = getenv('HTTP_FORWARDED');
		}
		else 
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
}
$a = new usersOnline();
$xx= $a->ipCheck(); 

$_IP_SERVER	= $_SERVER['SERVER_ADDR'];
$_IP_ADDRESS = $xx; 
if($_IP_ADDRESS == $_IP_SERVER)
{
	ob_start();
	system('ipconfig /all');
	$_PERINTAH	= ob_get_contents();
	ob_clean();
	$_PECAH = strpos($_PERINTAH, "Physical");
	$_HASIL	= substr($_PERINTAH,($_PECAH+36),17);
	/*echo $_HASIL;*/	
} else {
	$_PERINTAH = "arp -a $_IP_ADDRESS";
	ob_start();
	system($_PERINTAH);
	$_HASIL = ob_get_contents();
	ob_clean();
	$_PECAH = strstr($_HASIL, $_IP_ADDRESS);
	$_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
	$_HASIL = substr($_PECAH_STRING[1], 0, 17);
/*	echo "IP Anda : ".$_IP_ADDRESS."
	MAC ADDRESS Anda : ".$_HASIL;*/
}
?>