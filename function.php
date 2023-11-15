<?php
//include("../conf/conf.php");

function convertRating($value) {
	$roundedValue = floor($value);
	$total_rating = $roundedValue == 0 ? "" : ($roundedValue == 1 ? "E" : ($roundedValue == 2 ? "D" : ($roundedValue == 3 ? "C" : ($roundedValue == 4 ? "B" : "A"))));
	return $total_rating;
}

function convertCulture($value) {
	if ($value >= 4.50) {
		$roundedValue = ceil($value);
	} elseif ($value >= 3.50) {
		$roundedValue = 4;
	} elseif ($value >= 2.50) {
		$roundedValue = 3;
	} elseif ($value >= 1.50) {
		$roundedValue = 2;
	} else {
		$roundedValue = floor($value);
	}
	$total_rating = $roundedValue == 0 ? "" : ($roundedValue == 1 ? "Basic" : ($roundedValue == 2 ? "Comprehension" : ($roundedValue == 3 ? "Practitioner" : ($roundedValue == 4 ? "Advanced" : "Expert"))));
	return $total_rating;
}

function promotion($value) {

	$result = $value === "Y" ? "Yes" : "No" ;

	return $result;
}

function getGrade($nilai)
{
	include("conf/conf.php");
	$tahun=date('Y');
	
	$sql = "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' and kesimpulan='primary' order by id asc";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();
	$ak=0;
	while($ccekkriteria = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$rngs[$ak]=$ccekkriteria['ranges'];
		$g[$ak]=$ccekkriteria['grade'];
		$ak++;
	}
	$gradenya="E";
	$warna="000000";
	for($aa=0;$aa<$ak;$aa++)
	{		
		if($nilai >= $rngs[$aa])
		{
			$gradenya=$g[$aa];
			break;
		}		
	}
	return $gradenya;
}

function srating($idkar){
    include("conf/conf.php");
    include("tabel_setting.php");
    
	try {
        
		$cek_self = "SELECT idkar, t.fortable, score_1, score_2, score_3, score_4, score_5, if(score_5>0,5,if(score_4>0,4,if(score_3>0,3,if(score_2>0,2,if(score_1>0,1,0))))) as score_aktif, (score_1+score_2+score_3+score_4+score_5) as total_s, ROUND((score_1+score_2+score_3+score_4+score_5)/(if(score_5>0,5,if(score_4>0,4,if(score_3>0,3,if(score_2>0,2,if(score_1>0,1,0)))))),2)  as avg_self, bb.self, bb.culture, bb.leadership FROM `transaksi_2023_final` as t 
		left join bobot as bb on bb.fortable=t.fortable
		where idkar='$idkar'";
		
		$conn_self = $koneksi->prepare($cek_self);
		$conn_self->execute();
		$scek_self = $conn_self->fetch(PDO::FETCH_ASSOC);
		
		$cek_culture = "SELECT idkar, fortable, 
		AVG(synergized1) as synergized1, 
		AVG(synergized2) as synergized2, 
		AVG(synergized3) as synergized3,
		AVG(integrity1) as integrity1,
		AVG(integrity2) as integrity2,
		AVG(integrity3) as integrity3,
		AVG(growth1) as growth1,
		AVG(growth2) as growth2,
		AVG(growth3) as growth3,
		AVG(adaptive1) as adaptive1,
		AVG(adaptive2) as adaptive2,
		AVG(adaptive3) as adaptive3,
		AVG(passion1) as passion1,
		AVG(passion2) as passion2,
		AVG(passion3) as passion3,
		AVG(leadership1) as leadership1,
		AVG(leadership2) as leadership2,
		AVG(leadership3) as leadership3,
		AVG(leadership4) as leadership4,
		AVG(leadership5) as leadership5,
		AVG(leadership6) as leadership6,
		round((AVG(synergized1)+AVG(synergized2)+AVG(synergized3)+AVG(integrity1)+AVG(integrity2)+AVG(integrity3)+AVG(growth1)+AVG(growth2)+AVG(growth3)+AVG(adaptive1)+AVG(adaptive2)+AVG(adaptive3)+AVG(passion1)+AVG(passion2)+AVG(passion3))/15,3) as avg_culture,
		round((AVG(leadership1)+AVG(leadership2)+AVG(leadership3)+AVG(leadership4)+AVG(leadership5)+AVG(leadership6))/6,3) as avg_leadership
		FROM `transaksi_2023` 
		where idkar='$idkar' and synergized1 is not null ORDER BY layer asc;";
		
		$conn_culture = $koneksi->prepare($cek_culture);
		$conn_culture->execute();
		$scek_culture = $conn_culture->fetch(PDO::FETCH_ASSOC);
		
		// $scek_self self culture leadership
		$spersen_self = round(($scek_self['avg_self']*$scek_self['self'])/100,2);
		$spersen_culture = round(($scek_culture['avg_culture']*$scek_self['culture'])/100,2);
		$spersen_leadership = round(($scek_culture['avg_leadership']*$scek_self['leadership'])/100,2);
		$spersen_total = $spersen_self+$spersen_culture+$spersen_leadership;
		
		// $total_score = "$scek_self[avg_self]||$scek_culture[avg_culture]||$scek_culture[avg_leadership]||$spersen_self||$spersen_culture||$spersen_leadership||$spersen_total||getGrade($spersen_total)";

		$total_score = getGrade($spersen_total);

		return  $total_score;
    } catch (Exception $e) {
        // Log or handle the exception
        error_log("Error in srating function: " . $e->getMessage());
        return "Error"; // or return a default value
    }
}

?>