<?php
session_start();

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

include("../tabel_setting.php");
//$bahasa='eng';
if(isset($_SESSION["idmaster_pa_admin"]))
{
	$idmaster_pa_admin=$_SESSION["idmaster_pa_admin"];

include("../conf/conf.php");
$input_by=$idmaster_pa_admin;

	if(mysqli_query($koneksi, "start transaction"))
	{
		try
		{
			$nik			=$_POST['nik'];
			$atasan1		= $_POST['atasan1'];
			$atasan2		= $_POST['atasan2'];
			$emailatasan1	= $_POST['emailatasan1'];	
			$emailatasan2	= $_POST['emailatasan2'];
			$totalall		= $_POST['totalall'];
			$totalall_seb	= $_POST['totalall_seb'];
			
			$tahun=date('Y');
			$cekkriteria=mysqli_query($koneksi,"select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria 
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
			
			for($aa=0;$aa<$ak;$aa++)
			{		
				if($totalall_seb > $rngs[$aa])
				{
					$kesimpulan_seb=$k[$aa];
					$grade_seb=$g[$aa];
					$warna_seb=$w[$aa];
					break;
				}		
			}
			
			$fortable=$_POST['fortable'];
			$komentar=$_POST['komentar'];
			$komentar=str_replace("'","",$komentar);
			$komentar=str_replace('"','',$komentar);	
			
			$ins=mysqli_query($koneksi,"update $transaksi_pa set fortable='$fortable',total='$totalall',komentar='$komentar',edit_komite='$input_by',date_edit_komite=now() where nik='$nik'");					
			
			if($fortable=='managerial')
			{
				$tugas=str_replace("'","",$_POST[tugas]);
				$tugas=str_replace("'",'',$tugas);
				$ringkasan1=str_replace("'","",$_POST[ringkasan1]);
				$ringkasan1=str_replace("'",'',$ringkasan1);
				$ringkasan2=str_replace("'","",$_POST[ringkasan2]);
				$ringkasan2=str_replace("'",'',$ringkasan2);
				$ringkasan3=str_replace("'","",$_POST[ringkasan3]);
				$ringkasan3=str_replace("'",'',$ringkasan3);
				$ringkasan4=str_replace("'","",$_POST[ringkasan4]);
				$ringkasan4=str_replace("'",'',$ringkasan4);
				$penilaian_tugas=$_POST[penilaian_tugas];
				$ins=mysqli_query($koneksi,"update $tugas_managerial set tugas='$tugas',ringkasan1='$ringkasan1',ringkasan2='$ringkasan2',ringkasan3='$ringkasan3',ringkasan4='$ringkasan4',penilaian_tugas='$penilaian_tugas',edit_by='$input_by',date_edit=now()
				where nik='$nik'");
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
						/*if($cek=='T')
						{*/
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
							
							$sudahada=mysqli_query($koneksi,"select * from $transaksi_pa_detail where nik='$nik' and group_transaksi='$slc'");
							$hsudahada=mysqli_num_rows($sudahada);
							if($hsudahada>0)
							{						
								$ins=mysqli_query($koneksi,"update $transaksi_pa_detail set 
								sasaran='$sasaran',pencapaian='$pencapaian',nilai='$nilaipencapaian',feedback='$feedback' where nik='$nik' and group_transaksi='$slc'");
							}
							else
							{
								$ins=mysqli_query($koneksi,"insert into $transaksi_pa_detail (nik,group_transaksi,sasaran,pencapaian,nilai,periode,feedback) 
							values ('$nik','$slc','$sasaran','$pencapaian','$nilaipencapaian','$quartal_periode','$feedback')");
							}
							$upd=mysqli_query($koneksi,"update $transaksi_pa set $slc='$nilaipencapaian',komentar='$komentar' where nik='$nik'");
						/*}
						else
						{
							$del=mysql_query("delete from transaksi_pa_detail where nik='$nik' and group_transaksi='$slc'");
							$upd=mysql_query("update transaksi_pa set $slc='0' where nik='$nik'");
						}*/	
					}
					else
					{				
						$nilai=$_POST[$slc];
						$upd=mysqli_query($koneksi,"update $transaksi_pa set $slc='$nilai',komentar='$komentar' where nik='$nik'");		
					}
				}
			}
			$iduseract 	= $idmaster_pa_admin;
			$nikpa	   	= $nik;
			$activity	= "Edit PA Data Committee" ;
			
			// include("savepa_edit_email.php");
			include("activity.php");
			// include("atasan.php");			
			
			mysqli_query($koneksi,"COMMIT");			
			?>
			<script language="JavaScript">
				alert('Berhasil');
				document.location='home.php?link=dataapp';
			</script>
			<?php
		}
		catch(Exception $e)
		{
			mysqli_query($koneksi,"ROLLBACK");
			?>
			<script language="JavaScript">
				alert('Gagal');
				document.location='home.php?link=dataapp';
			</script>
			<?php
		}
	}
}
else
{
	?>
	<script>
		alert('Login as Administrator First');
		window.location="index.php";
	</script>
	<?php
}
?>