<?php
include("../conf/conf.php");

$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_paevaluator, kpa.id as id_pa, kpa.Nama_Lengkap as nama_pa, k.nik_calibrator, kca.id as id_ca, kca.Nama_Lengkap as nama_ca
FROM `karyawan_2023` as k 
left join karyawan_2023 as kpa on kpa.NIK=k.nik_paevaluator
left join karyawan_2023 as kca on kca.NIK=k.nik_calibrator
where k.pltinds='Property'";

$stmt = $koneksi->prepare($sql);
$stmt->execute();
echo "<table border=1>";
while($sceksql = $stmt->fetch(PDO::FETCH_ASSOC)){
	$no_layer = 2;
	$id_atasan="";
	
	echo "
	<tr>
		<td>$sceksql[id]</td>
		<td>$sceksql[Nama_Lengkap]</td>
		<td>L1</td>
		<td>$sceksql[id_pa]</td>
		<td>$sceksql[nama_pa]</td>
	</tr>
	";
	
	if($sceksql['id_pa']<>$sceksql['id_ca']){
		echo "
		<tr>
			<td>$sceksql[id]</td>
			<td>$sceksql[Nama_Lengkap]</td>
			<td>L$no_layer</td>
			<td>$sceksql[id_ca]</td>
			<td>$sceksql[nama_ca]</td>
		</tr>
		";
		$no_layer++;
	}
	
	
	
	//cek layer 3
	$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
	FROM `karyawan_2023` as k
	left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
	where k.id='$sceksql[id_ca]'";

	$stmt_1 = $koneksi->prepare($sql);
	$stmt_1->execute();
	
	$status_1 = $stmt_1->rowCount();
	$scek_1 = $stmt_1->fetch(PDO::FETCH_ASSOC);
	
	if($status_1>0 && $scek_1['nik_atasan']<>0){
		echo "
		<tr>
			<td>$sceksql[id]</td>
			<td>$sceksql[Nama_Lengkap]</td>
			<td>L$no_layer</td>
			<td>$scek_1[id_atasan]</td>
			<td>$scek_1[nama_atasan]</td>
		</tr>
		";
		$no_layer++;
		
		//cek layer 4
		$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
		FROM `karyawan_2023` as k
		left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
		where k.id='$scek_1[id_atasan]'";

		$stmt_2 = $koneksi->prepare($sql);
		$stmt_2->execute();
		
		$status_2 = $stmt_2->rowCount();
		$scek_2 = $stmt_2->fetch(PDO::FETCH_ASSOC);
		
		if($status_2>0 && $scek_2['nik_atasan']<>0){
			echo "
			<tr>
				<td>$sceksql[id]</td>
				<td>$sceksql[Nama_Lengkap]</td>
				<td>L$no_layer</td>
				<td>$scek_2[id_atasan]</td>
				<td>$scek_2[nama_atasan]</td>
			</tr>
			";
			$no_layer++;
			
			//cek layer 5
			$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
			FROM `karyawan_2023` as k
			left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
			where k.id='$scek_2[id_atasan]'";

			$stmt_3 = $koneksi->prepare($sql);
			$stmt_3->execute();
			
			$status_3 = $stmt_3->rowCount();
			$scek_3 = $stmt_3->fetch(PDO::FETCH_ASSOC);
			
			if($status_3>0 && $scek_3['nik_atasan']<>0){
				echo "
				<tr>
					<td>$sceksql[id]</td>
					<td>$sceksql[Nama_Lengkap]</td>
					<td>L$no_layer</td>
					<td>$scek_3[id_atasan]</td>
					<td>$scek_3[nama_atasan]</td>
				</tr>
				";
				$no_layer++;
				
				//cek layer 6
				$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
				FROM `karyawan_2023` as k
				left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
				where k.id='$scek_3[id_atasan]'";

				$stmt_4 = $koneksi->prepare($sql);
				$stmt_4->execute();
				
				$status_4 = $stmt_4->rowCount();
				$scek_4 = $stmt_4->fetch(PDO::FETCH_ASSOC);
				
				if($status_4>0 && $scek_4['nik_atasan']<>0){
					echo "
					<tr>
						<td>$sceksql[id]</td>
						<td>$sceksql[Nama_Lengkap]</td>
						<td>L$no_layer</td>
						<td>$scek_4[id_atasan]</td>
						<td>$scek_4[nama_atasan]</td>
					</tr>
					";
					$no_layer++;
					
					//cek layer 7
					$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
					FROM `karyawan_2023` as k
					left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
					where k.id='$scek_4[id_atasan]'";

					$stmt_5 = $koneksi->prepare($sql);
					$stmt_5->execute();
					
					$status_5 = $stmt_5->rowCount();
					$scek_5 = $stmt_5->fetch(PDO::FETCH_ASSOC);
					
					if($status_5>0 && $scek_5['nik_atasan']<>0){
						echo "
						<tr>
							<td>$sceksql[id]</td>
							<td>$sceksql[Nama_Lengkap]</td>
							<td>L$no_layer</td>
							<td>$scek_5[id_atasan]</td>
							<td>$scek_5[nama_atasan]</td>
						</tr>
						";
						$no_layer++;
						
						//cek layer 8
						$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
						FROM `karyawan_2023` as k
						left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
						where k.id='$scek_5[id_atasan]'";

						$stmt_6 = $koneksi->prepare($sql);
						$stmt_6->execute();
						
						$status_6 = $stmt_6->rowCount();
						$scek_6 = $stmt_6->fetch(PDO::FETCH_ASSOC);
						
						if($status_6>0 && $scek_6['nik_atasan']<>0){
							echo "
							<tr>
								<td>$sceksql[id]</td>
								<td>$sceksql[Nama_Lengkap]</td>
								<td>L$no_layer</td>
								<td>$scek_6[id_atasan]</td>
								<td>$scek_6[nama_atasan]</td>
							</tr>
							";
							$no_layer++;
							
							//cek layer 9
							$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
							FROM `karyawan_2023` as k
							left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
							where k.id='$scek_6[id_atasan]'";

							$stmt_7 = $koneksi->prepare($sql);
							$stmt_7->execute();
							
							$status_7 = $stmt_7->rowCount();
							$scek_7 = $stmt_7->fetch(PDO::FETCH_ASSOC);
							
							if($status_7>0 && $scek_7['nik_atasan']<>0){
								echo "
								<tr>
									<td>$sceksql[id]</td>
									<td>$sceksql[Nama_Lengkap]</td>
									<td>L$no_layer</td>
									<td>$scek_7[id_atasan]</td>
									<td>$scek_7[nama_atasan]</td>
								</tr>
								";
								$no_layer++;
								
								//cek layer 9
								$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
								FROM `karyawan_2023` as k
								left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
								where k.id='$scek_7[id_atasan]'";

								$stmt_8 = $koneksi->prepare($sql);
								$stmt_8->execute();
								
								$status_8 = $stmt_8->rowCount();
								$scek_8 = $stmt_8->fetch(PDO::FETCH_ASSOC);
								
								if($status_8>0 && $scek_8['nik_atasan']<>0){
									echo "
									<tr>
										<td>$sceksql[id]</td>
										<td>$sceksql[Nama_Lengkap]</td>
										<td>L$no_layer</td>
										<td>$scek_8[id_atasan]</td>
										<td>$scek_8[nama_atasan]</td>
									</tr>
									";
									$no_layer++;
									
									//cek layer 10
									$sql = "SELECT k.id, k.NIK, k.Nama_Lengkap, k.nik_atasan, kat.id as id_atasan, kat.Nama_Lengkap as nama_atasan
									FROM `karyawan_2023` as k
									left join karyawan_2023 as kat on kat.NIK=k.nik_atasan
									where k.id='$scek_8[id_atasan]'";

									$stmt_9 = $koneksi->prepare($sql);
									$stmt_9->execute();
									
									$status_9 = $stmt_9->rowCount();
									$scek_9 = $stmt_9->fetch(PDO::FETCH_ASSOC);
									
									if($status_9>0 && $scek_9['nik_atasan']<>0){
										echo "
										<tr>
											<td>$sceksql[id]</td>
											<td>$sceksql[Nama_Lengkap]</td>
											<td>L$no_layer</td>
											<td>$scek_9[id_atasan]</td>
											<td>$scek_9[nama_atasan]</td>
										</tr>
										";
										$no_layer++;
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
echo "</table>";
?>