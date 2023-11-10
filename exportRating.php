<?php
require 'vendor/autoload.php'; // Include the PhpSpreadsheet autoload file
require 'function.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        if (is_array($data) && isset($data["results"])) {
            // Access the "results" data as an array
            $results = $data["results"];

            // Create a PhpSpreadsheet instance
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set headers
            $sheet->setCellValue('A2', 'No');
            $sheet->setCellValue('B2', 'Employee Name');
            $sheet->setCellValue('C2', 'Job');
            $sheet->setCellValue('D2', 'Grade');
            $sheet->setCellValue('E2', 'Division');
            $sheet->setCellValue('F2', 'Suggested Rating');
            $sheet->setCellValue('G2', 'Proposed Rating');
            
            $sheet->getStyle('A2:G2')->applyFromArray($headerStyle);

            // Start data from row 2
            $no = 1;
            $row = 3;
            foreach ($results as $rowObject) {
                $sheet->setCellValue('A1', 'Exported by : '.$rowObject['exportBy']);
                $sheet->setCellValue('A' . $row, $no);
                $sheet->setCellValue('B' . $row, $rowObject['Nama_Lengkap']);
                $sheet->setCellValue('C' . $row, $rowObject['Nama_Jabatan']);
                $sheet->setCellValue('D' . $row, $rowObject['Nama_Golongan']);
                $sheet->setCellValue('E' . $row, $rowObject['Nama_Departemen']);
                $sheet->setCellValue('F' . $row, convertRating($rowObject['suggestedRating']));
                $sheet->setCellValue('G' . $row, convertRating($rowObject['proposedRating']));
                $row++;
                $no++;
            }
$sheet->mergeCells('A1:C1');
$lastRow = $row - 1;
$lastColumn = 'G';
$cellRange = 'A2:' . $lastColumn . $lastRow;

$sheet->getStyle($cellRange)->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '000000'], // Black border color
        ],
    ],
]);

            // Create a Writer
            $writer = new Xlsx($spreadsheet);

            // Set response headers for file download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="test_export.xlsx"');
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
