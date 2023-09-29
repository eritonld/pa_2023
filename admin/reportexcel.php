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

// set_time_limit(0);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(55);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);

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
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');

//header kolom NIK
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'NIK');

//header kolom Nama
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'Nama');

//header kolom jabatan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jabatan');

//header kolom golongan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Golongan');

//header kolom PT
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'PT');

//header kolom unit
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Unit');

//header kolom Departemen
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Departemen');

//header kolom Total Nilai
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Total Nilai');

//header kolom Total Nilai
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Nilai Mutu');

//header kolom KOMENTAR
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('K4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('K4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('K4', 'KOMENTAR');

//header kolom SP
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('L4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('L4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('L4', 'SP');

$yearnow	= Date('Y');
$cutoff		= $yearnow."-07-01";
$q_data = mysqli_query ($koneksi, "select tp.edit_by, tp.edit_by2,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen, dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU, tp.komentar,tp.total,tpa.total as totalawal,tpa1.total as total1,tpa2.total as total2,
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
where k.Kode_StatusKerja<>'SKH05' $where and tp.input_by <>'' and k.Mulai_Bekerja <= '$cutoff' order by k.kode_ou asc, k.Nama_Lengkap ASC");

$no 	= 1;
$row 	= 5;
// $per1	= (25/1);
// $per2	= (20/1);
// $per3	= (55/1);
while ($r_data = mysqli_fetch_array ($q_data))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
	$cell = 'A'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, "'".$r_data['NIK']);
	$cell = 'B'.$row;
	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $r_data['Nama_Lengkap']);
	$cell = 'C'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $r_data['Nama_Jabatan']);
	$cell = 'D'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);	
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $r_data['Nama_Golongan']);
	$cell = 'E'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $r_data['Nama_Perusahaan']);
	$cell = 'F'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $r_data['Nama_OU']);
	$cell = 'G'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $r_data['Nama_Departemen']);
	$cell = 'H'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $r_data['total']);
	$cell = 'I'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, getGrade($r_data['total']));
	$cell = 'J'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $r_data['komentar']);
	$cell = 'K'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$q_sp	= mysqli_query($koneksi, "Select * from $tabel_sp where nik = '$r_data[NIK]'");
	$r_sp	= mysqli_fetch_array($q_sp);

	if(isset($r_sp['statussp'])){
		$statussp = $r_sp['statussp'];
	}else{
		$statussp = "";
	}
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $statussp);
	$cell = 'L'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED);
	
	$row++;
	$no++;	
}						

$range='B:B';			
$objPHPExcel->getActiveSheet()->getStyle($range)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
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