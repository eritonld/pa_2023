<?php
session_start();
include("tabel_setting.php");
include("conf/conf.php");

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

$totalall		= $_POST['totalall'];
if(isset($_SESSION['idmaster_pa']))
{
	$idmaster_pa=$_SESSION['idmaster_pa'];
	
	$cekuser = mysqli_query($koneksi,"SELECT * FROM `user_pa` where id='$idmaster_pa'");
	$scekuser = mysqli_fetch_array($cekuser);
	
	$nik_input=$scekuser['username'];
	$input_by=$idmaster_pa;

	if(mysqli_query($koneksi, "start transaction"))
	{
		try
		{
			$nik			= $_POST['nik'];
			$atasan1		= $_POST['atasan1'];
			$atasan2		= $_POST['atasan2'];
			$emailatasan1	= $_POST['emailatasan1'];	
			$emailatasan2	= $_POST['emailatasan2'];
			
			$tahun=date('Y');
			$cekkriteria=mysqli_query($koneksi, "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria 
			where tahun='$tahun' order by id asc");
			$ak=0;
			while($ccekkriteria=mysqli_fetch_array($cekkriteria))
			{
				$rngs[$ak]=$ccekkriteria['ranges'];
				$k[$ak]=$ccekkriteria['kesimpulan'];
				$g[$ak]=$ccekkriteria['grade'];
				$w[$ak]=$ccekkriteria['warna'];
				$ic[$ak]=$ccekkriteria['icon'];
				$ak++;
				
				if($ccekkriteria['bermasalah']=='T')
					$batasatastampil=$ccekkriteria['ranges'];
			}
			
			$kesimpulan="Tidak memenuhi harapan";
			$grade="E";
			$warna="000000";
			for($aa=0;$aa<$ak;$aa++)
			{		
				if($totalall >= $rngs[$aa])
				{
					$kesimpulan=$k[$aa];
					$grade=$g[$aa];
					$warna=$w[$aa];
					break;
				}		
			}
			
			$fortable=$_POST['fortable'];
			$komentar=$_POST['komentar'];	
			$komentar=str_replace("'","",$komentar);
			$komentar=str_replace('"','',$komentar);			
			
			$ins=mysqli_query($koneksi,"insert into $transaksi_pa (nik,fortable,total,komentar,input_by,date_input,periode) values 
			('$nik','$fortable','$totalall','$komentar','$input_by',now(),'$quartal_periode')");
			$ins_awal=mysqli_query($koneksi,"insert into $transaksi_pa_awal (nik,fortable,total,komentar,input_by,date_input,periode) values 
			('$nik','$fortable','$totalall','$komentar','$input_by',now(),'$quartal_periode')");
			
			if($atasan1==$nik_input){
				$upd=mysqli_query($koneksi,"update $transaksi_pa set edit_by='$input_by', date_edit=now() where nik='$nik'");
				$upd=mysqli_query($koneksi,"update $transaksi_pa_awal set edit_by='$input_by', date_edit=now() where nik='$nik'");
			}
			
			if($fortable=='managerial')
			{
				$tugas=str_replace("'","",$_POST['tugas']);
				$tugas=str_replace('"','',$tugas);
				$penilaian_tugas=$_POST['penilaian_tugas'];
				$ins=mysqli_query($koneksi,"insert into $tugas_managerial (nik,tugas,penilaian_tugas,input_by,date_input,periode) values 
			('$nik','$tugas','$penilaian_tugas','$input_by',now(),'$quartal_periode')");
			}
			
			$prosedure=mysqli_query($koneksi,"select komposisi_group,jml_loop,fortable from prosedure where fortable='$fortable' order by id");
			while($cprosedure=mysqli_fetch_array($prosedure))
			{			
				for($i=1;$i<=$cprosedure['jml_loop'];$i++)
				{				
					$slc=$cprosedure['komposisi_group'].$i;
					if($fortable=='firstline' && ($slc=='A1' || $slc=='A2' || $slc=='A3'))
					{
						$getcek="cek".$slc;
						$cek=$_POST[$getcek];
						//if($cek=='T')
						//{
							$getsasaran="sasaran".$slc;
							$sasaran=$_POST[$getsasaran];
							$sasaran=str_replace("'","",$sasaran);
							$sasaran=str_replace('"','',$sasaran);
							
							$getpencapaian="pencapaian".$slc;
							$pencapaian=$_POST[$getpencapaian];
							$pencapaian=str_replace("'","",$pencapaian);
							$pencapaian=str_replace('"','',$pencapaian);
							
							$getnilaipencapaian="nilaipencapaian".$slc;
							$nilaipencapaian=$_POST[$getnilaipencapaian];
							$nilaipencapaian=str_replace("'","",$nilaipencapaian);
							$nilaipencapaian=str_replace('"','',$nilaipencapaian);
							
							$getfeedback="feedback".$slc;
							$feedback=$_POST[$getfeedback];
							$feedback=str_replace("'","",$feedback);
							$feedback=str_replace('"','',$feedback);
							
							$ins=mysqli_query($koneksi,"insert into $transaksi_pa_detail (nik,group_transaksi,sasaran,pencapaian,nilai,periode,feedback) 
							values ('$nik','$slc','$sasaran','$pencapaian','$nilaipencapaian','$quartal_periode','$feedback')");
							$upd=mysqli_query($koneksi,"update $transaksi_pa set $slc='$nilaipencapaian' where nik='$nik'");
							$upd_awal=mysqli_query($koneksi,"update $transaksi_pa_awal set $slc='$nilaipencapaian' where nik='$nik'");
						/*}
						else
						{
							$upd=mysql_query("update transaksi_pa set $slc='0' where nik='$nik'");
						}*/
					}
					else
					{				
						$nilai=$_POST[$slc];
						$upd=mysqli_query($koneksi,"update $transaksi_pa set $slc='$nilai' where nik='$nik'");
						$upd_awal=mysqli_query($koneksi,"update $transaksi_pa_awal set $slc='$nilai' where nik='$nik'");
					}
				}
			}
			$iduseract 	= $idmaster_pa;
			$nikpa	   	= $nik;
			$activity	= "Insert PA Data" ;
			
			include("activity.php");
			include("atasan.php");
			include("savepa_email.php");			
			
			mysqli_query($koneksi, "COMMIT");
			
			?>
			<script language="JavaScript">
				alert('Berhasil');
				document.location='home.php?link=mydata';
			</script>
			<?php
		}
		catch(Exception $e)
		{
			mysqli_query($koneksi, "ROLLBACK");
			?>
			<script language="JavaScript">
				alert('Gagal');
				document.location='home.php?link=mydata';
			</script>
			<?php
		}
	}
}
else
{
	?>
	<script>
		alert('Gagal, Waktu pengisian terlalu lama');
		window.location="index.php";
	</script>
	<?php
}
?>