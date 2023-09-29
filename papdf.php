<?php
set_time_limit(0);
session_start();
if(session_is_registered('idmaster_pa'))
{
	$user_pa=unserialize($_SESSION[idmaster_pa]);
	$idmaster=$user_pa[mas];
}
$bahasa=$_COOKIE['bahasa'];
include("conf/conf.php");
include("tabel_setting.php");

if ($idmaster == '')
{
	?>
	<script>
		alert('Login First');
		window.location="index.php";
	</script>
	<?php

}
else
{

$nik=$_GET['nik'];

$qgetcomment = mysqli_query($koneksi,"select komentar from $transaksi_pa where nik = '$nik' ");
$rgetcomment = mysqli_fetch_array($qgetcomment);

$q_cekatasan	= mysqli_query($koneksi,"Select * from atasan where nik = '$nik'"); //nik1
$r_cekatasan 	= mysqli_fetch_array($q_cekatasan);

$qinputby		= mysqli_query($koneksi,"select input_by from $transaksi_pa where nik = '$nik'");
$rinputby		= mysqli_fetch_array($qinputby);

$qidhead1		= mysqli_query($koneksi,"Select id,username from user_pa where username = '$r_cekatasan[nik_atasan1]'"); //nik2
$qidhead2		= mysqli_query($koneksi,"Select id,username from user_pa where username = '$r_cekatasan[nik_atasan2]'"); //nik3

$ridhead1		= mysqli_fetch_array ($qidhead1);
$ridhead2		= mysqli_fetch_array ($qidhead2);


$idhead1		= $ridhead1['id'];
$idhead2		= $ridhead2['id'];
$idinput		= $rinputby['input_by'];

if ($idhead1 <> $idmaster && $idhead2 <> $idmaster && $idinput<>$idmaster)
{
	if ($idmaster==1 || $idamaster ==2)
	{
		$lihat = 1;
	}
	else
	{
		$lihat = 0;
	}	
}
else 
{
	$lihat = 1;
}

if ($lihat == 0)
{
		?>
	<script>
		alert('Not Authorized');
		window.location="index.php";
	</script>
	<?php
}
else
{
require_once('../class/tcpdf/config/lang/eng.php');
require_once('../class/tcpdf/tcpdf.php');

if($bahasa=='eng')
{
	$file 	= "../class/tcpdf/images/PA_english.jpg";
	$kop 	= "../class/tcpdf/images/PA_english.jpg";
}
else
{
	$file 	= "../class/tcpdf/images/PA.jpg";
	$kop 	= "../class/tcpdf/images/PA.jpg";
}

date_default_timezone_set("Asia/Jakarta");

setlocale(LC_ALL, (strtolower(substr(PHP_OS, 0, 3)) == "win") ? "Indonesian_indonesia.1252" : "id_ID.UTF-8");



// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // full background image
        // store current auto-page-break status
        $bMargin = $this->getBreakMargin();
        $auto_page_break = $this->AutoPageBreak;
        $this->SetAutoPageBreak(false, 0);
       
		if ($this->page == 1) 
		{
			//$img_file = K_PATH_IMAGES."PA.jpg";
			$img_file = K_PATH_IMAGES."PA_english.jpg";	
			$this->Image($img_file, -5, 0, 220, 300, '', '', '', false, 300, '', false, false, 0);
		}
		else
		{
			
		}
	
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('HC System Development');
$pdf->SetTitle('Performance Appraisal');
$pdf->SetSubject('Performance Appraisal');
$pdf->SetKeywords('PA, PDF');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(8, 30, 20, 8);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(1.25);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

$pdf->SetFont('Arial', '', 9);


$karyawanx=mysqli_query($koneksi,"select k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
dg.Nama_Golongan,dg.fortable,dj.Nama_Jabatan from $karyawan as k
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
where k.NIK='$nik'");
$ckaryawan=mysqli_fetch_array($karyawanx);

$cekfortable=mysqli_query($koneksi,"select fortable from $transaksi_pa where nik='$nik'");
$scekfortable=mysqli_fetch_array($cekfortable);

if($scekfortable['fortable']=='nonstaff')
{
	//$bahasa='ind';
	$fortable='nonstaff';
	if($bahasa=='eng')		
		$fortable_select='nonstaff_english';
	else
		$fortable_select='nonstaff';
}
else if($scekfortable['fortable']=='staff')
{
	$fortable='staff';
	if($bahasa=='eng')		
		$fortable_select='staff_english';
	else
		$fortable_select='staff';
}
else if($scekfortable['fortable']=='staffb')
{
	$fortable='staffb';
	if($bahasa=='eng')		
		$fortable_select='staffb_english';
	else
		$fortable_select='staffb';
}
else if($scekfortable['fortable']=='managerial')
{
	$fortable='managerial';
	if($bahasa=='eng')		
		$fortable_select='managerial_english';
	else
		$fortable_select='managerial';
	
	$gettugas=mysqli_query($koneksi,"select tugas,penilaian_tugas from $tugas_managerial where nik='$nik'");
	$cgettugas=mysqli_fetch_array($gettugas);
}

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
	$a55='Signature of Superior';
	$a66='Signature of Head Department';
	$a77='Signature of Head';
	$a88='Name & Date :';
	$a99='Signature of Reviewee';
	$a100='Signature of Reviewer';
	
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
	$a55='Tanda Tangan Atasan Langsung';
	$a66='Tanda Tangan Head Department';
	$a77='Tanda Tangan Head Unit';
	$a88='Nama & Tanggal :';
	$a99='Tanda tangan karyawan';
	$a100='Tanda tangan penilai';
}


$getsp=mysqli_query($koneksi,"select statussp,periode from $tabel_sp where nik='$nik'");
$cgetsp=mysqli_fetch_array($getsp);

if($fortable=='managerial')
{
	if($bahasa=='eng')
	{
		$a14='SECTION II SELF-EVALUATION';
		$a15='Describe your primary duties and additional work (if any) undertaken';
		$a16='Provide a self-assessment of your performance in the past year and suggest areas of improvement';
	}
	else
	{
		$a14='BAGIAN II PENILAIAN DIRI';
		$a15='Tuliskan tugas utama Anda dan tugas tambahan (jika ada)';
		$a16='Berikan penilaian terhadap diri Anda atas kinerja pada tahun lalu dan usulan area mana yang perlu diperbaiki.';
		
	}
	
	$tabmgr ='
	<br>
	<table border="1">
        <tr>
            <th colspan="4" style="border:none;" width = "105%">'.$a14.'</th> 
        </tr>
        <tr>
            <th colspan="4" style="border:none;" width = "105%">1. '.$a15.'</th> 
		</tr>		
		<tr>	
			<th colspan="4" width = "105%">&nbsp;&nbsp;&nbsp;'.$cgettugas[tugas].'</th>
        </tr>   
        <tr>
            <th colspan="4" style="border:none;" width = "105%">2. '.$a16.'
            </th> 
        </tr>
		<tr>	
			<th colspan="4" width = "105%">&nbsp;&nbsp;&nbsp;'.$cgettugas[penilaian_tugas].'</th>
        </tr>
		
		</table>
	';
	
}
else
{
	$tabmgr="";
}       

$urut=1;
$headergroup="";
$pembagitotal=0;
$headergroup="";


$totalall=0;

$q_bobot 	= mysqli_query($koneksi,"Select * from master_soal_$fortable where id  = 2");
$r_bobot 	= mysqli_fetch_array($q_bobot);
			
$prosedure=mysqli_query($koneksi,"select komposisi_group,nama_group,jml_loop,fortable,bobot from $tabel_prosedure where fortable='$fortable' order by id");

$tabisi = "";

while($cprosedure=mysqli_fetch_array($prosedure))
{
	$tabisi=$tabisi.'    
		
			<tr>
			<th width = "5%" class="border-tipisgelap" style="background-color:#dd4b39; color:#ffffff;">'.$cprosedure[komposisi_group].'</th>';
	
	if($fortable=='firstline' && $urut =='1' )
	{
		if($bahasa=='eng')
		{				
			$a17='Objective and Indicator';
			$a18='Achievement';
			$a19='Evaluation & Feedback';
		}
		else
		{
			$a17='Sasaran & Ukuran Keberhasilan';
			$a18='Pencapaian';
			$a19='Evaluasi & Feedback';
		}
		
		$tabisi=$tabisi.'<th colspan="5" class="border-tipisgelap" style="background-color:#dd4b39; color:#ffffff;"  width = "115%">'.$cprosedure[nama_group].'</th>
				</tr>
	
				
				<tr>
					<th class="border-tipisgelap" style="background-color:#d9d9d9">&nbsp;</th>
					<th class="border-tipisgelap" colspan="2" style="background-color:#d9d9d9" width = "50%"> '.$a17.'</th>
					<th class="border-tipisgelap" colspan="2" style="background-color:#d9d9d9" width = "50%"> '.$a18.'</th>
					<th class="border-tipisgelap" colspan="2" style="background-color:#d9d9d9" width = "15%"> '.$a19.'</th>
				</tr>';
	}
	else
	{
		$tabisi=$tabisi.'<th class="border-tipisgelap" colspan="4" width = "100%" style="background-color:#dd4b39; color:#ffffff;">'.$cprosedure[nama_group].'</th>  
        <th class="border-tipisgelap" style="text-align:center;" width = "15%" style="background-color:#dd4b39; color:#ffffff;">'.$a12.'</th>  
		</tr>'; 
	}
	$subtotal=0;
	for($i=1;$i<=$cprosedure['jml_loop'];$i++)
	{
		$slc=$cprosedure['komposisi_group'].$i;
		$master_soal=mysql_query("select $slc,komentar from master_soal_$fortable_select");
		$cmaster_soal=mysql_fetch_array($master_soal);
			
		$data=explode('|',$cmaster_soal[$slc]);
		
		if($fortable=='firstline' )
		{
				if ($urut==1)
				{
					$tabisi=$tabisi.'
					<tr >
					<th class="border-tipisgelap" style="background-color:#afafaf">'.$i.'</th>
					<th class="border-tipisgelap" colspan="5" style="background-color:#afafaf" width = "115%">'.$data[0].'</th>
					</tr>';
				}
				else
				{
				
					$tabisi=$tabisi.'
					<tr >
					<th class="border-tipisgelap" style="background-color:#afafaf">'.$i.'</th>
					<th class="border-tipisgelap" colspan="5" style="background-color:#afafaf">'.$data[0].'</th>
					</tr>';
				}
		}
		else
		{
				$tabisi=$tabisi.'
				<tr >
				<th class="border-tipisgelap" style="background-color:#afafaf">'.$i.'</th>
				<th class="border-tipisgelap" colspan="4" style="background-color:#afafaf">'.$data[0].'</th>
				<th class="border-tipisgelap" style="background-color:#afafaf">&nbsp;</th>
				</tr>';
		}

		if($fortable=='firstline' && ($slc=='A1' || $slc=='A2' || $slc=='A3'))
		{
			$qpadetail=mysqli_query($koneksi,"select * from $transaksi_pa_detail where nik = '$nik' and group_transaksi ='$slc'");
			$rpadetail=mysqli_fetch_array($qpadetail); 
			$tabisi=$tabisi.'
			<tr>
			<td class="border-tipisgelap">&nbsp;</td>
			<td class="border-tipisgelap" colspan="2" width = "50%" style="font-size:30px;">'.$rpadetail[sasaran].'</td>
			<td class="border-tipisgelap" colspan="2" width = "50%" style="font-size:30px;">'.$rpadetail[pencapaian].'</td>
			<td class="border-tipisgelap" colspan="2" width = "15%">'.$rpadetail[nilai].'</td>
			</tr>';
		}
		else
		{
			if ($fortable=='firstline' && $urut==1)
			{
				$tabisi=$tabisi.'<tr>
				<th class="border-tipisgelap">&nbsp;</th>
				<th class="border-tipisgelap" colspan="4" width = "100%">'.$data[1].'</th>
				</tr>';
			}
			else
			{
				$tabisi=$tabisi.'<tr>
				<th class="border-tipisgelap">&nbsp;</th>
				<th class="border-tipisgelap" colspan="4">'.$data[1].'</th>
				<th class="border-tipisgelap">&nbsp;</th>
				</tr>';
			}	
		}
		
		$getnilai=mysqli_query($koneksi,"select $slc,komentar from $transaksi_pa where nik='$nik'");
		$cgetnilai=mysqli_fetch_array($getnilai);	
	
		
		$seltab="master_soal_".$fortable_select."_detail";
		$master_soal_detail=mysqli_query($koneksi,"select id,soal,nilai from $seltab where idgroup='$slc' ");
		while($cmaster_soal_detail=mysqli_fetch_array($master_soal_detail))
		{
			
			if($cmaster_soal_detail['nilai']==$cgetnilai[$slc])
			{	
				$bgcolorpil = ' style="background-color:#f67676"';
			}
			else
			{
				$bgcolorpil = ' style="background-color:#ffffff"';
			}
			
			if ($fortable=='firstline' && $urut==1)
			{
				$tabisi=$tabisi.'<tr>
				<td class="border-tipisgelap" colspan="2" width="10%">&nbsp;</td>
				<td class="border-tipisgelap" colspan="3" width = "95%">'.$cmaster_soal_detail['soal'].'</td>
				<td class="border-tipisgelap" width = "15%" '.$bgcolorpil.'>'.$cmaster_soal_detail['nilai'].'</td>
				</tr>';
			}
			else
			{
				$tabisi=$tabisi.'<tr>
				<td class="border-tipisgelap" colspan="2" width="10%">&nbsp;</td>
				<td class="border-tipisgelap" colspan="3"  width = "95%">'.$cmaster_soal_detail['soal'].'</td>
				<td class="border-tipisgelap" '.$bgcolorpil.'>'.$cmaster_soal_detail['nilai'].'</td>
				</tr>';
			}
		}	
			
			$bot		= ($r_bobot[$slc]/($cprosedure['bobot']/100));
			$nilx		= number_format((($cgetnilai[$slc]*$bot)/100),2);
			$subtotal	= $subtotal+$nilx;
			
			
	}
	
	$totalsubx 	= $subtotal/50;
	$totalsuby 	= number_format(($totalsubx*($cprosedure['bobot']/100)),2);
	$totalall	= $totalall+$totalsuby;	
	if ($fortable=='firstline' && $urut==1)
	{
		$tabisi=$tabisi.' 
		<tr>
       	<td class="border-tipisgelap" colspan="5" style="background-color:#e59a17" >Sub-Total Score '.$cprosedure['komposisi_group'].'</td>
        <td class="border-tipisgelap" style="background-color:#e59a17" width="15%">'.($totalsuby*100).'% </td>
		</tr>
		';
	}
	else
	{
		$tabisi=$tabisi.' 
		<tr>
			<td class="border-tipisgelap" colspan="5" style="background-color:#e59a17">Sub-Total Score '.$cprosedure['komposisi_group'].'</td>
            <td class="border-tipisgelap" style="background-color:#e59a17">'.($totalsuby*100).'%</td>
		</tr>
		';
	}
if($urut=='1')
	$headergroup=$cprosedure['komposisi_group'];
else
	$headergroup=$headergroup.','.$cprosedure['komposisi_group'];
	

$urut++;
}

$totalallx = $totalall*100;
$tahun=date('Y');
$cekkriteria=mysqli_query($koneksi,"select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc");
$ak=0;
while($ccekkriteria=mysqli_fetch_array($cekkriteria))
{
	$rngs[$ak]=$ccekkriteria['ranges'];
	$g[$ak]=$ccekkriteria['grade'];
	$ak++;
}
$grade="E";
$warna="000000";
for($aa=0;$aa<$ak;$aa++)
{		
	if($totalallx >= $rngs[$aa])
	{
		$grade=$g[$aa];
		break;
	}		
}




$tabisi=$tabisi.'
<tr>
	<td class="border-tipisgelap" colspan="5" style="background-color:#67fb5f">TOTAL SCORE</td>
	<td class="border-tipisgelap" style="background-color:#67fb5f"> '.$totalallx.'%</td>
</tr>
<tr>
	<td class="border-tipisgelap" colspan="5" style="background-color:#67fb5f">Grade</td>
	<td class="border-tipisgelap" style="background-color:#67fb5f"> '.$grade.'</td>
</tr>
';

$cekjudul=mysqli_query($koneksi,"select * from master_soal_$fortable_select where id='1'");
$ccekjudul=mysqli_fetch_array($cekjudul);


$ttdlast=="";
$ringkasan=="";
if($fortable=='managerial')
{
$cekisi=mysqli_query($koneksi,"select * from $tugas_managerial where nik='$nik'");
$ccekisi=mysqli_fetch_array($cekisi);
	$ttdlast='<div style="width:50%; position:fixed; right:0">
	<table border="1" width="50%">
		<tr>
			<th>'.$a99.'</th>
			<th>'.$a100.'</th>
		</tr>
		<tr>
			<td height="100px">&nbsp;</td>
			<td height="100px">&nbsp;</td>
		</tr>
		<tr>
			<td>'.$a88.'</td>
			<td>'.$a88.'</td>
		</tr>
	</table>';

	$ringkasan='<div style="width:50%; position:fixed; right:0">
	<table border="1" width="108%">
		<tr style="background-color:#dd4b39; color:#ffffff;">
			<td>'.$ccekjudul['ringkasan1'].'</td>
		</tr>
		<tr>
			<td>'.$ccekisi['ringkasan1'].'</td>
		</tr>
		<tr style="background-color:#dd4b39; color:#ffffff;">
			<td>'.$ccekjudul['ringkasan2'].'</td>
		</tr>
		<tr>
			<td>'.$ccekisi['ringkasan2'].'</td>
		</tr>
		<tr style="background-color:#dd4b39; color:#ffffff;">
			<td>'.$ccekjudul['ringkasan3'].'</td>
		</tr>
		<tr>
			<td>'.$ccekisi['ringkasan3'].'</td>
		</tr>
		<tr style="background-color:#dd4b39; color:#ffffff;">
			<td>'.$ccekjudul['ringkasan4'].'</td>
		</tr>
		<tr>
			<td>'.$ccekisi['ringkasan4'].'</td>
		</tr>
	</table>';
}
else if ($fortable=='firstline')
{
	$ttdlast='<div style="width:50%; position:fixed; right:0">
<table border="1" width="50%">
	<tr>
		<th>'.$a66.'</th>
		<th>'.$a77.'</th>
	</tr>
	<tr>
		<td height="100px">&nbsp;</td>
		<td height="100px">&nbsp;</td>
	</tr>
	<tr>
		<td>'.$a88.'</td>
		<td>'.$a88.'</td>
	</tr>
</table>';
}
else
{
	$ttdlast='<div style="width:50%; position:fixed; right:0">
<table border="1" width="70%">
	<tr>
		<th>'.$a55.'</th>
		<th>'.$a66.'</th>
		<th>'.$a77.'</th>
	</tr>
	<tr>
		<td height="100px">&nbsp;</td>
		<td height="100px">&nbsp;</td>
		<td height="100px">&nbsp;</td>
	</tr>
	<tr>
		<td>'.$a88.'</td>
		<td>'.$a88.'</td>
		<td>'.$a88.'</td>
	</tr>
</table>';
}
// Print a text
$html = <<<EOD
<link rel="stylesheet" type="text/css" href="../class/tcpdf/stylepdf.css"/>
<br><br><br><br><br><br><br>
<table width="90%" class="border-tipis">
        <tr>
            <th class="border-tipis">$a2</th>
            <td class="border-tipis" style="width:35%;">$ckaryawan[Nama_Lengkap]</td>
            <th class="border-tipis">$a3</th>
            <td class="border-tipis" style="width:35%;">$ckaryawan[Nama_Perusahaan]</td>  
        </tr>
        <tr>
            <th class="border-tipis">$a4</th>
            <td class="border-tipis">$ckaryawan[NIK]</td>
            <th class="border-tipis">$a5</th>
            <td class="border-tipis">$ckaryawan[Nama_Departemen]</td>  
        </tr>
        <tr>
            <th class="border-tipis">$a6</th>
            <td class="border-tipis">$ckaryawan[Nama_Jabatan]</td>
            <th class="border-tipis">$a7</th>
            <td class="border-tipis">-</td>  
        </tr>
        <tr>
            <th class="border-tipis">$a8</th>
            <td class="border-tipis">$ckaryawan[Mulai_Bekerja]</td>
            <th class="border-tipis">$a9</th>
            <td class="border-tipis">$quartal_periode</td>  
        </tr>
        <tr>
            <th class="border-tipis">$a10</th>
            <td class="border-tipis">$ckaryawan[Nama_Golongan]</td>
            <th class="border-tipis">$a11</th>
            <td class="border-tipis">$cgetsp[statussp] / $cgetsp[periode]</td>  
        </tr>  
</table>
$tabmgr
<br>
<table width="90%" class="border-tipisgelap">
$tabisi
</table>
<br>
<table border="1" width="108%">
	<tr style="background-color:#dd4b39; color:#ffffff;">
		<td>Comments</td>
	</tr>
	<tr>
		<td>$rgetcomment[komentar]</td>
	</tr>
</table>
<br>
$ringkasan
<br>
$ttdlast
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Performance Appraisal.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
}}
?>
