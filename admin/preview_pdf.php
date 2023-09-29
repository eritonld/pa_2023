<?php
include("../conf/conf.php");
include("../tabel_setting.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}
//$bahasa='eng';
$nik=$_GET['nik'];

$getatasan=mysqli_query($koneksi, "select nik_atasan1,nik_atasan2 from atasan where nik='$nik'");
$cgetatasan=mysqli_fetch_array($getatasan);

$qemail1	= mysqli_query($koneksi, "Select NIK,Nama_Lengkap,Email from $karyawan where NIK = '$cgetatasan[nik_atasan1]'");
$remail1	= mysqli_fetch_array($qemail1);

$qemail2 	= mysqli_query($koneksi, "Select NIK,Nama_Lengkap,Email from $karyawan where NIK = '$cgetatasan[nik_atasan2]'");
$remail2	= mysqli_fetch_array($qemail2);

$nama_atasan1=$remail1['NIK'];
$nama_atasan2=$remail2['NIK'];
$email_atasan1=$remail1['Email'];
$email_atasan2=$remail2['Email'];

if($nik=='')
{?>
	<script language="JavaScript">
		alert('Dilarang Refresh/Masukan NIK');
		document.location='home.php?link=dashboard';
	</script>
<?php	
exit;
}
$karyawanx=mysqli_query($koneksi, "select k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
dg.Nama_Golongan,k.Nama_Jabatan,du.Nama_OU from $karyawan as k
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
left join daftarou as du on k.Kode_OU=du.Kode_OU
where k.NIK='$nik'");
$ckaryawan=mysqli_fetch_array($karyawanx);

$cekfortable=mysqli_query($koneksi, "select fortable from $transaksi_pa where nik='$nik'");
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
}

$getsp=mysqli_query($koneksi, "select statussp,periode from $tabel_sp where nik='$nik'");
$cgetsp=mysqli_fetch_array($getsp);
?>

<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,

	});
	
	function convLinkVC(strUrl, node, on_save) {
            strUrl=strUrl.replace("../","");
            return strUrl;
       } 
	
	function ajaxLoad() {
	var ed = tinyMCE.get('resume');

	// Do you ajax call here, window.setTimeout fakes ajax call
	ed.setProgressState(1); // Show progress
	window.setTimeout(function() {
		ed.setProgressState(0); // Hide progress
		ed.setContent('HTML content that got passed from server.');
	}, 3000);
}

</script>
<div class="row">
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
		<!--<button class="btn btn-primary" onClick="window.print()">Print</button>-->
<table class="table table-bordered">
    <thead>
        <tr>
            <td><?php echo"$a2";?></td>
            <td style="width:35%;"><?php echo"$ckaryawan[Nama_Lengkap]";?></td>
            <td><?php echo"$a3";?></td>
            <td  style="width:35%;"><?php echo"$ckaryawan[Nama_Perusahaan] / $ckaryawan[Nama_OU]";?></td>  
        </tr>
        <tr>
            <td><?php echo"$a4";?></td>
            <td><?php echo"$ckaryawan[NIK]";?></td>
            <td><?php echo"$a5";?></td>
            <td><?php echo"$ckaryawan[Nama_Departemen]";?></td>  
        </tr>
        <tr>
            <td><?php echo"$a6";?></td>
            <td><?php echo"$ckaryawan[Nama_Jabatan]";?></td>
            <td><?php echo"$a7";?></td>
            <td><?php echo"-";?></td>  
        </tr>
        <tr>
            <td><?php echo"$a8";?></td>
            <td><?php echo"$ckaryawan[Mulai_Bekerja]";?></td>
            <td><?php echo"$a9";?></td>
            <td><?php echo"$quartal_periode";?></td>  
        </tr>
        <tr>
            <td><?php echo"$a10";?></td>
            <td><?php echo"$ckaryawan[Nama_Golongan]";?></td>
            <td><?php echo"$a11";?></td>
            <td><?php if(isset($cgetsp['statussp'])){echo"$cgetsp[statussp] / $cgetsp[periode]";} ?></td>  
        </tr>
        <input type="hidden" name="nik" value="<?php echo"$ckaryawan[NIK]";?>">
        <input type="hidden" name="atasan1" value="<?php echo $nama_atasan1;?>">
        <input type="hidden" name="atasan2" value="<?php echo $nama_atasan2;?>">   
		<input type="hidden" name="emailatasan1" value="<?php echo $email_atasan1;?>">
		<input type="hidden" name="emailatasan2" value="<?php echo $email_atasan2;?>">
         <?php
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
			$gettugas=mysqli_query($koneksi, "select tugas,penilaian_tugas from $tugas_managerial where nik='$nik'");
			$cgettugas=mysqli_fetch_array($gettugas);
		?>
        <tr>
            <th colspan="4" style="border:none;"><?php echo"$a14";?></td> 
        </tr>
         <tr>
            <th colspan="4" style="border:none;">1. <?php echo"$a15";?><br />
            <textarea name="tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control" readonly><?php echo"$cgettugas[tugas]";?></textarea>
            </td> 
        </tr>
         <tr>
            <th colspan="4" style="border:none;">2. <?php echo"$a16";?><br />
            <textarea name="penilaian_tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control" readonly><?php echo"$cgettugas[penilaian_tugas]";?></textarea></td> 
        </tr>
        <?php
		}?>
    </thead>
</table><br />
<table class="table table-bordered" style="color:#000000; font-family:Arial, Helvetica, sans-serif;" border=1;>
<?php
$urut=1;
$headergroup="";
$pembagitotal=0;
$totalall=0;
$prosedure=mysqli_query($koneksi, "select komposisi_group,nama_group,jml_loop,fortable,bobot from $tabel_prosedure where fortable='$fortable' order by id");
while($cprosedure=mysqli_fetch_array($prosedure))
{
?>
	
      <thead>
      <tr style="background:#dd4b39; color:#ffffff;">
        <th width="2%"><?php echo"$cprosedure[komposisi_group]";?></td>
        <?php
		if($fortable=='firstline' && $urut=='1')
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
		?>
       		<th colspan="5"><?php echo"$cprosedure[nama_group]";?></td>
            </tr>
            <tr>
            <td>&nbsp;</td>
            <th width="28%"><?php echo"$a17";?></td>
            <th width="43%"><?php echo"$a18";?></td>
            <th colspan="3" style="text-align:center;"><?php echo"$a19";?></td>
            </tr>
        <?php
		}
		else
		{?>
        <th colspan="4"><?php echo"$cprosedure[nama_group]";?></td>  
        <th width="13%" style="text-align:center;"><?php echo"$a12";?></td>  
        </tr>
        <?php
		}?>      
      </thead>
      <tbody>
      	<?php
		$subtotal=0;
		$pembagisub=0;
		for($i=1;$i<=$cprosedure['jml_loop'];$i++)
		{
			$slc=$cprosedure['komposisi_group'].$i;
			$master_soal=mysqli_query($koneksi, "select $slc,komentar from master_soal_$fortable_select where id='1'");
			$cmaster_soal=mysqli_fetch_array($master_soal);
			
			$bobot_data=mysqli_query($koneksi, "select $slc from master_soal_$fortable_select where id='2'");
			$cbobot=mysqli_fetch_array($bobot_data);
			
			$bobot=$cbobot[$slc]/($cprosedure['bobot']/100);
			
			$data=explode('|',$cmaster_soal[$slc]);

        	if($fortable<>'firstline')
			{
			?>
			<tr style="background:#CCCCCC;">
            <td><?php echo"$i";?></td>
            <th colspan="4"><?php echo"$data[0]";?></td>
            <th width="14%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></td>
            </tr>
            <?php
			}
			
			if($fortable=='firstline' && ($slc=='A1' || $slc=='A2' || $slc=='A3'))
			{
				$gettugas=mysqli_query($koneksi, "select sasaran,pencapaian,nilai,feedback from $transaksi_pa_detail where nik='$nik' and group_transaksi='$slc'");
				$cgettugas=mysqli_fetch_array($gettugas);
			?>          
            <tr style="background:#CCCCCC;">
            <td><?php echo"$i";?></td>
            <th colspan="4"><?php echo"$data[0]";?></td>
            <th width="13%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></td>
            </tr>
            <tr>
			<td></td>
			<td style="width:30%;"><textarea style="background:#ffffaa;" class="textarea form-control" name="sasaran<?php echo"$slc";?>" id="sasaran<?php echo"$slc";?>" cols="30%" rows="5" readonly><?php echo"$cgettugas[sasaran]";?></textarea></td>
			<td style="width:30%;"><textarea style="background:#ffffaa;" class="textarea form-control" name="pencapaian<?php echo"$slc";?>" id="pencapaian<?php echo"$slc";?>" cols="30%" rows="5" readonly><?php echo"$cgettugas[pencapaian]";?></textarea></td>
			<td colspan="3" style="text-align:right;width:10%;">
            <textarea style="background:#ffffaa;" class="textarea form-control" name="feedback<?php echo"$slc";?>" id="feedback<?php echo"$slc";?>" cols="30%" rows="5" readonly><?php echo"$cgettugas[feedback]";?></textarea>
            
            <select name="nilaipencapaian<?php echo"$slc";?>" id="nilaipencapaian<?php echo"$slc";?>" onchange="cmdpilih(this.value,'<?php echo"$cprosedure[komposisi_group]";?>','<?php echo"$cprosedure[jml_loop]";?>','<?php echo"$fortable";?>','<?php echo"$cprosedure[bobot]";?>')" disabled>
            <option value="10" <?php if($cgettugas['nilai']=='10') echo"selected";?>>10</option>
            <option value="20" <?php if($cgettugas['nilai']=='20') echo"selected";?>>20</option>
            <option value="30"<?php if($cgettugas['nilai']=='30') echo"selected";?>>30</option>
            <option value="40"<?php if($cgettugas['nilai']=='40') echo"selected";?>>40</option>
            <option value="50"<?php if($cgettugas['nilai']=='50') echo"selected";?>>50</option>
            </select>
            <input type="hidden" name="bobotsatuan<?php echo"$slc";?>" id="bobotsatuan<?php echo"$slc";?>" value="<?php echo"$bobot";?>" />
            </td>
			</tr>
            <?php if($slc=='A3')
				{?>
                </tbody>
                </table>
                <?php
				}?>
		<?php	
				if($cgettugas['nilai']>0)
				{
					$pembagisub=$pembagisub+50;
					$pembagitotal=$pembagitotal+50;
				}
			}
			else
			{
            	if($fortable=='firstline' && $slc=='A4')
				{?>
            	<table class="table-bordered table-condensed" style="color:#000000; font-family:Arial, Helvetica, sans-serif;">
                <thead>
                <tr style="background:#CCCCCC;">
                    <td><?php echo"$i";?></td>
                    <th colspan="4"><?php echo"$data[0]";?></td>
                    <th width="7%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></td>
                  </tr>
                </thead>
            	<tbody>
               	<?php
				}
				else if($fortable=='firstline')
				{?>
					<tr style="background:#CCCCCC;">
                    <td><?php echo"$i";?></td>
                    <th colspan="4"><?php echo"$data[0]";?></td>
                    <th width="8%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></td>
                  </tr>
                <?php
				}?>
                
             <tr>
                <th width="3%">&nbsp;</td>
                    <th colspan="4"><?php echo"$data[1]";?></td>
                    <th width="7%">&nbsp;</td>
                  </tr>
            <?php
				$pembagisub=$pembagisub+50;
				$pembagitotal=$pembagitotal+50;
			}
			
						
			$getnilai=mysqli_query($koneksi, "select $slc,komentar from $transaksi_pa where nik='$nik'");
			$cgetnilai=mysqli_fetch_array($getnilai);	
			
			$namatocek="";
			$namatovalidasi="";
			$seltab="master_soal_".$fortable_select."_detail";
			$master_soal_detail=mysqli_query($koneksi, "select id,soal,nilai from $seltab where idgroup='$slc'");
			while($cmaster_soal_detail=mysqli_fetch_array($master_soal_detail))
			{
				$nama=$slc.'-'.$cmaster_soal_detail['id'];
				if($namatovalidasi==$slc)
				{
				}
				else
				{
					$namatocek=$namatocek.'|'.$slc;
				}				
				$nilai=($cmaster_soal_detail['nilai']*$bobot)/100;										
			?>
				<tr>
                <td>&nbsp;</td>
            	<td width="6%" style="background:#ffffaa; text-align:center;"><label style="cursor:pointer;width:100%;"><input type="radio" name="<?php echo"$slc";?>" value="<?php echo"$cmaster_soal_detail[nilai]";?>" id="<?php echo"$nama";?>" 
                onClick="cmdpilih(<?php echo"$cmaster_soal_detail[nilai]";?>,'<?php echo"$cprosedure[komposisi_group]";?>','<?php echo"$cprosedure[jml_loop]";?>','<?php echo"$fortable";?>','<?php echo"$cprosedure[bobot]";?>')" <?php if($cgetnilai[$slc]==$cmaster_soal_detail['nilai']) echo"checked";?> disabled></label>
                <input type="hidden" name="bobotsatuan<?php echo"$slc";?>" id="bobotsatuan<?php echo"$slc";?>" value="<?php echo"$bobot";?>" />
                </td>
            	<td colspan="3"><?php echo"$cmaster_soal_detail[soal]";?></td>
                <td style="text-align:right;"><?php echo"$cmaster_soal_detail[nilai]";?></td>
            	</tr>
            <?php
				
				$namatovalidasi=$slc;				
			}
			$subtotal=$subtotal+(($cgetnilai[$slc]*$bobot)/100);			
		}
		$subtotal=($subtotal/50)*100;
		$pembobotan=($subtotal*$cprosedure['bobot'])/100;
		$subtotal=number_format($subtotal,2);
		
		?>     
        <tr>
        	<td colspan="5" align="right">Sub-Total Score (<?php echo"$cprosedure[komposisi_group]";?>)</td>
            <td style="text-align:right;"><input type="text" name="total<?php echo"$cprosedure[komposisi_group]";?>" id="total<?php echo"$cprosedure[komposisi_group]";?>" style="width:50px;background:#ffb2a9;text-align:right;" value="<?php echo"$subtotal";?>" readonly>%</td>
        </tr>
        <tr>
        	<td colspan="5" align="right"><?php echo"$a13";?> (<?php echo"$cprosedure[bobot]%";?>)</td>
            <td style="text-align:right;"><input type="text" name="pembobotan<?php echo"$cprosedure[komposisi_group]";?>" id="pembobotan<?php echo"$cprosedure[komposisi_group]";?>" style="width:50px;background:#ffb2a9;text-align:right;" value="<?php echo"$pembobotan";?>" readonly>%
            <input type="hidden" name="pembagisub<?php echo"$cprosedure[komposisi_group]";?>" id="pembagisub<?php echo"$cprosedure[komposisi_group]";?>" value="<?php echo"$pembagisub";?>" />
            </td>
        </tr>
        <tr>
        	<td colspan="6" align="right">&nbsp;</td>
        </tr>   
      </tbody>    

<?php	
if($urut=='1')
	$headergroup=$cprosedure['komposisi_group'];
else
	$headergroup=$headergroup.','.$cprosedure['komposisi_group'];

$totalall=$totalall+$pembobotan;
$urut++;
}
$totalall=number_format($totalall,2);
$tahun=date('Y');
$cekkriteria=mysqli_query($koneksi, "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria 
where tahun='$tahun' order by id asc");
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
	if($totalall >= $rngs[$aa])
	{
		$grade=$g[$aa];
		break;
	}		
}

?>
		<tr>
        <td colspan="6"><?php echo"$cmaster_soal[komentar]";?><br>
        <textarea style="background:#ffffaa; width:50%;" class="textarea form-control" name="komentar" cols="50%" rows="7" readonly><?php echo"$cgetnilai[komentar]";?></textarea></td>
        </tr>
        <tr>
        	<td colspan="5"><!--<div  style="float:right;">]x100%</div><div id="pembagitotalview" style="float:right;"><?php echo"$pembagitotal";?></div><div  style="float:right;">TOTAL SCORE [(<?php echo"$headergroup";?>)/</div>-->
            <div  style="float:right;">TOTAL SCORE <?php echo"$a13";?> [(<?php echo"$headergroup";?>)]</div></td>
            <td style="text-align:right;"><input type="text" name="totalall" id="totalall" style="width:50px;background:#ffb2a9;text-align:right;"  readonly="readonly" value="<?php echo"$totalall";?>" readonly>%<br />
            <input type="text" name="nilaikriteria" id="nilaikriteria" style="width:50px;background:#ffb2a9;text-align:right;"  readonly="readonly" value="<?php echo"$grade";?>" readonly>&nbsp;&nbsp;&nbsp;
            
            <input type="hidden" name="totalall_seb" id="totalall_seb" style="width:50px;background:#ffb2a9;text-align:right;"  readonly="readonly" value="<?php echo"$totalall";?>">
            <input type="hidden" name="headergroup" id="headergroup" value="<?php echo"$headergroup";?>" />
            <input type="hidden" name="pembagitotal" id="pembagitotal" value="<?php echo"$pembagitotal";?>" />
            </td>
        </tr>
		<?php
		//=============================
		if($fortable=='managerial')
		{ 
			$cekjudul=mysqli_query($koneksi, "select * from master_soal_$fortable_select where id='1'");
			$ccekjudul=mysqli_fetch_array($cekjudul);
			$cekisi=mysqli_query($koneksi, "select * from $tugas_managerial where nik='$nik'");
			$ccekisi=mysqli_fetch_array($cekisi);
			?>
			<tr>
			<td colspan="6"><?php echo"$ccekjudul[ringkasan1]";?><br>
			<textarea style="background:#ffffaa; width:70%;" class="textarea form-control" name="ringkasan1" cols="100%" rows="7" readonly><?php echo"$ccekisi[ringkasan1]";?></textarea></td>
			</tr>
			<tr>
			<td colspan="6"><?php echo"$ccekjudul[ringkasan2]";?><br>
			<textarea style="background:#ffffaa; width:70%;" class="textarea form-control" name="ringkasan2" cols="100%" rows="7" readonly><?php echo"$ccekisi[ringkasan2]";?></textarea></td>
			</tr>
			<tr>
			<td colspan="6"><?php echo"$ccekjudul[ringkasan3]";?><br>
			<textarea style="background:#ffffaa; width:70%;" class="textarea form-control" name="ringkasan3" cols="100%" rows="7" readonly><?php echo"$ccekisi[ringkasan3]";?></textarea></td>
			</tr>
			<tr>
			<td colspan="6"><?php echo"$ccekjudul[ringkasan4]";?><br>
			<textarea style="background:#ffffaa; width:70%;" class="textarea form-control" name="ringkasan4" cols="100%" rows="7" readonly><?php echo"$ccekisi[ringkasan4]";?></textarea></td>
			</tr>
			<tr>
		<?php
			
		}
		//=============================
		?>
</table>
</div>
    </div>
  </div>
</section>
</div>
<script>
	window.print();
</script>