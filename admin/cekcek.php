<?php
include("../conf/conf.php");

$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan, k.Kode_Golongan  FROM atasan_backup_2023 as ab 
left join karyawan_2023 as k on k.id=ab.idkar
left join karyawan_2023 as kk on kk.id=ab.id_atasan1
left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
where ab.idkar in ('21048')";

$stmt = $koneksi->prepare($sql);
$stmt->execute();
echo "<table border=1>";
$layer=array(1=>"L1","L2","L3","L4","L5","L6","L7","L8","L9","L10","L11","L12","L13","L14","L15");
while($sceksql = $stmt->fetch(PDO::FETCH_ASSOC)){
	$no_layer = 1;
	$id_atasan="";
	
	// if($sceksql['Kode_Golongan']>'GL021'){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$sceksql[id_atasan1]</td>
			<td>$sceksql[nama_atasan]</td>
			<td>$sceksql[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	// }
	$id_atasan="$sceksql[id_atasan1]";
	
	//cek layer 1
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan, k.Kode_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_1 = $koneksi->prepare($sql);
	$stmt_1->execute();
	
	$status_1 = $stmt_1->rowCount();
	$scek_1 = $stmt_1->fetch(PDO::FETCH_ASSOC);
	
	if($status_1>0 && $id_atasan<>$scek_1['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_1[id_atasan1]</td>
			<td>$scek_1[nama_atasan]</td>
			<td>$scek_1[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_1[id_atasan1]";
	if($id_atasan=="" || $id_atasan==null){echo "======================================================================= $sceksql[idkar]";}
	
	//cek layer 2
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan, k.Kode_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_2 = $koneksi->prepare($sql);
	$stmt_2->execute();
	
	$status_2 = $stmt_2->rowCount();
	$scek_2 = $stmt_2->fetch(PDO::FETCH_ASSOC);
	
	if($status_2>0 && $id_atasan<>$scek_2['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_2[id_atasan1]</td>
			<td>$scek_2[nama_atasan]</td>
			<td>$scek_2[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_2[id_atasan1]";
	
	//cek layer 3
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan, k.Kode_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_3 = $koneksi->prepare($sql);
	$stmt_3->execute();
	
	$status_3 = $stmt_3->rowCount();
	$scek_3 = $stmt_3->fetch(PDO::FETCH_ASSOC);
	
	if($status_3>0 && $id_atasan<>$scek_3['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_3[id_atasan1]</td>
			<td>$scek_3[nama_atasan]</td>
			<td>$scek_3[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_3[id_atasan1]";
	
	//cek layer 4
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_4 = $koneksi->prepare($sql);
	$stmt_4->execute();
	
	$status_4 = $stmt_4->rowCount();
	$scek_4 = $stmt_4->fetch(PDO::FETCH_ASSOC);
	
	if($status_4>0 && $id_atasan<>$scek_4['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_4[id_atasan1]</td>
			<td>$scek_4[nama_atasan]</td>
			<td>$scek_4[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_4[id_atasan1]";
	
	//cek layer 5
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_5 = $koneksi->prepare($sql);
	$stmt_5->execute();
	
	$status_5 = $stmt_5->rowCount();
	$scek_5 = $stmt_5->fetch(PDO::FETCH_ASSOC);
	
	if($status_5>0 && $id_atasan<>$scek_5['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_5[id_atasan1]</td>
			<td>$scek_5[nama_atasan]</td>
			<td>$scek_5[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_5[id_atasan1]";
	
	//cek layer 6
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_6 = $koneksi->prepare($sql);
	$stmt_6->execute();
	
	$status_6 = $stmt_6->rowCount();
	$scek_6 = $stmt_6->fetch(PDO::FETCH_ASSOC);
	
	if($status_6>0 && $id_atasan<>$scek_6['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_6[id_atasan1]</td>
			<td>$scek_6[nama_atasan]</td>
			<td>$scek_6[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_6[id_atasan1]";
	
	//cek layer 7
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_7 = $koneksi->prepare($sql);
	$stmt_7->execute();
	
	$status_7 = $stmt_7->rowCount();
	$scek_7 = $stmt_7->fetch(PDO::FETCH_ASSOC);
	
	if($status_7>0 && $id_atasan<>$scek_7['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_7[id_atasan1]</td>
			<td>$scek_7[nama_atasan]</td>
			<td>$scek_7[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_7[id_atasan1]";
	
	//cek layer 8
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_8 = $koneksi->prepare($sql);
	$stmt_8->execute();
	
	$status_8 = $stmt_8->rowCount();
	$scek_8 = $stmt_8->fetch(PDO::FETCH_ASSOC);
	
	if($status_8>0 && $id_atasan<>$scek_8['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_8[id_atasan1]</td>
			<td>$scek_8[nama_atasan]</td>
			<td>$scek_8[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_8[id_atasan1]";
	
	//cek layer 9
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_9 = $koneksi->prepare($sql);
	$stmt_9->execute();
	
	$status_9 = $stmt_9->rowCount();
	$scek_9 = $stmt_9->fetch(PDO::FETCH_ASSOC);
	
	if($status_9>0 && $id_atasan<>$scek_9['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_9[id_atasan1]</td>
			<td>$scek_9[nama_atasan]</td>
			<td>$scek_9[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_9[id_atasan1]";
	
	//cek layer 10
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_10 = $koneksi->prepare($sql);
	$stmt_10->execute();
	
	$status_10 = $stmt_10->rowCount();
	$scek_10 = $stmt_10->fetch(PDO::FETCH_ASSOC);
	
	if($status_10>0 && $id_atasan<>$scek_10['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_10[id_atasan1]</td>
			<td>$scek_10[nama_atasan]</td>
			<td>$scek_10[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_10[id_atasan1]";
	
	//cek layer 11
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_11 = $koneksi->prepare($sql);
	$stmt_11->execute();
	
	$status_11 = $stmt_11->rowCount();
	$scek_11 = $stmt_11->fetch(PDO::FETCH_ASSOC);
	
	if($status_11>0 && $id_atasan<>$scek_11['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_11[id_atasan1]</td>
			<td>$scek_11[nama_atasan]</td>
			<td>$scek_11[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_11[id_atasan1]";
	
	//cek layer 12
	$sql = "SELECT ab.idkar, k.Nama_Lengkap as nama, ab.id_atasan1, kk.Nama_Lengkap as nama_atasan, dg.Nama_Golongan  FROM atasan_backup_2023 as ab 
	left join karyawan_2023 as k on k.id=ab.idkar
	left join karyawan_2023 as kk on kk.id=ab.id_atasan1
	left join daftargolongan as dg on dg.Kode_Golongan=kk.Kode_Golongan
	where ab.idkar in ('$id_atasan')";

	$stmt_12 = $koneksi->prepare($sql);
	$stmt_12->execute();
	
	$status_12 = $stmt_12->rowCount();
	$scek_12 = $stmt_12->fetch(PDO::FETCH_ASSOC);
	
	if($status_12>0 && $id_atasan<>$scek_12['id_atasan1']){
		echo "
		<tr>
			<td>$sceksql[idkar]</td>
			<td>$sceksql[nama]</td>
			<td>L$no_layer</td>
			<td>$scek_12[id_atasan1]</td>
			<td>$scek_12[nama_atasan]</td>
			<td>$scek_12[Nama_Golongan]</td>
		<tr>
		";
		$no_layer++;
	}
	$id_atasan="$scek_12[id_atasan1]";
}
echo "</table>";
?>