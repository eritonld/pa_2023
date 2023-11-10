<?php

if(isset($_COOKIE['bahasa'])){
	$bahasa=$_COOKIE['bahasa'];
}else{
	$bahasa='ind';
}

$tahunperiode='2023';
$karyawan="karyawan_".$tahunperiode;
$transaksi_pa="transaksi_".$tahunperiode;//asli
$transaksi_pa_awal="transaksi_".$tahunperiode."_awal";//awal
$transaksi_pa_edit1="transaksi_".$tahunperiode."_a1";//edit1
$transaksi_pa_edit2="transaksi_".$tahunperiode."_a2";//edit2
$transaksi_pa_edit2="transaksi_".$tahunperiode."_a3";//edit3
$transaksi_pa_edit2="transaksi_".$tahunperiode."_subo";//subo
$transaksi_pa_edit2="transaksi_".$tahunperiode."_peers";//peers
$transaksi_pa_final="transaksi_".$tahunperiode."_final";//peers
$tugas_managerial="tugas_managerial";
$quartal_periode=$tahunperiode;
$tabel_sp="sp_".$tahunperiode;
$karyawan_promosi = "karyawan_promosi_".$tahunperiode;
if($bahasa=='eng')
{
	$tabel_prosedure="prosedure_english";
	$a0='Employee Detail';
	$a1='Performance Appraisal';
	$a2='Employee Name';
	$a3='Company / Location';
	$a4='Employee ID';
	$a5='Division / Department';
	$a6='Designation';
	$a7='Section / SubSection';
	$a8='Join Date';
	$a9='Period of Assessment';
	$a10='Grade';
	$a11='SP/period';
	$a12='Rating';
	$a13='On Rating';
	$title_a='Work Results';
	$title_aa='Work Objectives';
	$add_btn_name='Objective';
	$title_comment='Comment';
	$comment_placeholder='input your comment';
	$title_rating='Give Rating :';
	$selectPeers='select peers';
	$title_promotion='Proposed for promotion :';
	$title_review_a1='Rating L1';
	$title_review_a2='Rating L2';
	$title_promotion='Is Promotion';
}
else
{	
	$tabel_prosedure="prosedure";
	$a0='Detail Karyawan';
	$a1='Penilaian Kinerja Karyawan';
	$a2='Nama Karyawan';
	$a3='Nama PT / Lokasi';
	$a4='NIK';
	$a5='Divisi / Departemen';
	$a6='Jabatan';
	$a7='Seksi / SubSeksi';
	$a8='TMK';
	$a9='Periode Penilaian';
	$a10='Golongan';
	$a11='SP/Periode';
	$a12='Bobot';
	$a13='Pembobotan';
	$title_a='Hasil Kerja';
	$title_aa='Objektif Kerja';
	$add_btn_name='Objektif';
	$title_comment='Komentar';
	$comment_placeholder='masukkan komentar anda';
	$title_rating='Berikan Rating :';
	$selectPeers='pilih peers';
	$title_promotion='Diusulkan untuk promosi :';
	$title_review_a1='Rating L1';
	$title_review_a2='Rating L2';
	$title_promotion='Promosi';
}
?>