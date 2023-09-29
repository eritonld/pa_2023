<?php
include("../conf/conf.php");
include("../function.php");
set_time_limit(0);

$no			= 1;
$date		= Date('Y-m-d');
$datetime	= Date('Y-m-d H:i:s');
$yearnow	= Date('Y');
$cutoff		= $yearnow."-07-01";

$totalallkaryawan=0;
$totalallpenilaian=0;
$totalallbelum=0;

$totalallkaryawanns=0;
$totalallpenilaianns=0;
$totalallbelumns=0;
$group		= "";

?>
<table border=1>
	<tr style='background:#F08080;'>
		<th rowspan=2>No</th>
		<th rowspan=2>Nama Unit</th>
		<th colspan=4>Staff</th>
		<th colspan=4>Non Staff</th>
	</tr>
	<tr style='background:#F08080;'>
		<th>Jumlah</th>
		<th>Sudah</th>
		<th>Belum</th>
		<th>% </th>
		<th>Jumlah</th>
		<th>Sudah</th>
		<th>Belum</th>
		<th>% </th>
	</tr>
	<?php
	$cekgroup=mysql_query("SELECT grouping FROM `daftarou` where aktif='T' group by grouping asc");
	while($scekgroup=mysql_fetch_array($cekgroup)){
		$totalkaryawan=0;
		$totalpenilaian=0;
		$totalbelum=0;
		
		$totalkaryawanns=0;
		$totalpenilaianns=0;
		$totalbelumns=0;
	
		$cekdataou=mysql_query("SELECT Kode_OU, Nama_OU, grouping, persen FROM `daftarou` where aktif='T' and grouping='$scekgroup[grouping]' ORDER BY Nama_OU asc");
		while($scekdataou=mysql_fetch_array($cekdataou)){
			//staff
			$cekjumlahpa = mysql_query("SELECT COUNT(k.NIK) as jumlahkaryawan, COUNT(t.nik) as jumlahpenilaian, (COUNT(k.NIK)-COUNT(t.nik)) as jumlahbelum, ROUND((COUNT(t.nik)/COUNT(k.NIK))*100,1) as persen  FROM `karyawan_2021` as k
			left join transaksi_pa_q1_2021 as t on t.nik=k.NIK
			where k.Kode_OU='$scekdataou[Kode_OU]' and k.Kode_StatusKerja<>'SKH05' and k.Kode_Golongan>'GL011' and k.Mulai_Bekerja <= '$cutoff'");
			$scekjumlahpa = mysql_fetch_array($cekjumlahpa);
			
			$totalkaryawan = $totalkaryawan+$scekjumlahpa['jumlahkaryawan'];
			$totalpenilaian = $totalpenilaian+$scekjumlahpa['jumlahpenilaian'];
			$totalbelum = $totalbelum+$scekjumlahpa['jumlahbelum'];
			
			$totalallkaryawan=$totalallkaryawan+$scekjumlahpa['jumlahkaryawan'];
			$totalallpenilaian=$totalallpenilaian+$scekjumlahpa['jumlahpenilaian'];
			$totalallbelum=$totalallbelum+$scekjumlahpa['jumlahbelum'];
					
			$warna="";
			if($scekjumlahpa['persen']>'0' && $scekjumlahpa['persen']<='50'){$warna="style='background:#CCFFCC;'";}
			if($scekjumlahpa['persen']>'50'){$warna="style='background:#7FFF00;'";}
			if($scekjumlahpa['persen']=='100,0'){$warna="style='background:#FFD700;'";}
			
			//Non staff
			$cekjumlahpans = mysql_query("SELECT COUNT(k.NIK) as jumlahkaryawan, COUNT(t.nik) as jumlahpenilaian, (COUNT(k.NIK)-COUNT(t.nik)) as jumlahbelum, ROUND((COUNT(t.nik)/COUNT(k.NIK))*100,1) as persen  FROM `karyawan_2021` as k
			left join transaksi_pa_q1_2021 as t on t.nik=k.NIK
			where k.Kode_OU='$scekdataou[Kode_OU]' and k.Kode_StatusKerja<>'SKH05' and k.Kode_Golongan<'GL012' and k.Mulai_Bekerja <= '$cutoff'");
			$scekjumlahpans = mysql_fetch_array($cekjumlahpans);
			
			$totalkaryawanns = $totalkaryawanns+$scekjumlahpans['jumlahkaryawan'];
			$totalpenilaianns = $totalpenilaianns+$scekjumlahpans['jumlahpenilaian'];
			$totalbelumns = $totalbelumns+$scekjumlahpans['jumlahbelum'];
			
			$totalallkaryawanns=$totalallkaryawanns+$scekjumlahpans['jumlahkaryawan'];
			$totalallpenilaianns=$totalallpenilaianns+$scekjumlahpans['jumlahpenilaian'];
			$totalallbelumns=$totalallbelumns+$scekjumlahpans['jumlahbelum'];
					
			$warnans="";
			if($scekjumlahpans['persen']>'0' && $scekjumlahpans['persen']<='50'){$warnans="style='background:#CCFFCC;'";}
			if($scekjumlahpans['persen']>'50'){$warnans="style='background:#7FFF00;'";}
			if($scekjumlahpans['persen']=='100,0'){$warnans="style='background:#FFD700;'";}
			
			echo "
			<tr>
				<td>$no</td>
				<td>$scekdataou[Nama_OU]</td>
				<td style='background:#F5F5DC;'>$scekjumlahpa[jumlahkaryawan]</td>
				<td>$scekjumlahpa[jumlahpenilaian]</td>
				<td style='color:red;'>$scekjumlahpa[jumlahbelum]</td>
				<td $warna>$scekjumlahpa[persen] %</td>
				<td style='background:#F5F5DC;'>$scekjumlahpans[jumlahkaryawan]</td>
				<td>$scekjumlahpans[jumlahpenilaian]</td>
				<td style='color:red;'>$scekjumlahpans[jumlahbelum]</td>
				<td $warnans>$scekjumlahpans[persen] %</td>
			</tr>
			";
			
			$group=$scekdataou['grouping'];
			$no++;
		}
		if($totalkaryawan==0){$hitunggroup=0;}else{$hitunggroup=(($totalpenilaian/$totalkaryawan)*100);}
		$spersengroup=number_format($hitunggroup,1,",",".")." %";
		
		if($totalkaryawanns==0){$hitunggroupns=0;}else{$hitunggroupns=(($totalpenilaianns/$totalkaryawanns)*100);}
		$spersengroupns=number_format($hitunggroupns,1,",",".")." %";
		echo "
		<tr>
			<td colspan=2 style='background:#D2B48C;'>$group</td>
			<td style='background:#D2B48C;'>$totalkaryawan</td>
			<td style='background:#D2B48C;'>$totalpenilaian</td>
			<td style='background:#D2B48C;'>$totalbelum</td>
			<td style='background:#F5F5DC;'><b>$spersengroup</b></td>
			<td style='background:#D2B48C;'>$totalkaryawanns</td>
			<td style='background:#D2B48C;'>$totalpenilaianns</td>
			<td style='background:#D2B48C;'>$totalbelumns</td>
			<td style='background:#F5F5DC;'><b>$spersengroupns</b></td>
		</tr>
		";
	}
	$hitungallgroup=(($totalallpenilaian/$totalallkaryawan)*100);
	$shitungallgroup=number_format($hitungallgroup,1,",",".")." %";
	
	$hitungallgroupns=(($totalallpenilaianns/$totalallkaryawanns)*100);
	$shitungallgroupns=number_format($hitungallgroupns,1,",",".")." %";
	?>

<tr>
	<td colspan=2 style='background:#F08080;'><b>TOTAL</b></td>
	<td style='background:#F08080;'><b><?php echo "$totalallkaryawan"; ?></b></td>
	<td style='background:#F08080;'><b><?php echo "$totalallpenilaian"; ?></b></td>
	<td style='background:#F08080;'><b><?php echo "$totalallbelum"; ?></b></td>
	<td style='background:#FFD700;'><b><?php echo "$shitungallgroup"; ?></b></td>
	
	<td style='background:#F08080;'><b><?php echo "$totalallkaryawanns"; ?></b></td>
	<td style='background:#F08080;'><b><?php echo "$totalallpenilaianns"; ?></b></td>
	<td style='background:#F08080;'><b><?php echo "$totalallbelumns"; ?></b></td>
	<td style='background:#FFD700;'><b><?php echo "$shitungallgroupns"; ?></b></td>
</tr>
</table>