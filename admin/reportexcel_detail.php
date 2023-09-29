<?php
set_time_limit(0);
require("../conf/conf.php");
include("../tabel_setting.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$objPHPExcel = new Spreadsheet();

session_start();
if(isset($_SESSION["idmaster_pa_admin"])){
	$idmaster_pa_admin=$_SESSION["idmaster_pa_admin"];
}else{
	$idmaster_pa_admin="";
}

$cekuser=mysqli_query($koneksi, "select * from user_pa_admin where id='$idmaster_pa_admin'");
$scekuser=mysqli_fetch_array($cekuser);

$bisnis	= $_GET['bisnis'];
$grade	= $_GET['grade'];
$dept	= $_GET['dept'];
$pt		= $_GET['pt'];
$unit	= $_GET['unit'];
$where	= "";

//data unit
if ($unit <> 'all'){
	$where=$where." and k.Kode_OU in $unit";
}else{
	$unit = $scekuser['ou'];
	$where=$where." and k.Kode_OU in $unit";
}

//data perusahaan
if ($pt <> 'all'){
	$where=$where." and k.Kode_Perusahaan in $pt";
}else{
	$pt = $scekuser['pt'];
	$where=$where." and k.Kode_Perusahaan in $pt";
}

//data dept
if ($dept <> 'all'){
	$where=$where." and k.Kode_Departemen in $dept";
}else{
	$dept = $scekuser['dept'];
	$where=$where." and k.Kode_Departemen in $dept";
}

//data grade
if ($grade <> 'all'){
	$where=$where." and k.Kode_Golongan in $grade";
}else{
	$grade = $scekuser['gol'];
	$where=$where." and k.Kode_Golongan in $grade";
}

//data bisnis
if ($bisnis <> 'all'){
	// $where=$where." and do.BU in $bisnis";
}else{
	$bisnis = $scekuser['bisnis'];
	// $where=$where." and do.BU in $bisnis";
}

function getGrade($nilai)
{
	include("../conf/conf.php");
	$tahun=date('Y');
	$cekkriteria=mysqli_query($koneksi, "select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria 
	where tahun='$tahun' order by id asc");
	$ak=0;
	while($ccekkriteria=mysqli_fetch_array($cekkriteria))
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

error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

// Create new PHPExcel object
//$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("HC System Development")
							 ->setLastModifiedBy("")
							 ->setTitle("Report Detail Performance Appraisal")
							 ->setSubject("Report Detail Performance Appraisal")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory('');

// Add some data
$p=0;
$cekfor=mysqli_query($koneksi, "SELECT fortable FROM `prosedure` GROUP BY fortable"); //echo "SELECT fortable FROM `prosedure` GROUP BY fortable ORDER BY id asc";
while($scekfor=mysqli_fetch_array($cekfor)){

if($scekfor['fortable']=='nonstaff'){
	$nama_sheet="Rekap Non Staff";
}else if($scekfor['fortable']=='staff'){
	$nama_sheet="Rekap Staff (Tanpa Bawahan)";
}else if($scekfor['fortable']=='staffb'){
	$nama_sheet="Rekap Staff (Dengan Bawahan)";
}else if($scekfor['fortable']=='managerial'){
	$nama_sheet="Rekap Managerial";
}

$objPHPExcel->createSheet($p);
$objPHPExcel->setActiveSheetIndex($p);
$objPHPExcel->getActiveSheet()->setTitle($nama_sheet);	

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Unicode MS');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

$objPHPExcel->getActiveSheet()->setShowGridlines(false);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(25);

//header HC
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(32);
$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');						  
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'KPN Corps');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);

//header PA
$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(22);
$objPHPExcel->getActiveSheet()->mergeCells('A2:I2');						  
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(13);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Performance Appraisal Recapitulation');

$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(32);

//header kolom No
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');
$objPHPExcel->getActiveSheet()->mergeCells('A4:A6');

//header kolom NIK
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'NIK');
$objPHPExcel->getActiveSheet()->mergeCells('B4:B6');

//header kolom Nama
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Nama');
$objPHPExcel->getActiveSheet()->mergeCells('C4:C6');

//header kolom jabatan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jabatan');
$objPHPExcel->getActiveSheet()->mergeCells('D4:D6');

//header kolom golongan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Golongan');
$objPHPExcel->getActiveSheet()->mergeCells('E4:E6');

//header kolom PT
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'PT');
$objPHPExcel->getActiveSheet()->mergeCells('F4:F6');

//header kolom unit
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Unit');
$objPHPExcel->getActiveSheet()->mergeCells('G4:G6');

//header kolom Departemen
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Departemen');
$objPHPExcel->getActiveSheet()->mergeCells('H4:H6');

$colomabjad=array(1=>"I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ");
$urutan=1;

$row_h=4;
$row_h1=5;
$row_h2=6;
$cekriteria=mysqli_query($koneksi, "SELECT komposisi_group, nama_group, jml_loop, bobot, mapping_cq FROM `prosedure` where fortable='$scekfor[fortable]'");
while($scekriteria=mysqli_fetch_array($cekriteria))
{
	
	$cell_h = $colomabjad[$urutan].$row_h;///POSISI AWAL
	$counter_merg=$urutan+($scekriteria['jml_loop']-1);	
	$cell_h1 = $colomabjad[$counter_merg].$row_h;//POSISI NEXT
	
	$objPHPExcel->getActiveSheet()->mergeCells($cell_h.':'.$cell_h1);		  
	$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, $scekriteria['nama_group']);
	$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true);
	
	$ii=1;
	for($i=$urutan;$i<=$counter_merg;$i++)
	{		
		$slc=$scekriteria['komposisi_group'].$ii;
		$master_soal=mysqli_query($koneksi, "select $slc,komentar from master_soal_$scekfor[fortable] where id='1'");
		$cmaster_soal=mysqli_fetch_array($master_soal);
		
		$data=explode('|',$cmaster_soal[$slc]);
		
		$bobot_data=mysqli_query($koneksi, "select $slc from master_soal_$scekfor[fortable] where id='2'");
		$cbobot=mysqli_fetch_array($bobot_data);
			
		$cell_h = $colomabjad[$i].$row_h1;///POSISI CETAK PER ASPEK BARIS 1
		$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, $data[0]);
		$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true);
		
		$cell_h = $colomabjad[$i].$row_h2;///POSISI CETAK PER ASPEK BARIS 2
		$objPHPExcel->getActiveSheet()->SetCellValue($cell_h,$cbobot[$slc].'%');
		
		$ii++;
	}		
	$urutan=$counter_merg+1;
}

$cell_h = $colomabjad[$urutan].$row_h;///POSISI AWAL
$cell_h2 = $colomabjad[$urutan].$row_h2;//POSISI NEXT

//header kolom Total Nilai					  
$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, 'Total Nilai');
$objPHPExcel->getActiveSheet()->mergeCells($cell_h.':'.$cell_h2);

$urutan=$urutan+1;
$cell_h = $colomabjad[$urutan].$row_h;///POSISI AWAL
$cell_h2 = $colomabjad[$urutan].$row_h2;//POSISI NEXT

//header kolom Total Nilai					  
$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, 'Nilai Mutu');
$objPHPExcel->getActiveSheet()->mergeCells($cell_h.':'.$cell_h2);

$urutan=$urutan+1;
$cell_h = $colomabjad[$urutan].$row_h;///POSISI AWAL
$cell_h2 = $colomabjad[$urutan].$row_h2;//POSISI NEXT

//header kolom KOMENTAR					 
$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true); 
$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, 'Komentar');
$objPHPExcel->getActiveSheet()->mergeCells($cell_h.':'.$cell_h2);

$urutan=$urutan+1;
$cell_h = $colomabjad[$urutan].$row_h;///POSISI AWAL
$cell_h2 = $colomabjad[$urutan].$row_h2;//POSISI NEXT

//header kolom SP					  
$objPHPExcel->getActiveSheet()->getStyle($cell_h)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue($cell_h, 'SP');
$objPHPExcel->getActiveSheet()->mergeCells($cell_h.':'.$cell_h2);

$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:'.$cell_h2)->getBorders()->getInside()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$yearnow	= Date('Y');
$cutoff		= $yearnow."-07-01";
$q_data = mysqli_query ($koneksi, "select tp.A1,tp.A2,tp.A3,tp.A4,tp.A5,tp.A6,tp.A7,tp.B1,tp.B2,tp.B3,tp.B4,tp.B5,tp.B6,tp.C1,tp.C2,tp.C3,tp.C4,tp.C5,tp.C6,tp.C7,
tp.D1,tp.edit_by, tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen, dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU, tp.komentar,tp.total,tpa.total as totalawal,tpa1.total as total1,tpa2.total as total2,
(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.input_by))as inputby,
(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by))as editby,
(Select Nama_Lengkap from $karyawan where nik = (select username from user_pa where id = tp.edit_by2))as editby2,
(Select Nama_Lengkap from $karyawan where nik = (select nik_atasan1 from atasan where nik = k.nik))as atasan1,
(Select Nama_Lengkap from $karyawan where nik = (select nik_atasan2 from atasan where nik = k.nik))as atasan2,
tp.date_edit, tp.date_edit2
from $karyawan as k 
left join daftarou as do on k.Kode_OU = do.Kode_OU 
left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan 
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan 
left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan 
left join $transaksi_pa as tp on k.NIK = tp.NIK 
left join $transaksi_pa_awal as tpa on k.NIK = tpa.NIK
left join $transaksi_pa_edit1 as tpa1 on k.NIK = tpa1.NIK
left join $transaksi_pa_edit2 as tpa2 on k.NIK = tpa2.NIK
where k.Kode_StatusKerja<>'SKH05' $where and tp.fortable='$scekfor[fortable]' and tp.input_by <>'' order by k.kode_ou asc, k.Nama_Lengkap ASC");


$no 	= 1;
$row 	= 7;
while ($r_data = mysqli_fetch_array ($q_data))
{
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
	$cell = 'A'.$row;	
	
	$nik="'$r_data[NIK]";
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $nik);
	$cell = 'B'.$row;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $r_data['Nama_Lengkap']);
	$cell = 'C'.$row;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $r_data['Nama_Jabatan']);
	$cell = 'D'.$row;	
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $r_data['Nama_Golongan']);
	$cell = 'E'.$row;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $r_data['Nama_Perusahaan']);
	$cell = 'F'.$row;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $r_data['Nama_OU']);
	$cell = 'G'.$row;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $r_data['Nama_Departemen']);
	$cell = 'H'.$row;
	
	$sum="";
	$perform="";
	$poten="";
	$huruf=1;
	$angka=9;
	$cekriteria=mysqli_query($koneksi, "SELECT komposisi_group, nama_group, jml_loop, bobot, mapping_cq FROM `prosedure` where fortable='$scekfor[fortable]'");
	while($scekriteria=mysqli_fetch_array($cekriteria))
	{
		for($ii=1;$ii<=$scekriteria['jml_loop'];$ii++)
		{		
			$slc=$scekriteria['komposisi_group'].$ii;
			//echo "$r_data[$slc]<br>";
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($angka, $row, $r_data[$slc]);
			$cell = $colomabjad[$huruf].$row;
			$cell_bobot = "$".$colomabjad[$huruf]."$".$row_h2;
			$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			
			$sum=$sum."+($cell*$cell_bobot)";
			if($scekriteria['mapping_cq']=='Performance')
			{
				$perform=$perform."+($cell*$cell_bobot)";			
			}
			else
			{
				$poten=$poten."+($cell*$cell_bobot)";
			}
			
			$huruf++;
			$angka++;
		}		
	}
	
	$ctk_pres="=($sum)/50*100";
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($angka, $row, $ctk_pres);
	$cell = $colomabjad[$huruf].$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$cell_before=$cell;
	$huruf++;
	$angka++;
	
	$grade='=IF('.$cell_before.'>=91,"A",IF('.$cell_before.'>=76,"B",IF('.$cell_before.'>=60,"C",IF('.$cell_before.'>=40,"D","E"))))';
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($angka, $row, $grade);
	$cell = $colomabjad[$huruf].$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$huruf++;
	$angka++;
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($angka, $row, $r_data['komentar']);
	$cell = $colomabjad[$huruf].$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	$huruf++;
	$angka++;
	
	$q_sp	= mysqli_query($koneksi, "Select * from $tabel_sp where nik = '$r_data[NIK]'");
	$r_sp	= mysqli_fetch_array($q_sp);

	if(isset($r_sp['statussp'])){
		$statussp = $r_sp['statussp'];
	}else{
		$statussp = "";
	}
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($angka, $row, $statussp);
	$cell = $colomabjad[$huruf].$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
	 
	$objPHPExcel->getActiveSheet()->getStyle('A7:'.$cell)->getBorders()->getInside()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle('A7:'.$cell)->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$row++;
	$no++;	
}		
						

//freeze pane
$objPHPExcel->getActiveSheet()->freezePane('D7');
$p++;
}
//setpassword
// $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setPassword('HRIS');

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report Detail Performance Appraisal.xls"');
header('Cache-Control: max-age=0');

$writer = new Xls($objPHPExcel);
$writer->save('php://output');
exit;
?>