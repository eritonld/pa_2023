<?php
//include("../conf/conf.php");

function convertRating($value) {
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
?>