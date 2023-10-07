<?php
$queryiderror 	= "SHOW TABLE STATUS LIKE 'activity'";
$hasiliderror 	= mysqli_query($koneksi,$queryiderror) or die (mysql_error ());
$rowiderror 	= mysqli_fetch_array($hasiliderror);
$iderrornya 	= ($rowiderror['Auto_increment'])-1;

$quseract		= mysqli_query($koneksi,"Select pic from user_pa where id = $input_by");
$ruseract		= mysqli_fetch_array($quseract);
include("tabel_setting.php");

if($bahasa=='eng')
{
	$tabel_prosedure="prosedure_english";
	$a1='Performance Appraisal';
	$a2='Employee Name';
	$a3='Company / Unit';
	$a4='Employee No';
	$a5='Division/Department';
	$a6='Designation';
	$a7='Section/SubSection';
	$a8='Work Begin';
	$a9='Period of Assessment';
	$a10='Grade';
	$a11='SP/period';
	$a12='Rating';
	$a13='On Rating';
	$a14='Click link for detail';
	$a15='Do not reply this message, this message sent automatically by system  <p>----- <br> HC System Development';
	$a16='has been created PA evaluation';
}
else
{
	$tabel_prosedure="prosedure";
	$a1='Penilaian Kinerja Karyawan';
	$a2='Nama Karyawan';
	$a3='Nama PT / Unit';
	$a4='Nomor Induk';
	$a5='Divisi/Departemen';
	$a6='Jabatan';
	$a7='Seksi/SubSeksi';
	$a8='Mulai bekerja';
	$a9='Periode Penilaian';
	$a10='Golongan';
	$a11='SP/Periode';
	$a12='Bobot';
	$a13='Pembobotan';
	$a14='Untuk detail klik link berikut';
	$a15='Jangan balas pesan ini karena dikirim secara otomatis oleh system  <p>----- <br> HC System Development';
	$a16='telah melakukan penilaian PA';	
}


include_once("mail/class.phpmailer.php");
$mail = new PHPMailer();

$karyawanx=mysqli_query($koneksi,"select k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
dg.Nama_Golongan,k.Nama_Jabatan,k.Kode_OU from $karyawan as k
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
where k.NIK='$nik'");
$ckaryawan=mysqli_fetch_array($karyawanx);

$getsp=mysqli_query($koneksi,"select statussp,periode from $tabel_sp where nik='$nik'");
$cgetsp=mysqli_fetch_array($getsp);
$statussp = isset($cgetsp['statussp']) ? $cgetsp['statussp'] : '';
$periode = isset($cgetsp['periode']) ? $cgetsp['periode'] : '';
	
	include_once('mail/mailsettings.php');			
	
	$body = "<p>Salam SIGAP, </P> <b>$ruseract[pic]</b> $a16 : <br><br>
			<table border = 0>
				<tr>
					<td>$a2</td>
					<td style=\"width:70%;\">: $ckaryawan[Nama_Lengkap]</td>  
				</tr>
				<tr>
					<td>$a4</td>
					<td>: $ckaryawan[NIK]</td>  
				</tr>
				<tr>
					<td>$a5</td>
					<td>: $ckaryawan[Nama_Departemen]</td>
				</tr>
				<tr>
					<td>$a6</td>
					<td>: $ckaryawan[Nama_Jabatan]</td> 
				</tr>
				<tr>
					<td>$a8</td>
					<td>: $ckaryawan[Mulai_Bekerja]</td>
				</tr>
				<tr>
					<td>$a10</td>
					<td>: $ckaryawan[Nama_Golongan]</td>
				</tr>
				<tr>
					<td>$a3</td>
					<td  style=\"width:70%;\">: $ckaryawan[Nama_Perusahaan]</td>
				</tr>
				<tr>					
					<td>$a9</td>
					<td>: $quartal_periode</td>
				</tr>
				<tr>					
					<td>$a11</td>
					<td>: $statussp / $periode</td>
				</tr>
				<tr>
					<th>&nbsp;</th>
					<td>&nbsp;</th> 
				</tr>
				<tr>
					<td>Total Nilai</td>
					<td>: $totalall</td>
				</tr>
				<tr>
					<td>Grade</td>
					<td>: $grade </td>
				</tr>
				<tr>
					<td>$a14 : </td>
					<td colspan=\"3\">http://172.30.1.38:8080/pa</td> 
				</tr>
			</table>
			<br>$a15
				
			 ";
			
			//($kesimpulan)
		$mail->Subject    = "Input PA ($ckaryawan[Nama_Lengkap])";
	
	$mail->MsgHTML($body);
	
	if($nik==$nik_input){
		if($emailatasan1=='brian@kpn-corp.com' || $emailatasan1=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
			$mail->AddAddress("eriton.dewa@kpnplantation.com");
		}else{
			$mail->AddAddress($emailatasan1);
		}
	}else if($atasan1==$nik_input){ 
		if($emailatasan2=='brian@kpn-corp.com' || $emailatasan2=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
			$mail->AddAddress("eriton.dewa@kpnplantation.com");
		}else{
			$mail->AddAddress($emailatasan2);
		}
	}else{
		$mail->AddAddress("eriton.dewa@kpnplantation.com");
	}
	
	$mail->AddCC("eriton.dewa@kpnplantation.com");
			
	if(!$mail->Send()) 
	{
		$qinsertactmailerror	= mysqli_query ($koneksi,"insert into activity_mailerror (idactivity, date) values ($iderrornya, now())");
		echo "Mailer Error: " . $mail->ErrorInfo;?><?php
	}
	else
	{
		//echo "kambing";	
	} 

?>