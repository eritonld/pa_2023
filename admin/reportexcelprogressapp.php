<?php
set_time_limit(0);

require("conf_report.php");
include("../tabel_setting.php");

require '../vendor1/autoload.php';
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
if ($unit <> ''){
	$where=$where." and k.Kode_OU in $unit";
}else{
	$unit = $scekuser['ou'];
	$where=$where." and k.Kode_OU in $unit";
}

//data perusahaan
if ($pt <> ''){
	$where=$where." and k.Kode_Perusahaan in $pt";
}else{
	$pt = $scekuser['pt'];
	$where=$where." and k.Kode_Perusahaan in $pt";
}

//data dept
if ($dept <> ''){
	$where=$where." and k.Kode_Departemen in $dept";
}else{
	$dept = $scekuser['dept'];
	$where=$where." and k.Kode_Departemen in $dept";
}

//data grade
if ($grade <> ''){
	$where=$where." and k.Kode_Golongan in $grade";
}else{
	$grade = $scekuser['gol'];
	$where=$where." and k.Kode_Golongan in $grade";
}

//data bisnis
if ($bisnis <> ''){
	$where=$where." and do.BU in $bisnis";
}else{
	$bisnis = $scekuser['bisnis'];
	$where=$where." and do.BU in $bisnis";
}

set_time_limit(0);
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');

// Create new PHPExcel object
// $objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("HC System Development")
							 ->setLastModifiedBy("")
							 ->setTitle("Report Performance Appraisal")
							 ->setSubject("Report Performance Appraisal")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory('');

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);

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
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');

//header kolom NIK
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'NIK');

//header kolom Nama
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Nama');

//header kolom jabatan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jabatan');

//header kolom golongan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Golongan');

//header kolom PT
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'PT');

//header kolom unit
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Unit');

//header kolom Departemen
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Departemen');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'L1');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'L2');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('K4', 'L3');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('L4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('L4', 'L4');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('M4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('M4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('M4', 'L5');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('N4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('N4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('N4', 'L6');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('O4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('O4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('O4', 'L7');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('P4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('P4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('P4', 'L8');

$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('Q4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('Q4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->SetCellValue('Q4', 'Status');

$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4:Q4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

$yearnow	= Date('Y');
$cutoff		= $yearnow."-06-30";
$q_data = mysqli_query ($koneksi, "SELECT k.id,k.nik_baru, k.Nama_Lengkap, k.Nama_Jabatan, do.Nama_OU, dg.Nama_Golongan, dp.Nama_Perusahaan, aa.layer, kk.Nama_Lengkap as nama_atasan, ku.kpi_unit, t.approval_status, t.updated_date, tf.approver_rating_id,dep.Nama_Departemen FROM `karyawan_2023` as k
left join daftarou do on k.Kode_OU = do.Kode_OU
left join daftarperusahaan dp on k.Kode_Perusahaan = dp.Kode_Perusahaan 
left join daftargolongan dg on k.Kode_Golongan = dg.Kode_golongan
left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen 
left join atasan as aa on aa.idkar=k.id
left join kpi_unit_2023 as ku on ku.idkar=aa.id_atasan and ku.status_aktif='T'
left join karyawan_2023 as kk on kk.id=aa.id_atasan
left join transaksi_2023 as t on t.idkar=k.id and t.layer=aa.layer and aa.id_atasan=t.approver_id
left join transaksi_2023_final as tf on tf.idkar=k.id
where k.Kode_StatusKerja<>'SKH05' $where and k.Mulai_Bekerja <= '$cutoff' ORDER BY k.Nama_Lengkap, k.id, aa.layer ASC");

$no 	= 1;
$row 	= 5;

$nodata = 1;
$nourut = 1;
$yearnow	= Date('Y');
$cutoff		= $yearnow."-06-30";
$idkar		= "";

$layer1="";
$layer2="";
$layer3="";
$layer4="";
$layer5="";
$layer6="";
$layer7="";
$layer8="";

$bcg1="";
$bcg2="";
$bcg3="";
$bcg4="";
$bcg5="";
$bcg6="";
$bcg7="";
$bcg8="";
// $per1	= (25/1);
// $per2	= (20/1);
// $per3	= (55/1);
while ($r_data = mysqli_fetch_array ($q_data))
{
	if(($r_data['layer']=='L1' || $r_data['layer']==null) && $nodata<>1){
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $nourut);
		$cell = 'A'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$nik="'$r_data[nik_baru]";
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $nikbaru);
		$cell = 'B'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $namakar);
		$cell = 'C'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $namajab);
		$cell = 'D'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);	
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $namagol);
		$cell = 'E'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $namapt);
		$cell = 'F'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $namaou);
		$cell = 'G'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $namadept);
		$cell = 'H'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $layer1);
		$cell = 'I'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $layer2);
		$cell = 'J'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $layer3);
		$cell = 'K'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $layer4);
		$cell = 'L'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $layer5);
		$cell = 'M'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $layer6);
		$cell = 'N'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $layer7);
		$cell = 'O'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $row, $layer8);
		$cell = 'P'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $row, $detail_status);
		$cell = 'Q'.$row;
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
		$row++;
		$nourut++;
		$detail_status="";
		$layer1="";
		$layer2="";
		$layer3="";
		$layer4="";
		$layer5="";
		$layer6="";
		$layer7="";
		$layer8="";
		$bcg1="";
		$bcg2="";
		$bcg3="";
		$bcg4="";
		$bcg5="";
		$bcg6="";
		$bcg7="";
		$bcg8="";
	}
	   
	$nikbaru = $r_data['nik_baru'];
	$namakar = $r_data['Nama_Lengkap'];
	$namajab = $r_data['Nama_Jabatan'];
	$namagol = $r_data['Nama_Golongan'];
	$namapt = $r_data['Nama_Perusahaan'];
	$namaou = $r_data['Nama_OU'];
	$namadept = $r_data['Nama_Departemen'];

	//detail status
	if($r_data['layer']==null){
		$detail_status="no layer";
	}else if($r_data['approval_status']==null){
		$detail_status="no appraisal";
	}else if($r_data['approver_rating_id']==0){
		$detail_status="Completed";
	}else{
		$detail_status="";
	}

	//detail layer
	if($r_data['layer']=='L1'){
		if($r_data['approval_status']=='Approved'){ 
			$layer1="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer1="-";
		}
		if($r_data['kpi_unit']<>null){$bcg1="#E3FAD8";}else{$bcg1="#FFF5EE";}
	}
	if($r_data['layer']=='L2'){
		if($r_data['approval_status']=='Approved'){ 
			$layer2="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer2="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg2="#E3FAD8";}else{$bcg2="#FFF5EE";}
	}
	if($r_data['layer']=='L3'){
		if($r_data['approval_status']=='Approved'){ 
			$layer3="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer3="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg3="#E3FAD8";}else{$bcg3="#FFF5EE";}
	}
	if($r_data['layer']=='L4'){
		if($r_data['approval_status']=='Approved'){ 
			$layer4="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer4="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg4="#E3FAD8";}else{$bcg4="#FFF5EE";}
	}
	if($r_data['layer']=='L5'){
		if($r_data['approval_status']=='Approved'){ 
			$layer5="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer5="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg5="#E3FAD8";}else{$bcg5="#FFF5EE";}
	}
	if($r_data['layer']=='L6'){
		if($r_data['approval_status']=='Approved'){ 
			$layer6="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer6="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg6="#E3FAD8";}else{$bcg6="#FFF5EE";}
	}
	if($r_data['layer']=='L7'){
		if($r_data['approval_status']=='Approved'){ 
			$layer7="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer7="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg7="#E3FAD8";}else{$bcg7="#FFF5EE";}
	}
	if($r_data['layer']=='L8'){
		if($r_data['approval_status']=='Approved'){ 
			$layer8="ok"; 
		}else if($r_data['approval_status']=='Pending'){ 
			$layer8="-"; 
		}
		if($r_data['kpi_unit']<>null){$bcg8="#E3FAD8";}else{$bcg8="#FFF5EE";}
	}

	$nodata++;
	
	
	$no++;	
}									

//freeze pane
$objPHPExcel->getActiveSheet()->freezePane('D5');

//setpassword
// $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
// $objPHPExcel->getActiveSheet()->getProtection()->setPassword('HRIS');

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("PA Recap");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Report Performance Appraisal.xls"');
header('Cache-Control: max-age=0');

$writer = new Xls($objPHPExcel);
$writer->save('php://output');
exit;
?>