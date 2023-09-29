<?php
include("conf/conf.php");
include("tabel_setting.php");
// if($rcekkar['Kode_Golongan']=='GL022'||$rcekkar['Kode_Golongan']=='GL023'||$rcekkar['Kode_Golongan']=='GL025'||$rcekkar['Kode_Golongan']=='GL026'||$rcekkar['Kode_Golongan']=='GL028'||$rcekkar['Kode_Golongan']=='GL029'||$rcekkar['Kode_Golongan']=='GL031'){
	// $bahasa='eng';
// }else{
	// $bahasa=$_COOKIE['bahasa'];
// }

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

$nik = isset($_GET['nik']) ? $_GET['nik'] : '';
$nama_atasan1 = isset($_GET['superior']) ? $_GET['superior'] : '';
$nama_atasan2 = isset($_GET['headsuperior']) ? $_GET['headsuperior'] : '';
$email_atasan1 = isset($_GET['superioremail']) ? $_GET['superioremail'] : '';
$email_atasan2 = isset($_GET['headsuperioremail']) ? $_GET['headsuperioremail'] : '';
$statbawah = isset($_GET['statbawah']) ? $_GET['statbawah'] : '';
$statmember = isset($_GET['statmember']) ? $_GET['statmember'] : '';

if($nik=='')
{?>
	<script language="JavaScript">
		alert('Dilarang Refresh/Masukan NIK');
		document.location='home.php?link=dashboard';
	</script>
<?php	
exit;
}
$karyawanx=mysqli_query($koneksi,"select k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
dg.Nama_Golongan,dg.fortable,k.Nama_Jabatan,du.Nama_OU from $karyawan as k
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
left join daftarou as du on k.Kode_OU=du.Kode_OU
where k.NIK='$nik'");

$ckaryawan=mysqli_fetch_array($karyawanx);

if($ckaryawan['fortable']=='nonstaff')
{
	//$bahasa='ind';
	if($statmember=='Y'){
		$fortable='staff';
		if($bahasa=='eng')		
			$fortable_select='staff_english';
		else
			$fortable_select='staff';
	}else{
		$fortable='nonstaff';
		if($bahasa=='eng')		
			$fortable_select='nonstaff_english';
		else
			$fortable_select='nonstaff';
	}
}
else if($ckaryawan['fortable']=='staff')
{
	if($statbawah=='Y'){
		$fortable='staffb';
		if($bahasa=='eng')		
			$fortable_select='staffb_english';
		else
			$fortable_select='staffb';
	}else{
		$fortable='staff';
		if($bahasa=='eng')		
			$fortable_select='staff_english';
		else
			$fortable_select='staff';
	}
}
else if($ckaryawan['fortable']=='managerial')
{
	$fortable='managerial';
	if($bahasa=='eng')		
		$fortable_select='managerial_english';
	else
		$fortable_select='managerial';
		
	?>
	<div class="Top Nav Example">
		<marquee><h2 style="color:red;background-color:white;"> Sebagai Informasi, apabila proses penilaian dibiarkan terlalu lama maka Anda harus mengulang prosesnya dari awal. Dimohon untuk menyiapkan data-data yang diperlukan sebelum melakukan penilaian. Terima kasih</h2></marquee>
	</div>
	<?php
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


$getsp=mysqli_query($koneksi,"select statussp,periode from $tabel_sp where nik='$nik'");
$cgetsp=mysqli_fetch_array($getsp);

$statussp = isset($cgetsp['statussp']) ? $cgetsp['statussp'] : '';
$periode = isset($cgetsp['periode']) ? $cgetsp['periode'] : '';
?>
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
<script type="text/javascript">
function cmdcekdatakosong()
{
	var namatocek1=document.forminputeos.namatocek.value;
	//alert(namatocek1);
	var arraynama = namatocek1.split('|');
	var pnj = arraynama.length;
	
	var konf="Yakin dengan jawaban anda?";
	var soal1="Soal no";
	var soal2="belum dipilih!!!";
	
	if(confirm(konf))
	{			
		document.getElementById('proses').style.display = 'inline';
		for (a = 1; a<pnj; a++)
		{
			pilih = ""
			var r1 = arraynama[a];		
			var len = forminputeos.elements[r1].length;
				
			for (i = 0; i <len; i++) 
			{
				var subcek = forminputeos.elements[r1];
				if (subcek[i].checked) 
				{
					pilih = subcek[i].value;
				}
			}
			
			if (pilih == "") 
			{
				alert(soal1+' '+arraynama[a]+' '+soal2);			
				return false;
			}			
		}
		
		if(document.getElementById('totalall').value=='')
		{
			alert('Error Script, Total Nilai tidak terisi');			
			return false;
		}
		else if(document.getElementById('totalall').value=='NAN')
		{
			alert('Error Script, Total Nilai tidak terisi');			
			return false;
		}
		else if(document.getElementById('totalall').value=='NaN')
		{
			alert('Error Script, Total Nilai tidak terisi');			
			return false;
		}
		
		return true;
	}
	return false;
}
function cmdnilaikriteria(nilai)
{
	if(nilai>=91)
	{
		var grade="A";
		var kesimpulan="Selalu melampaui harapan";
	}
	else if(nilai>=76)
	{
		var grade="B";
		var kesimpulan="Selalu memenuhi dan kadang-kadang melampaui harapan";
	}
	else if(nilai>=60)
	{
		var grade="C";
		var kesimpulan="Memenuhi harapan";
	}
	else if(nilai>=40)
	{
		var grade="D";
		var kesimpulan="Tidak selalu memenuhi harapan";
	}
	else
	{
		var grade="E";
		var kesimpulan="Tidak memenuhi harapan";
	}
	document.getElementById('nilaikriteria').value=grade;
}
function cmdpilih(nilai,id,loop,ftable,bobot)
{
	//alert(nilai+''+id);
	var idt='total'+id;
	//var idt_tampil='totaltampil'+id;
	var total=document.getElementById(idt).value;
	var ctk=0;
	//var pembagi=0;
	if(ftable=='firstline')
	{
		if(id=='A')
		{
			for(c=1;c<=loop;c++)
			{
				if(c<4)
				{
					//alert('a');
					var seld='nilaipencapaian'+id+c;
					if(document.getElementById(seld).disabled == false)
					{
						var id_bobotsatuan='bobotsatuan'+id+c;
						bobotsatuan=document.getElementById(id_bobotsatuan).value;
						ctk=ctk+(((document.getElementById(seld).value*1)*(bobotsatuan*1))/100);
					}
				}
				else
				{
					pilih = ""
					var r1 = id.concat(c);
					var len = forminputeos.elements[r1].length;
						
					for (i = 0; i <len; i++) 
					{
						var subcek = forminputeos.elements[r1];
						if (subcek[i].checked) 
						{
							pilih = subcek[i].value;				
						}
					}
					if(pilih>0)
					{
						var id_bobotsatuan='bobotsatuan'+r1;
						bobotsatuan=document.getElementById(id_bobotsatuan).value;
						ctk=ctk+(((pilih*1)*(bobotsatuan*1))/100);
					}
				}
			}
		}
		else
		{
			for(c=1;c<=loop;c++)
			{	
				pilih = ""
				var r1 = id.concat(c);
				var len = forminputeos.elements[r1].length;
					
				for (i = 0; i <len; i++) 
				{
					var subcek = forminputeos.elements[r1];
					if (subcek[i].checked) 
					{
						pilih = subcek[i].value;				
					}
				}
				if(pilih>0)
				{
					var id_bobotsatuan='bobotsatuan'+r1;
					bobotsatuan=document.getElementById(id_bobotsatuan).value;
					ctk=ctk+(((pilih*1)*(bobotsatuan*1))/100);
				}
				//pembagi=pembagi+50;
			}
		}
	}
	else
	{
		for(c=1;c<=loop;c++)
		{	
			pilih = ""
			var r1 = id.concat(c);
			var len = forminputeos.elements[r1].length;
				
			for (i = 0; i <len; i++) 
			{
				var subcek = forminputeos.elements[r1];
				if (subcek[i].checked) 
				{
					pilih = subcek[i].value;				
				}
			}
			if(pilih>0)
			{
				var id_bobotsatuan='bobotsatuan'+r1;
				bobotsatuan=document.getElementById(id_bobotsatuan).value;
				ctk=ctk+(((pilih*1)*(bobotsatuan*1))/100);
			}
			//pembagi=pembagi+50;
		}
	}	
	var pembobotan='pembobotan'+id;
	
	document.getElementById(idt).value=(((ctk*1)/50)*100).toFixed(2);
	document.getElementById(pembobotan).value=(((((ctk*1)/50)*100).toFixed(2)*bobot)/100).toFixed(2);
	
	var headergroup=document.getElementById('headergroup').value.split(',');
	pnj=headergroup.length;
	var totalcetak=0;
	for(i=0;i<pnj;i++)
	{
		var pembobotan='pembobotan'+headergroup[i];
		totalcetak=totalcetak+(document.getElementById(pembobotan).value*1);
	}
	document.getElementById('totalall').value=totalcetak;
	cmdnilaikriteria(totalcetak.toFixed(2));
}
</script>
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
<div id="proses" class="proses" style="display: none"></div>
<section class="col-lg-12 connectedSortable">
  <div class="nav-tabs-custom">
	<div class="box box-danger">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo"<b>$a1</b>";?></h3>
        </div>
        <div class="box-body">
<form name="forminputeos" method="post" action="savepa.php" onsubmit="return cmdcekdatakosong()">
<table class="table table-bordered">
    <thead>
        <tr>
            <th><?php echo"$a2";?></th>
            <td style="width:35%;"><?php echo"$ckaryawan[Nama_Lengkap]";?></td>
            <th><?php echo"$a3";?></th>
            <td  style="width:35%;"><?php echo"$ckaryawan[Nama_Perusahaan] / $ckaryawan[Nama_OU]";?></td>  
        </tr>
        <tr>
            <th><?php echo"$a4";?></th>
            <td><?php echo"$ckaryawan[NIK]";?></td>
            <th><?php echo"$a5";?></th>
            <td><?php echo"$ckaryawan[Nama_Departemen]";?></td>  
        </tr>
        <tr>
            <th><?php echo"$a6";?></th>
            <td><?php echo"$ckaryawan[Nama_Jabatan]";?></td>
            <th><?php echo"$a7";?></th>
            <td><?php echo"-";?></td>  
        </tr>
        <tr>
            <th><?php echo"$a8";?></th>
            <td><?php echo"$ckaryawan[Mulai_Bekerja]";?></td>
            <th><?php echo"$a9";?></th>
            <td><?php 
			$yearnow	= Date('Y');
			echo"$yearnow";?></td>  
        </tr>
        <tr>
            <th><?php echo"$a10";?></th>
            <td><?php echo"$ckaryawan[Nama_Golongan]";?></td>
            <th><?php echo"$a11";?></th>
            <td><?php echo"$statussp / $periode";?></td>  
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
		?>
        <tr>
            <th colspan="4" style="border:none;"><?php echo"$a14";?></th> 
        </tr>
         <tr>
            <th colspan="4" style="border:none;">1. <?php echo"$a15";?><br />
            <textarea name="tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control"></textarea>
            </th> 
        </tr>
         <tr>
            <th colspan="4" style="border:none;">2. <?php echo"$a16";?><br />
            <textarea name="penilaian_tugas" rows="7" style="background:#ffffaa; width:70%;" class="textarea form-control"></textarea></th> 
        </tr>
        <?php
		}?>
    </thead>
</table><br />
<table class="table table-bordered" style="color:#000000; font-family:Arial, Helvetica, sans-serif;">
<?php
$urut=1;
$headergroup="";
$pembagitotal=0;
$prosedure=mysqli_query($koneksi,"select komposisi_group,nama_group,jml_loop,fortable,bobot from $tabel_prosedure where fortable='$fortable' order by id");
while($cprosedure=mysqli_fetch_array($prosedure))
{
	//$bobot=$cprosedure[bobot];
?>
	
      <thead>
      <tr style="background:#dd4b39; color:#ffffff;">
        <th width="2%"><?php echo"$cprosedure[komposisi_group]";?></th>
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
       		<th colspan="5"><?php echo"$cprosedure[nama_group]";?></th>
            </tr>
            <tr>
            <th>&nbsp;</th>
            <th width="28%"><?php echo"$a17";?></th>
            <th width="43%"><?php echo"$a18";?></th>
            <th colspan="3" style="text-align:center;"><?php echo"$a19";?></th>
            </tr>
        <?php
		}
		else
		{?>
        <th colspan="4"><?php echo"$cprosedure[nama_group]";?></th>  
        <th width="13%" style="text-align:center;"><?php echo"$a12";?></th>  
        </tr>
        <?php
		}?>      
      </thead>
      <tbody>
      	<?php
		$pembagisub=0;
		$namatocek="";
		$namatovalidasi="";
		for($i=1;$i<=$cprosedure['jml_loop'];$i++)
		{
			$slc=$cprosedure['komposisi_group'].$i;
			$master_soal=mysqli_query($koneksi,"select $slc,komentar from master_soal_$fortable_select where id='1'");
			$cmaster_soal=mysqli_fetch_array($master_soal);
			
			$bobot_data=mysqli_query($koneksi,"select $slc from master_soal_$fortable_select where id='2'");
			$cbobot=mysqli_fetch_array($bobot_data);
			
			$bobot=$cbobot[$slc]/($cprosedure['bobot']/100);
			
			$data=explode('|',$cmaster_soal[$slc]);
			
			if($fortable<>'firstline')
			{
		?>
			<tr style="background:#CCCCCC;">
            <th><?php echo"$i";?></th>
            <th colspan="4"><?php echo"$data[0]";?></th>
            <th width="13%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></th>
            </tr>
            <?php
			}
			if($fortable=='firstline' && ($slc=='A1' || $slc=='A2' || $slc=='A3'))
			{?>
            	<tr style="background:#CCCCCC;">
            <th><?php echo"$i";?></th>
            <th colspan="4"><?php echo"$data[0]";?></th>
            <th width="13%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></th>
            </tr>
                <tr>
                <td></td>
                <td style="width:30%;"><textarea  style="background:#ffffaa;" class="form-control" name="sasaran<?php echo"$slc";?>" id="sasaran<?php echo"$slc";?>" cols="30%" rows="5"></textarea></td>
                <td style="width:30%;"><textarea style="background:#ffffaa;" class="form-control" name="pencapaian<?php echo"$slc";?>" id="pencapaian<?php echo"$slc";?>" cols="30%" rows="5"></textarea></td>
                <td colspan="3" style="text-align:right;width:10%;">
                <textarea style="background:#ffffaa;" class="form-control" name="feedback<?php echo"$slc";?>" id="feedback<?php echo"$slc";?>" cols="30%" rows="5"></textarea>
                
                <select name="nilaipencapaian<?php echo"$slc";?>" id="nilaipencapaian<?php echo"$slc";?>" onchange="cmdpilih(this.value,'<?php echo"$cprosedure[komposisi_group]";?>','<?php echo"$cprosedure[jml_loop]";?>','<?php echo"$fortable";?>','<?php echo"$cprosedure[bobot]";?>')">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
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
			}
			else
			{
				if($fortable=='firstline' && $slc=='A4')
				{?>
            	<table class="table-bordered table-condensed" style="color:#000000; font-family:Arial, Helvetica, sans-serif;">
                <thead>
                <tr style="background:#CCCCCC;">
                    <th><?php echo"$i";?></th>
                    <th colspan="4"><?php echo"$data[0]";?></th>
                    <th width="8%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></th>
                  </tr>
                </thead>
            	<tbody>
               	<?php
				}
				else if($fortable=='firstline')
				{?>
					<tr style="background:#CCCCCC;">
                    <th><?php echo"$i";?></th>
                    <th colspan="4"><?php echo"$data[0]";?></th>
                    <th width="8%" style="text-align:right;"><?php echo"$cbobot[$slc]%";?></th>
                  </tr>
                <?php
				}
				?>
                  <tr>
                    <th width="3%">&nbsp;</th>
                    <th colspan="4"><?php echo"$data[1]";?></th>
                    <th width="8%">&nbsp;</th>
                  </tr>
            <?php
				$pembagisub=$pembagisub+50;
				$pembagitotal=$pembagitotal+50;
			}
			
			
			$seltab="master_soal_".$fortable_select."_detail";
			$master_soal_detail=mysqli_query($koneksi,"select id,soal,nilai from $seltab where idgroup='$slc'");
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
                <td>&nbsp;</th>
            	<td width="6%" style="background:#ffffaa; text-align:center;"><label style="cursor:pointer;width:100%;"><input type="radio" name="<?php echo"$slc";?>" value="<?php echo"$cmaster_soal_detail[nilai]";?>" id="<?php echo"$nama";?>" 
                onClick="cmdpilih(<?php echo"$nilai";?>,'<?php echo"$cprosedure[komposisi_group]";?>','<?php echo"$cprosedure[jml_loop]";?>','<?php echo"$fortable";?>','<?php echo"$cprosedure[bobot]";?>')"></label>
                <input type="hidden" name="bobotsatuan<?php echo"$slc";?>" id="bobotsatuan<?php echo"$slc";?>" value="<?php echo"$bobot";?>" />
                </td>
            	<td colspan="3" ><?php echo"$cmaster_soal_detail[soal]";?></td>
                <td style="text-align:right;"><?php echo"$cmaster_soal_detail[nilai]";?></td>
            	</tr>
            <?php
				$namatovalidasi=$slc;				
			}			
		}
		?>     
        <tr>
        	<td colspan="5" align="right">Sub-Total Score (<?php echo"$cprosedure[komposisi_group]";?>)</td>
            <td style="text-align:right;"><input type="text" name="total<?php echo"$cprosedure[komposisi_group]";?>" id="total<?php echo"$cprosedure[komposisi_group]";?>" style="width:50px;background:#ffb2a9;text-align:right;">%</td>
        </tr>
        <tr>
        	<td colspan="5" align="right"><?php echo"$a13";?>(<?php echo"$cprosedure[bobot]%";?>)</td>
            <td style="text-align:right;"><input type="text" name="pembobotan<?php echo"$cprosedure[komposisi_group]";?>" id="pembobotan<?php echo"$cprosedure[komposisi_group]";?>" style="width:50px;background:#ffb2a9;text-align:right;">%
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
$urut++;
}
?>
		<tr>
        <td colspan="6"><?php echo"$cmaster_soal[komentar]";?><br><textarea style="background:#ffffaa; width:50%;" class="textarea form-control" name="komentar" rows="7"></textarea></td>
        </tr>
        <tr>
        	<td colspan="5"><!--<div  style="float:right;">]x100%</div><div id="pembagitotalview" style="float:right;"><?php echo"$pembagitotal";?></div><div  style="float:right;">TOTAL SCORE [(<?php echo"$headergroup";?>)/</div>-->
            <div  style="float:right;">TOTAL SCORE <?php echo"$a13";?> [(<?php echo"$headergroup";?>)]</div>
            </td>
            <td style="text-align:right;">
            <input type="text" name="totalall" id="totalall" style="width:50px;background:#ffb2a9;text-align:right;"  readonly="readonly">%<br />
            <input type="text" name="nilaikriteria" id="nilaikriteria" style="width:50px;background:#ffb2a9;text-align:right;"  readonly="readonly">&nbsp;&nbsp;&nbsp;
            <input type="hidden" name="headergroup" id="headergroup" value="<?php echo"$headergroup";?>" />
            <input type="hidden" name="pembagitotal" id="pembagitotal" value="<?php echo"$pembagitotal";?>" />
            </td>
        </tr>
		<tr>
        	<td><input type="hidden" name="namatocek" id="namatocek" value="<?php echo"$namatocek";?>" />
            <input type="hidden" name="fortable" id="fortable" value="<?php echo"$fortable";?>" />
            </td>
            <td><button type="submit" name="btnsave" class="btn btn-success">Submit</button></td>
            <td colspan="4"></td>
        </tr>
</table>
</form>
        </div>
    </div>
  </div>
</section>
</div>