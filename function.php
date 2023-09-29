<?php
//include("../conf/conf.php");

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
function IntervalDays($CheckIn,$CheckOut){
	$CheckInX = explode("-", $CheckIn);
	$CheckOutX =  explode("-", $CheckOut);
	$date1 =  mktime(0, 0, 0, $CheckInX[1],$CheckInX[2],$CheckInX[0]);
	$date2 =  mktime(0, 0, 0, $CheckOutX[1],$CheckOutX[2],$CheckOutX[0]);
	$interval =($date2 - $date1)/(3600*24);
	// returns numberofdays
	return  $interval ;
}
function TotalJamKerja($clock_in,$clock_out,$dateattd){
	if($clock_in<>"" && $clock_out<>""){
		$pecahout = explode(":", $clock_out);
		if($pecahout[0]=='00' || $pecahout[0]=='01' || $pecahout[0]=='02' || $pecahout[0]=='03'){
			$dateout=Date('Y-m-d', strtotime('+1 days', strtotime($dateattd)));
		}else{
			$dateout=$dateattd;
		}
		
		$masuk="$dateattd $clock_in:00";
		$keluar="$dateout $clock_out:00";

		$awal  = date_create($masuk);
		$akhir = date_create($keluar);
		$diff  = date_diff( $awal, $akhir );
		$jam   = $diff->h;
		$menit   = $diff->i;
		
		$hitungjam=strlen($jam);
		if($hitungjam==1){$jam="0".$jam;}
		$hitungmenit=strlen($menit);
		if($hitungmenit==1){$menit="0".$menit;}
		
		$totaljam="$jam:$menit";
		
		return  $totaljam ;
	}
}
function hari_indo(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_indo = "Minggu";
		break;
 
		case 'Mon':			
			$hari_indo = "Senin";
		break;
 
		case 'Tue':
			$hari_indo = "Selasa";
		break;
 
		case 'Wed':
			$hari_indo = "Rabu";
		break;
 
		case 'Thu':
			$hari_indo = "Kamis";
		break;
 
		case 'Fri':
			$hari_indo = "Jumat";
		break;
 
		case 'Sat':
			$hari_indo = "Sabtu";
		break;
		
		default:
			$hari_indo = "Tidak di ketahui";		
		break;
	}
 
	return "<b>" . $hari_indo . "</b>";
 
}
function PersenData($NIK){
	$jmlisi = 0;
	$kosong = "";
	$cekkar=mysqli_query($koneksi,"SELECT k.*, dp.Nama_Departemen, dps.Nama_Sub_Departemen, dsk.Nama_StatusKerja, dj.Nama_Jabatan, dg.Nama_Golongan, p.Nama_Lkp_Perusahaan, d.Nama_OU, k.Email, k.no_rek  FROM `karyawan` as k
	left join daftardepartemen as dp on dp.kode_departemen=k.Kode_Departemen
	left join daftardepartemensub as dps on dps.Kode_Sub_Departemen=k.Kode_Sub_Departemen
	left join daftarstatuskerja as dsk on dsk.Kode_StatusKerja=k.Kode_StatusKerja
	left join daftarjabatan as dj on dj.Kode_Jabatan=k.Kode_Jabatan
	left join daftargolongan as dg on dg.Kode_Golongan=k.Kode_Golongan
	left join daftarperusahaan as p on p.Kode_Perusahaan=k.Kode_Perusahaan
	left join daftarou as d on d.Kode_OU=k.Kode_OU where k.Kode_StatusKerja<>'SKH05' and k.NIK='$NIK'"); 
	$scekkar=mysqli_fetch_array($cekkar); 
	
	//hitung kelengkapan data
	if($scekkar['Nama_Lengkap']<>''){$jmlisi++;}else{$kosong=$kosong."Nama Lengkap, ";}
	if($scekkar['Kode_Departemen']<>''){$jmlisi++;}else{$kosong=$kosong."Divisi, ";}
	if($scekkar['Kode_Sub_Departemen']<>''){$jmlisi++;}else{$kosong=$kosong."Departemen, ";}
	if($scekkar['tempat_lahir']<>''){$jmlisi++;}else{$kosong=$kosong."Tempat Lahir, ";}
	if($scekkar['Tgl_Lahir']<>''){$jmlisi++;}else{$kosong=$kosong."Tanggal Lahir, ";}
	if($scekkar['jenis_kelamin']<>''){$jmlisi++;}else{$kosong=$kosong."Jenis Kelamin, ";}
	if($scekkar['Kode_Status']<>''){$jmlisi++;}else{$kosong=$kosong."Status Karyawan, ";}
	if($scekkar['Status_Pernikahan']<>''){$jmlisi++;}else{$kosong=$kosong."Status Pernikahan, ";}
	if($scekkar['no_ktp']<>''){$jmlisi++;}else{$kosong=$kosong."No KTP, ";}
	if($scekkar['no_npwp']<>''){$jmlisi++;}else{$kosong=$kosong."No NPWP, ";}
	if($scekkar['no_bpjs_kes']<>''){$jmlisi++;}else{$kosong=$kosong."No BPJS Kesehatan, ";}
	if($scekkar['no_bpjs_tk']<>''){$jmlisi++;}else{$kosong=$kosong."No BPJS TK, ";}
	if($scekkar['Email']<>''){$jmlisi++;}else{$kosong=$kosong."Email Kantor, ";}
	if($scekkar['Email_Pribadi']<>''){$jmlisi++;}else{$kosong=$kosong."Email Pribadi, ";}
	if($scekkar['alamat_sekarang']<>''){$jmlisi++;}else{$kosong=$kosong."Alamat Saat ini, ";}
	if($scekkar['kota']<>''){$jmlisi++;}else{$kosong=$kosong."Kota, ";}
	if($scekkar['provinsi']<>''){$jmlisi++;}else{$kosong=$kosong."Provinsi, ";}
	if($scekkar['alamat_ktp']<>''){$jmlisi++;}else{$kosong=$kosong."Alamat KTP, ";}
	if($scekkar['no_telp']<>''){$jmlisi++;}else{$kosong=$kosong."No Telp, ";}
	if($scekkar['ext']<>''){$jmlisi++;}else{$kosong=$kosong."No Extension Kantor, ";}
	if($scekkar['no_rek']<>''){$jmlisi++;}else{$kosong=$kosong."No Rekening, ";}
	if($scekkar['nama_bank']<>''){$jmlisi++;}else{$kosong=$kosong."Nama Rekening, ";}
	if($scekkar['suku']<>''){$jmlisi++;}else{$kosong=$kosong."Suku, ";}
	if($scekkar['kebangsaan']<>''){$jmlisi++;}else{$kosong=$kosong."Kebangsaan, ";}
	if($scekkar['pendidikan']<>''){$jmlisi++;}else{$kosong=$kosong."Pendidikan, ";}
	if($scekkar['tinggi']<>''){$jmlisi++;}else{$kosong=$kosong."Tinggi Badan, ";}
	if($scekkar['agama']<>''){$jmlisi++;}else{$kosong=$kosong."Agama, ";}
	if($scekkar['gol_darah']<>''){$jmlisi++;}else{$kosong=$kosong."Golongan Darah, ";}
	if($scekkar['penyakit_penyerta']<>''){$jmlisi++;}else{$kosong=$kosong."Penyakit Penyerta, ";}
	if($scekkar['status_vaksin_covid']<>''){$jmlisi++;}else{$kosong=$kosong."Status Vaksin Covid, ";}
	if($scekkar['status_covid']<>''){$jmlisi++;}else{$kosong=$kosong."Data Positif Covid, ";}
	
	$pengalikeluarga=0;
	if($scekkar['Kode_Status']=='TK/0'){$pengalikeluarga=0;}
	else if($scekkar['Kode_Status']=='K/0'){$pengalikeluarga=1;}
	else if($scekkar['Kode_Status']=='K/1'){$pengalikeluarga=2;}
	else if($scekkar['Kode_Status']=='K/2'){$pengalikeluarga=3;}
	else if($scekkar['Kode_Status']=='K/3'){$pengalikeluarga=4;}
	
	$actualfamily=0;
	$cekkarfamily=mysqli_query($koneksi,"SELECT * FROM `kary_family` where id_kar='$scekkar[id]'");
	$ncekkarfamily=mysqli_num_rows($cekkarfamily);
	$actualfamily=$ncekkarfamily*7;
	
	if($ncekkarfamily>=$pengalikeluarga){$actualfamily=$pengalikeluarga*7;}
	else if($ncekkarfamily<$pengalikeluarga){$kosong=$kosong."Data Keluarga, ";}
	
	$actualformal=0;
	$cekedcformal=mysqli_query($koneksi,"SELECT * FROM `kary_edc_formal` where id_kar='$scekkar[id]'");
	$ncekedcformal=mysqli_num_rows($cekedcformal);
	if($ncekedcformal>0){$actualformal=8;}else{$kosong=$kosong."Data Pendidikan, ";}
	
	$actualdokumen=0;
	$cekdokumen=mysqli_query($koneksi,"SELECT * FROM `kary_dokumen` where id_kar='$scekkar[id]'");
	$ncekdokumen=mysqli_num_rows($cekdokumen);
	if($ncekdokumen>0){$actualdokumen=3;}else{$kosong=$kosong."Data Dokumen Minimal KTP, ";}
	
	$datadiri=31;
	$datakeluarga=7*$pengalikeluarga;
	$datapen=8;
	$datadokumen=3;
	
	$target=$datadiri+$datakeluarga+$datapen+$datadokumen;
	$actual=$jmlisi+$actualfamily+$actualformal+$actualdokumen;
	
	$spersen=(($actual/$target)*100);
	$hasil="$spersen|$kosong|$target|$actual";
	
	return  $hasil ;
}
function GenerateNewNIK($idkar){
	
	$cekarea=mysqli_query($koneksi,"SELECT k.id, d.area, k.Mulai_Bekerja FROM `karyawan` as k
	left join daftarou as d on d.Kode_OU=k.Kode_OU
	where id='$idkar'");
	$scekarea=mysqli_fetch_array($cekarea);

	$digittahun=date('y', strtotime($scekarea['Mulai_Bekerja']));
	$digitbulan=date('m', strtotime($scekarea['Mulai_Bekerja']));

	$kodenik=$scekarea['area']."1".$digittahun.$digitbulan;

	$cekurut=mysqli_query($koneksi,"SELECT nik_baru FROM `karyawan` where LEFT(nik_baru,7)='$kodenik' ORDER BY nik_baru desc limit 1");
	$scekurut=mysqli_fetch_array($cekurut);
	
	if($scekurut['nik_baru']<>''){
		$urutanakhir = substr($scekurut['nik_baru'],-4);
	}else{
		$urutanakhir = 0;
	}
	
	$urutan=$urutanakhir+1;
	$jmlchar=strlen($urutan);
	if($jmlchar==1){
		$urut="000".$urutan;
	}else if($jmlchar==2){
		$urut="00".$urutan;
	}else if($jmlchar==3){
		$urut="0".$urutan;
	}else if($jmlchar==4){
		$urut=$urutan;
	}else{
		$urut="xxxx";
	}

	$nikbaru=$kodenik.$urut;
	
	return  $nikbaru ;
}
?>