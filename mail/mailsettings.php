<?php 			
	$mail->IsSMTP(); 
	//$mail->SMTPDebug = 2;
	$mail->Host     	= "mail.kpnplantation.com";
	$mail->SMTPAuth 	= true;     
	$mail->Username 	= "no-reply@kpnplantation.com";   
	$mail->Password 	= "8tcm3&82kz325pEe";
	// $mail->Port 		= "587"; 
	$mail->Port 		= 465; 
	$mail->IsHTML(true);
	$mail->From       	= "no-reply@kpnplantation.com";
	$mail->FromName   	= "HC System";
	$mail->AddReplyTo("no-reply@kpnplantation.com");
        
?>