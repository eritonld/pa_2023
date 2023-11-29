<?php
include("../conf/conf.php");

$sql = "SELECT cp.nik, k1.id as idkar, k1.Nama_Lengkap,
cp.nik_peers1, p1.id as id_peers1, cp.nik_peers2, p2.id as id_peers2, cp.nik_peers3, p3.id as id_peers3, 
s1.id as id_sub1, cp.nik_sub1, s2.id as id_sub2, cp.nik_sub2, s3.id as id_sub3, cp.nik_sub3 
FROM cek_peers as cp
left join karyawan_2023 as k1 on k1.NIK=cp.nik
left join karyawan_2023 as p1 on p1.NIK=cp.nik_peers1
left join karyawan_2023 as p2 on p2.NIK=cp.nik_peers2
left join karyawan_2023 as p3 on p3.NIK=cp.nik_peers3
left join karyawan_2023 as s1 on s1.NIK=cp.nik_sub1
left join karyawan_2023 as s2 on s2.NIK=cp.nik_sub2
left join karyawan_2023 as s3 on s3.NIK=cp.nik_sub3";

$stmt1 = $koneksi->prepare($sql);
$stmt1->execute();
$no=1;
$p1="";
$p2="";
$p3="";
$sub1="";
$sub2="";
$sub3="";
$datetime	= Date('Y-m-d H:i:s');

echo "<table border=1>";
echo "
	<tr>
		<td>No</td>
		<td>Nama</td>
		<td>Peers 1</td>
		<td>Peers 2</td>
		<td>Peers 3</td>
		<td>Sub 1</td>
		<td>Sub 2</td>
		<td>Sub 3</td>
	</tr>
	";
while($sceksql = $stmt1->fetch(PDO::FETCH_ASSOC)){

$p1="";
$p2="";
$p3="";
$sub1="";
$sub2="";
$sub3="";

$cek_fortable = "SELECT k.id, if(dg.fortable='staff',if(COUNT(aa.idkar)>0,'staffb','staff'),dg.fortable) as fortable FROM karyawan_2023 as k 
left join daftargolongan as dg on dg.Kode_Golongan=k.Kode_Golongan
left join atasan as aa on aa.id_atasan=k.id
where k.id='$sceksql[idkar]'";
$stmt_fortable = $koneksi->prepare($cek_fortable);
$scek_fortable =  $stmt_fortable->execute();
$scek_fortable = $stmt_fortable->fetch(PDO::FETCH_ASSOC);
	
	if($sceksql['nik_peers1']<>''){
		
		$input_p1 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','p1','$sceksql[id_peers1]','Pending')";
		$stmt = $koneksi->prepare($input_p1);
		$sinput_p1 =  $stmt->execute();
		
		if($sinput_p1){$p1="ok";}else{$p1="gagal";}
	}
	if($sceksql['nik_peers2']<>''){
		
		$input_p2 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','p2','$sceksql[id_peers2]','Pending')";
		$stmt = $koneksi->prepare($input_p2);
		$sinput_p2 =  $stmt->execute();
		
		if($sinput_p2){$p2="ok";}else{$p2="gagal";}
	}
	if($sceksql['nik_peers3']<>''){
		
		$input_p3 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','p3','$sceksql[id_peers3]','Pending')";
		$stmt = $koneksi->prepare($input_p3);
		$sinput_p3 =  $stmt->execute();
		
		if($sinput_p3){$p3="ok";}else{$p3="gagal";}
	}
	if($sceksql['nik_sub1']<>''){
		
		$input_sub1 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','sub1','$sceksql[id_sub1]','Pending')";
		$stmt = $koneksi->prepare($input_sub1);
		$sinput_sub1 =  $stmt->execute();
		
		if($sinput_sub1){$sub1="ok";}else{$sub1="gagal";}
	}
	if($sceksql['nik_sub2']<>''){
		
		$input_sub2 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','sub2','$sceksql[id_sub2]','Pending')";
		$stmt = $koneksi->prepare($input_sub2);
		$sinput_sub2 =  $stmt->execute();
		
		if($sinput_sub2){$sub2="ok";}else{$sub2="gagal";}
	}
	if($sceksql['nik_sub3']<>''){
		
		$input_sub3 = "INSERT INTO transaksi_2023 (idkar,fortable,value_1,score_1,created_by,created_date,periode,layer,approver_id,approval_status) VALUES ('$sceksql[idkar]','$scek_fortable[fortable]','0','0','1','$datetime','2023','sub3','$sceksql[id_sub3]','Pending')";
		$stmt = $koneksi->prepare($input_sub3);
		$sinput_sub3 =  $stmt->execute();
		
		if($sinput_sub3){$sub3="ok";}else{$sub3="gagal";}
	}
	
	echo "
	<tr>
		<td>$no</td>
		<td>$sceksql[Nama_Lengkap]</td>
		<td>$p1</td>
		<td>$p2</td>
		<td>$p3</td>
		<td>$sub1</td>
		<td>$sub2</td>
		<td>$sub3</td>
	</tr>
	";
	
	$no++;
}
echo "</table>";
?>