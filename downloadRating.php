<?php
require 'vendor1/autoload.php'; // Include the PhpSpreadsheet autoload file
require 'conf/conf.php';
require 'function.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$headerStyle = [
    'font' => [
        'bold' => true,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFFF00', // Yellow background color
        ],
    ],
    'borders' => [
        'outline' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'], // Black border color
        ],
    ],
];

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the JSON data from the POST request
    $json_data = file_get_contents("php://input");

    // Check if JSON data was successfully received
    if ($json_data !== false) {
        // Decode the JSON data into a PHP array
        $data = json_decode($json_data, true);

        // Check if JSON decoding was successful
        if (is_array($data) && isset($data["idpic"])) {
            // Access the "results" data as an array
            $idpic = $data["idpic"];
            $pic = $data["pic"];
            $grade = $data["grade"];

            $query = "SELECT a.rating, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_Departemen FROM transaksi_2023 a LEFT JOIN karyawan_2023 b ON b.id=a.idkar LEFT JOIN daftargolongan c ON c.Kode_Golongan=b.Kode_Golongan LEFT JOIN daftardepartemen d ON d.kode_departemen=b.Kode_Departemen WHERE a.approver_id = $idpic GROUP BY a.idkar";
            $stmt = $koneksi->query($query);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Create a PhpSpreadsheet instance
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);

            // Set headers
			$spreadsheet->getActiveSheet()->setCellValue('A2', 'No');
            $spreadsheet->getActiveSheet()->setCellValue('B2', 'Employee ID');
            $spreadsheet->getActiveSheet()->setCellValue('C2', 'Employee Name');
            $spreadsheet->getActiveSheet()->setCellValue('D2', 'Job');
            $spreadsheet->getActiveSheet()->setCellValue('E2', 'Grade');
            $spreadsheet->getActiveSheet()->setCellValue('F2', 'Division');
            $spreadsheet->getActiveSheet()->setCellValue('G2', 'Rating');
            
            $spreadsheet->getActiveSheet()->getStyle('A2:G2')->applyFromArray($headerStyle);

            // Start data from row 2
            $no = 1;
            $row = 3;
            foreach ($results as $rowObject) {
                $nik = $rowObject['nik_baru'] ? $rowObject['nik_baru'] : $rowObject['NIK'];
                
                $spreadsheet->getActiveSheet()->setCellValue('A1', 'Exported by : '.$data['pic']);
                $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $no);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $row, $nik);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $row, $rowObject['Nama_Lengkap']);
                $spreadsheet->getActiveSheet()->setCellValue('D' . $row, $rowObject['Nama_Jabatan']);
                $spreadsheet->getActiveSheet()->setCellValue('E' . $row, $rowObject['Nama_Golongan']);
                $spreadsheet->getActiveSheet()->setCellValue('F' . $row, $rowObject['Nama_Departemen']);
                $spreadsheet->getActiveSheet()->setCellValue('G' . $row, convertRating($rowObject['rating']));
                $row++;
                $no++;
            }
			$spreadsheet->getActiveSheet()->mergeCells('A1:C1');
			$lastRow = $row - 1;
			$lastColumn = 'G';
			$cellRange = 'A2:' . $lastColumn . $lastRow;
			
			$spreadsheet->getActiveSheet()->getStyle($cellRange)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			
			$spreadsheet->setActiveSheetIndex(0);
            // Create a Writer
            $writer = new Xls($spreadsheet);

            // Set response headers for file download
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="test_export.xls"');
            header('Cache-Control: max-age=0');

            // Output the file directly to the browser
            $writer->save('php://output');
            exit(); // Exit to prevent any further output
        } else {
            // Handle the case where the JSON data is invalid or missing "results"
            $response = "Invalid or missing 'results' data in POST request";
            http_response_code(400); // Bad Request
            echo json_encode($response);
            exit();
        }
    } else {
        // Handle the case where JSON data was not received
        $response = "Failed to receive JSON data from the POST request";
        http_response_code(500); // Internal Server Error
        echo json_encode($response);
        exit();
    }
} else {
    // Handle the case where the request is not a POST request
    $response = "Only POST requests are allowed";
    http_response_code(405); // Method Not Allowed
    echo json_encode($response);
    exit();
}
?>