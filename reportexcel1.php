<?php
/** PHPExcel */
require_once 'PHPExcel/PHPExcel.php';
require("conf/conf.php");
include("tabel_setting.php");

$idmaster	= $_GET['idmaster'];
if(isset($_GET['nikatasan'])){$nikatasan = $_GET['nikatasan'];}else{$nikatasan 	= "";}
if(isset($_GET['atasan'])){$atasan = $_GET['atasan'];}else{$atasan 	= "";}

function getGrade($nilai)
{
	require("conf/conf.php");
	$tahun=date('Y');
	$cekkriteria=mysqli_query($koneksi,"select ranges,grade,kesimpulan,warna,icon,bermasalah from kriteria where tahun='$tahun' order by id asc");
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

set_time_limit(0);
error_reporting(E_ALL);

date_default_timezone_set('Europe/London');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$objPHPExcel = new Spreadsheet();

// Set properties
$objPHPExcel->getProperties()->setCreator("HC System Development")
							 ->setLastModifiedBy("")
							 ->setTitle("Rekap Penilaian Karyawan")
							 ->setSubject("Rekap Penilaian Karyawan")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory('');

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial Unicode MS');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);

$objPHPExcel->getActiveSheet()->setShowGridlines(false);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);


//header Wilmar
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(32);
$objPHPExcel->getActiveSheet()->mergeCells('A1:I1');						  
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'KPN Corps.');
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('A4', 'No');

//header kolom Nama
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('B4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Nama');

//header kolom Nik
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('C4', 'NIK');

//header kolom jabatan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('D4', 'Jabatan');


//header kolom golongan
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('E4', 'Golongan');

//header kolom unit
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('F4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('F4', 'Unit');

//header kolom Departemen
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('G4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('G4', 'Departemen');

//header kolom Total Nilai
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'Total Nilai');

//header kolom Total Nilai
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('I4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'Nilai Mutu');

//header kolom Total Nilai
$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);					  
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('ffffff');
$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'Komentar');


if(trim($atasan)<> '')
{
	if ($atasan==1)
	{
		$q_data = mysqli_query ($koneksi,"select tp.*,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
												dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU from $karyawan as k
												left join daftarou as do on k.Kode_OU = do.Kode_OU
												left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
												left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
												
												left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
												left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
												left join $transaksi_pa as tp on k.NIK = tp.NIK
												left join atasan as a on k.NIK = a.nik
												where a.nik_atasan1 = '$nikatasan' 
												
												
												order by k.Nama_lengkap ASC");
    //	and date_input <> ''
	}
	
	else
	{
		$q_data = mysqli_query ($koneksi,"select tp.*,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,
												dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU from $karyawan as k
												left join daftarou as do on k.Kode_OU = do.Kode_OU
												left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
												left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
												
												left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
												left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
												left join $transaksi_pa as tp on k.NIK = tp.NIK
												left join atasan as a on k.NIK = a.nik
												where a.nik_atasan2 = '$nikatasan' 			
												
												order by k.Nama_lengkap ASC");
	}
}
else
{	

$q_data = mysqli_query ($koneksi,"select 		tp.*,k.NIK,k.Nama_Lengkap,k.Mulai_Bekerja,dp.Nama_Perusahaan,dep.Nama_Departemen,dg.Nama_Golongan,k.Nama_Jabatan, tp.date_input, do.Nama_OU from $karyawan as k
									left join daftarou as do on k.Kode_OU = do.Kode_OU
									left join daftarperusahaan as dp on k.Kode_Perusahaan=dp.Kode_Perusahaan
									left join daftardepartemen as dep on k.Kode_Departemen=dep.Kode_Departemen
									
									left join daftargolongan as dg on k.Kode_Golongan=dg.Kode_Golongan
									left join daftarjabatan as dj on k.Kode_Jabatan=dj.Kode_Jabatan
									left join $transaksi_pa as tp on k.NIK = tp.NIK
									where tp.input_by = $idmaster ");
}									
$no 	= 1;
$row 	= 5;
$per1	= (25/1);
$per2	= (20/1);
$per3	= (55/1);
while ($r_data = mysqli_fetch_array ($q_data))
{
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $no);
	$cell = 'A'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $r_data['Nama_Lengkap']);
	$cell = 'B'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $r_data['NIK']);
	$cell = 'C'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $r_data['Nama_Jabatan']);
	$cell = 'D'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);	
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $r_data['Nama_Golongan']);
	$cell = 'E'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $r_data['Nama_OU']);
	$cell = 'F'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $r_data['Nama_Departemen']);
	$cell = 'G'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $r_data['total']);
	$cell = 'H'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
		
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, getGrade($r_data['total']));
	$cell = 'I'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $r_data['komentar']);
	$cell = 'J'.$row;
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
	
	$row++;
	$no++;	
}									

//freeze pane
$objPHPExcel->getActiveSheet()->freezePane('C5');

//setpassword
$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()->getProtection()->setPassword('HCIS');

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("PA Recap");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Performance Appraisal Recap.xls"');
header('Cache-Control: max-age=0');

$writer = new Xls($objPHPExcel);
$writer->save('php://output');
exit;					 
?>