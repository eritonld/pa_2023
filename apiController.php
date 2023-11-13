<?php
include 'conf/conf.php'; // Include the database connection script
session_start();

include("tabel_setting.php");
include("function.php");
use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require 'vendor/autoload.php';

$code 		= isset($_GET['code']) ? $_GET['code'] : '';
$jg 		= isset($_GET['jg']) ? $_GET['jg'] : '';
$id 		= isset($_GET['id']) ? $_GET['id'] : '';
$date		= Date('Y-m-d');
$datetime	= Date('Y-m-d H:i:s');
$iduser     = isset($_SESSION['idmaster_pa']) ? $_SESSION['idmaster_pa'] : '';

if($code == 'getPenilaian') {

    try {
        $stmtKpi = $koneksi->prepare("SELECT kpi_unit FROM kpi_unit_2023 WHERE idkar='$iduser'");

        $stmtKpi->execute();

        $resultKpi = $stmtKpi->rowCount();

        if($resultKpi){
            $sql = "SELECT b.id, a.id AS idkar, b.total_score, b.rating, b.created_by, b.updated_by, b.updated_date, b.approver_id, b.layer, b2.approval_review, a.Nama_Lengkap, a.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(b.created_date, '%d-%m-%Y') AS created_date, f.id_atasan AS id_L1, kf.Nama_Lengkap AS nama_L1, kg.Nama_Lengkap AS review_name, f.layer AS layerL1, b3.approval_status
            FROM $karyawan AS a
            LEFT JOIN atasan AS f ON f.idkar=a.id AND f.layer IN ('L0')
            LEFT JOIN $karyawan AS kf ON kf.id=f.id_atasan
            LEFT JOIN transaksi_2023 AS b ON b.idkar = a.id AND b.approver_id=f.id_atasan
            LEFT JOIN transaksi_2023_final AS b2 ON b2.idkar = b.idkar
            LEFT JOIN transaksi_2023 AS b3 ON b3.idkar = a.id
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = a.Kode_Golongan
            LEFT JOIN daftarou AS d ON d.Kode_OU = a.Kode_OU
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = a.Kode_Departemen
            LEFT JOIN $karyawan AS kg ON kg.id=b2.approver_review_id
            WHERE (a.id='$iduser' OR f.id_atasan='$iduser' OR b.created_by='$iduser' OR b3.approver_id='$iduser') GROUP BY a.id";
        }else{
            $sql = "SELECT b.id, a.id AS idkar, b.total_score, b.rating, b.created_by, b.updated_by, b.updated_date, b.approver_id, b.layer, b2.approval_review, a.Nama_Lengkap, a.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(b.created_date, '%d-%m-%Y') AS created_date, f.id_atasan AS id_L1, kf.Nama_Lengkap AS nama_L1, kg.Nama_Lengkap AS review_name, f.layer AS layerL1, b3.approval_status
            FROM $karyawan AS a
            LEFT JOIN atasan AS f ON f.idkar=a.id AND f.layer IN ('L0','L1')
            LEFT JOIN $karyawan AS kf ON kf.id=f.id_atasan
            LEFT JOIN transaksi_2023 AS b ON b.idkar = a.id AND b.approver_id=f.id_atasan
            LEFT JOIN transaksi_2023_final AS b2 ON b2.idkar = b.idkar
            LEFT JOIN transaksi_2023 AS b3 ON b3.idkar = a.id
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = a.Kode_Golongan
            LEFT JOIN daftarou AS d ON d.Kode_OU = a.Kode_OU
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = a.Kode_Departemen
            LEFT JOIN $karyawan AS kg ON kg.id=b2.approver_review_id
            WHERE (a.id='$iduser' OR b.created_by AND f.id_atasan='$iduser' OR f.layer='L0' AND f.id_atasan='$iduser' OR b2.approver_review_id='$iduser' OR b3.approver_id='$iduser') GROUP BY a.id";
        }
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employees),
                "totaldisplayrecords" => count($employees),
                "data" => $employees
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

}else if($code == 'getRating') {
    $jg = $jg=="23"? "('GL004','GL005','GL006','GL007','GL008','GL009')" : ($jg=="45"? "('GL013','GL014','GL016','GL017')" : ($jg=="67"? "('GL020','GL021','GL024','GL025')" : "('GL028','GL029','GL031','GL032')"));
    try {
        $sql = "SELECT b.id, a.id AS idkar, b.total_score, b.rating, b.layer, b.created_by,
        CASE
        WHEN b.rating = '' THEN 'no rating'
        WHEN b.rating = 5 THEN 'A'
        WHEN b.rating = 4 THEN 'B'
        WHEN b.rating = 3 THEN 'C'
        WHEN b.rating = 2 THEN 'D'
        WHEN b.rating = 1 THEN 'E'
        ELSE ''
        END AS convertRating, 
        a.Nama_Lengkap, a.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(b.created_date, '%d-%m-%Y') AS created_date, kf.Nama_Lengkap AS nama_atasan_view, kg.Nama_Lengkap AS nama_a1, f.id_atasan as id_atasan, f.layer as layerUser
        FROM $karyawan AS a
        LEFT JOIN transaksi_2023_final AS b ON b.idkar = a.id
        LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = a.Kode_Golongan
        LEFT JOIN daftarou AS d ON d.Kode_OU = a.Kode_OU
        LEFT JOIN daftardepartemen AS e ON e.kode_departemen = a.Kode_Departemen
        LEFT JOIN atasan AS f ON f.idkar=b.idkar
        LEFT JOIN $karyawan AS kf ON kf.id=f.id_atasan
        LEFT JOIN atasan AS g ON g.idkar=b.idkar AND g.layer='L1'
        LEFT JOIN $karyawan AS kg ON kg.id=g.id_atasan
        WHERE ( b.created_by='$iduser' OR f.id_atasan='$iduser' ) AND a.id!='$iduser'
        AND a.Kode_Golongan IN $jg GROUP BY a.id";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employees),
                "totaldisplayrecords" => count($employees),
                "data" => $employees
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

} else if($code == 'updateRating'){

        // Create a database connection
        $json_data = file_get_contents("php://input");

        $data = json_decode($json_data, true);
        $results = $data["results"];

        try {
            // Create a PDO connection

            // Set PDO to throw exceptions on error
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute SQL queries to update the MySQL table
            foreach ($results as $row) {
                $id = $row["id"];
                $rating = $row["rating"];
                $idkar = $row["idkar"];
                $idpic = $row["idpic"];
                $id_atasan = $row["id_atasan"];
                // echo $idkar;
                // Replace "your_table_name" with the actual table name in your database
                $query2023 = "UPDATE transaksi_2023 SET rating = :rating, approval_status = 'Approved', updated_by = :idpic, updated_date = :updated_date WHERE idkar = :idkar AND approver_id = :idpic";
                $stmt2023 = $koneksi->prepare($query2023);
                $stmt2023->bindParam(":rating", $rating);
                $stmt2023->bindParam(":idkar", $idkar);
                $stmt2023->bindParam(":idpic", $idpic);
                $stmt2023->bindParam(":updated_date", $datetime);
                $stmt2023->execute();

                $queryFinal = "UPDATE transaksi_2023_final SET rating = :rating, updated_by = :idpic, updated_date = :updated_date, approver_rating_id = :id_atasan WHERE idkar = :idkar AND approver_rating_id = :idpic";
                $stmtFinal = $koneksi->prepare($queryFinal);
                $stmtFinal->bindParam(":rating", $rating);
                $stmtFinal->bindParam(":idkar", $idkar);
                $stmtFinal->bindParam(":idpic", $idpic);
                $stmtFinal->bindParam(":id_atasan", $id_atasan);
                $stmtFinal->bindParam(":updated_date", $datetime);
                $stmtFinal->execute();
            }

            // Close the database connection
            $koneksi = null;

            // Respond with a success message
            $response = "Data updated successfully!";
            echo json_encode($response);
        } catch (PDOException $e) {
            // Handle any PDO exceptions (database errors)
            $response = "Error updating data: " . $e->getMessage();
            http_response_code(500); // Internal Server Error
            echo json_encode($response);
        }

} else if($code == 'getPenilaianA1') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, a.created_by, a.rating, a.layer, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.Nama_Lengkap AS nama_atasan FROM transaksi_2023 AS a  LEFT JOIN $karyawan AS b ON b.id = a.idkar  LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan  LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU  LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen LEFT JOIN atasan AS f ON f.idkar=a.idkar LEFT JOIN $karyawan AS g ON g.id=f.id_atasan WHERE f.id_atasan='$iduser'";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employees),
                "totaldisplayrecords" => count($employees),
                "data" => $employees
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

    // Step 6: Close the database connection
    // $koneksi->close();

}else if($code == 'getPenilaianA2') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, a.rating, a.layer, f.id_atasan, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.Nama_Lengkap AS nama_atasan
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                LEFT JOIN $karyawan AS g ON g.id=f.id_atasan
                WHERE f.id_atasan='$iduser'";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employees),
                "totaldisplayrecords" => count($employees),
                "data" => $employees
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

    // Step 6: Close the database connection
    // $koneksi->close();

}else if($code == 'getPenilaianA3') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, a.rating, a.layer, f.id_atasan, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date 
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                WHERE f.id_atasan='$iduser'";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employees),
                "totaldisplayrecords" => count($employees),
                "data" => $employees
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

    // Step 6: Close the database connection
    // $koneksi->close();

}else if($code == 'getPenilaianSuperior') {

    try {

        $sql = "SELECT a.id, a.idkar, a.total_score, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.created_by
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar='$iduser'
                LEFT JOIN transaksi_2023_subo AS g ON g.created_by='$iduser'
                WHERE a.idkar=f.id_atasan";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employee = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employee),
                "totaldisplayrecords" => count($employee),
                "data" => $employee
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

    // Step 6: Close the database connection
    // $koneksi->close();

}else if($code == 'getPenilaianPeers') {

    try {

        $sql = "SELECT a.id, a.idkar, a.total_culture, a.total_leadership, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.created_by
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN transaksi_2023_peers AS g ON g.peers='$iduser'
                WHERE a.idkar=g.idkar";
    
        $result = $koneksi->query($sql);
    
        if ($result) {
            $employee = $result->fetchAll(PDO::FETCH_ASSOC);
    
            $dataset = array(
                "totalrecords" => count($employee),
                "totaldisplayrecords" => count($employee),
                "data" => $employee
            );
    
            header('Content-Type: application/json');
            echo json_encode($dataset);
        } else {
            echo json_encode(array("error" => "Query execution failed."));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
    

    // Step 6: Close the database connection
    // $koneksi->close();
}elseif($code == 'testApi'){
    $cekL2 = "SELECT b.idkar, b.kpi_unit FROM atasan a LEFT JOIN kpi_unit_2023 b ON b.idkar=a.id_atasan WHERE layer='L2' AND a.idkar='2979' AND b.kpi_unit!=''";

        $stmtCekL2 = $koneksi->prepare($cekL2);
        $stmtCekL2->execute();

        $countL2 = $stmtCekL2->rowCount();

        echo $countL2;
}else if($code == 'submitNilaiAwal') {
    $pic = $_POST["pic"];
    $idpic = $_POST["idpic"];
    $idkar = $_POST["idkar"];
    $id_atasan = $_POST["id_atasan"];
    $email_atasan = $_POST["email_atasan"];
    $value1 = $_POST["value1"];
    $value2 = $_POST["value2"];
    $value3 = $_POST["value3"];
    $value4 = $_POST["value4"];
    $value5 = $_POST["value5"];
    $score1 = $_POST["score1"];
    $score2 = $_POST["score2"];
    $score3 = $_POST["score3"];
    $score4 = $_POST["score4"];
    $score5 = $_POST["score5"];
    $total_score = floor($_POST["total_score"]);
    $fortable = $_POST["fortable"];
    $periode = 2023;
    $synergized1 = floatval(isset($_POST["synergized1"]) ? $_POST["synergized1"] : 0);
    $synergized2 = floatval(isset($_POST["synergized2"]) ? $_POST["synergized2"] : 0);
    $synergized3 = floatval(isset($_POST["synergized3"]) ? $_POST["synergized3"] : 0);
    $integrity1 = floatval(isset($_POST["integrity1"]) ? $_POST["integrity1"] : 0);
    $integrity2 = floatval(isset($_POST["integrity2"]) ? $_POST["integrity2"] : 0);
    $integrity3 = floatval(isset($_POST["integrity3"]) ? $_POST["integrity3"] : 0);
    $growth1 = floatval(isset($_POST["growth1"]) ? $_POST["growth1"] : 0);
    $growth2 = floatval(isset($_POST["growth2"]) ? $_POST["growth2"] : 0);
    $growth3 = floatval(isset($_POST["growth3"]) ? $_POST["growth3"] : 0);
    $adaptive1 = floatval(isset($_POST["adaptive1"]) ? $_POST["adaptive1"] : 0);
    $adaptive2 = floatval(isset($_POST["adaptive2"]) ? $_POST["adaptive2"] : 0);
    $adaptive3 = floatval(isset($_POST["adaptive3"]) ? $_POST["adaptive3"] : 0);
    $passion1 = floatval(isset($_POST["passion1"]) ? $_POST["passion1"] : 0);
    $passion2 = floatval(isset($_POST["passion2"]) ? $_POST["passion2"] : 0);
    $passion3 = floatval(isset($_POST["passion3"]) ? $_POST["passion3"] : 0);
    $leadership1 = floatval(isset($_POST["leadership1"]) ? $_POST["leadership1"] : 0);
    $leadership2 = floatval(isset($_POST["leadership2"]) ? $_POST["leadership2"] : 0);
    $leadership3 = floatval(isset($_POST["leadership3"]) ? $_POST["leadership3"] : 0);
    $leadership4 = floatval(isset($_POST["leadership4"]) ? $_POST["leadership4"] : 0);
    $leadership5 = floatval(isset($_POST["leadership5"]) ? $_POST["leadership5"] : 0);
    $leadership6 = floatval(isset($_POST["leadership6"]) ? $_POST["leadership6"] : 0);
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;
    
    // $layer = isset($_POST["layer"]) ? $_POST["layer"] : "";
    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
    $finalAvg = $total_leadership == 0 ? 2 : 3;
    $final_score = floor(number_format(($total_score + $total_culture + $total_leadership) / $finalAvg , 2));
    $rating = $final_score;
    
    $empty = null;

    $tabel_prosedure="prosedure";
    $a1='Penilaian Kinerja Karyawan';
    $a2='Nama Karyawan';
    $a3='Nama PT / Unit';
    $a4='Nomor Induk';
    $a5='Divisi/Departemen';
    $a6='Jabatan';
    $a7='Seksi/SubSeksi';
    $a8='Mulai bekerja';
    $a9='Periode Penilaian';
    $a10='Golongan';
    $a11='SP/Periode';
    $a12='Bobot';
    $a13='Pembobotan';
    $a14='Untuk detail klik link berikut';
    $a15='Jangan reply pesan ini, email ini dikirim secara otomatis oleh system  <p>----- <br> HC System Development';
    $a16='telah melakukan penilaian PA';	

    try {

        $queryLayer = "SELECT id_atasan, layer FROM atasan WHERE idkar = :idkar AND id_atasan != ''";

        // Prepare the statement
        $stmtLayer = $koneksi->prepare($queryLayer);
        $stmtLayer->bindParam(':idkar', $idkar, PDO::PARAM_INT);

        // Execute the query
        $stmtLayer->execute();

        // Fetch the results as an array
        $resultLayer = $stmtLayer->fetchAll(PDO::FETCH_ASSOC);

        // Output the results
        // print_r($resultLayer);
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        $getData = "SELECT k.id AS idkar, k.NIK, k.nik_baru, k.Nama_Lengkap, dp.Nama_Perusahaan, dep.Nama_Departemen, dg.Nama_Golongan, k.Nama_Jabatan, DATE_FORMAT(k.Mulai_Bekerja, '%d-%m-%Y') AS tmk
        FROM $karyawan AS k
        LEFT JOIN daftarperusahaan AS dp ON k.Kode_Perusahaan = dp.Kode_Perusahaan
        LEFT JOIN daftardepartemen AS dep ON k.Kode_Departemen = dep.Kode_Departemen
        LEFT JOIN daftargolongan AS dg ON k.Kode_Golongan = dg.Kode_Golongan
        LEFT JOIN daftarjabatan AS dj ON k.Kode_Jabatan = dj.Kode_Jabatan
        LEFT JOIN daftarou AS du ON k.Kode_OU = du.Kode_OU
        WHERE k.id = :id";

        $stmt1 = $koneksi->prepare($getData);
        $stmt1->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmt1->execute();

        $ckaryawan = $stmt1->fetch(PDO::FETCH_ASSOC);

        $cekL0 = "SELECT id_atasan FROM atasan WHERE layer='L0' AND idkar = :id";

        $stmtCekL0 = $koneksi->prepare($cekL0);
        $stmtCekL0->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmtCekL0->execute();

        $resultL0 = $stmtCekL0->fetchAll(PDO::FETCH_ASSOC);
        $countL0  = count($resultL0);

        $cekL2 = "SELECT b.idkar, b.kpi_unit FROM atasan a LEFT JOIN kpi_unit_2023 b ON b.idkar=a.id_atasan WHERE layer='L2' AND a.idkar=:id AND b.kpi_unit!=''";

        $stmtCekL2 = $koneksi->prepare($cekL2);
        $stmtCekL2->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmtCekL2->execute();

        $countL2 = $stmtCekL2->rowCount();

        $cekLRating = "SELECT a.layer, a.id_atasan, b.kpi_unit FROM atasan a LEFT JOIN kpi_unit_2023 b ON b.idkar=a.id_atasan WHERE a.idkar=:id AND !b.kpi_unit ORDER BY a.id LIMIT 1";

        $stmtLRating = $koneksi->prepare($cekLRating);
        $stmtLRating->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmtLRating->execute();

        $resultLRating = $stmtLRating->fetch(PDO::FETCH_ASSOC);

        $L0 = 'L0';
        $layerApproval = $countL2 ? 'L1' : 'L2';
        $atasanReview = $countL2 ? $resultLayer[1]['id_atasan'] : $resultLayer[2]['id_atasan'];

        $nik = $ckaryawan['nik_baru'] ? $ckaryawan['nik_baru'] : $ckaryawan['NIK'];

        $stmtKpi = $koneksi->prepare("SELECT kpi_unit FROM kpi_unit_2023 WHERE idkar='$idpic'");

        $stmtKpi->execute();

        $resultKpi = $stmtKpi->rowCount();

        $approval_review = $idpic != $idkar ? 'Approved' : 'Pending';

        if (!$resultKpi && $idpic!=$idkar) {
            // Update karyawan ke approval ke 2
        }

        if ($ckaryawan) {
            // Process the data here
            // Define the common SQL INSERT statement
            $queryInsert = "INSERT INTO %s (`id`, idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, created_by, periode, total_culture, total_leadership, rating, `comment`, created_date, fortable, layer, approver_id, approval_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $queryInsertFinal = "INSERT INTO %s (`id`, idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, created_by, periode, total_culture, total_leadership, rating, `comment`, created_date, fortable, layer, approver_review_id, approver_rating_id, layer_rating, approval_review) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $errors = false;
        
        $tableName = 'transaksi_2023';
        $tableFinal = 'transaksi_2023_final';
        // Initialize a variable to track any errors
        
        try {
            // Begin a transaction
            $koneksi->beginTransaction();
            if(!$countL0){
                
                $stmtInsertL0 = $koneksi->prepare(sprintf($queryInsert, $tableName));
    
                // Bind parameters
                $stmtInsertL0->bindParam(1, $id);
                $stmtInsertL0->bindParam(2, $idkar);
                $stmtInsertL0->bindParam(3, $value1);
                $stmtInsertL0->bindParam(4, $value2);
                $stmtInsertL0->bindParam(5, $value3);
                $stmtInsertL0->bindParam(6, $value4);
                $stmtInsertL0->bindParam(7, $value5);
                $stmtInsertL0->bindParam(8, $score1);
                $stmtInsertL0->bindParam(9, $score2);
                $stmtInsertL0->bindParam(10, $score3);
                $stmtInsertL0->bindParam(11, $score4);
                $stmtInsertL0->bindParam(12, $score5);
                $stmtInsertL0->bindParam(13, $total_score);
                $stmtInsertL0->bindParam(14, $synergized1);
                $stmtInsertL0->bindParam(15, $synergized2);
                $stmtInsertL0->bindParam(16, $synergized3);
                $stmtInsertL0->bindParam(17, $integrity1);
                $stmtInsertL0->bindParam(18, $integrity2);
                $stmtInsertL0->bindParam(19, $integrity3);
                $stmtInsertL0->bindParam(20, $growth1);
                $stmtInsertL0->bindParam(21, $growth2);
                $stmtInsertL0->bindParam(22, $growth3);
                $stmtInsertL0->bindParam(23, $adaptive1);
                $stmtInsertL0->bindParam(24, $adaptive2);
                $stmtInsertL0->bindParam(25, $adaptive3);
                $stmtInsertL0->bindParam(26, $passion1);
                $stmtInsertL0->bindParam(27, $passion2);
                $stmtInsertL0->bindParam(28, $passion3);
                $stmtInsertL0->bindParam(29, $leadership1);
                $stmtInsertL0->bindParam(30, $leadership2);
                $stmtInsertL0->bindParam(31, $leadership3);
                $stmtInsertL0->bindParam(32, $leadership4);
                $stmtInsertL0->bindParam(33, $leadership5);
                $stmtInsertL0->bindParam(34, $leadership6);
                $stmtInsertL0->bindParam(35, $idpic);
                $stmtInsertL0->bindParam(36, $periode);
                $stmtInsertL0->bindParam(37, $total_culture);
                $stmtInsertL0->bindParam(38, $total_leadership);
                $stmtInsertL0->bindParam(39, $empty);
                $stmtInsertL0->bindParam(40, $comment);
                $stmtInsertL0->bindParam(41, $datetime);
                $stmtInsertL0->bindParam(42, $fortable);
                $stmtInsertL0->bindParam(43, $L0);
                $stmtInsertL0->bindParam(44, $idpic);
                $stmtInsertL0->bindParam(45, $approvalStatus);

                // Execute the INSERT statement for the current table
                if (!$stmtInsertL0->execute()) {
                    // If an error occurs, set the $errors variable to true
                    $errors = true;
                }
            }

            foreach ($resultLayer as $row) {
                $id_atasan = $row['id_atasan'];
                $layer = $row['layer'];
                $approvalStatus = $row['id_atasan']==$idpic ? 'Approved' : 'Pending';
            // Loop through each table name and execute the INSERT statement
                // Create a prepared statement with the table name
                $stmtInsert = $koneksi->prepare(sprintf($queryInsert, $tableName));

                // Bind parameters
                $stmtInsert->bindParam(1, $id);
                $stmtInsert->bindParam(2, $idkar);
                $stmtInsert->bindParam(3, $value1);
                $stmtInsert->bindParam(4, $value2);
                $stmtInsert->bindParam(5, $value3);
                $stmtInsert->bindParam(6, $value4);
                $stmtInsert->bindParam(7, $value5);
                $stmtInsert->bindParam(8, $score1);
                $stmtInsert->bindParam(9, $score2);
                $stmtInsert->bindParam(10, $score3);
                $stmtInsert->bindParam(11, $score4);
                $stmtInsert->bindParam(12, $score5);
                $stmtInsert->bindParam(13, $total_score);
                $stmtInsert->bindParam(14, $empty);
                $stmtInsert->bindParam(15, $empty);
                $stmtInsert->bindParam(16, $empty);
                $stmtInsert->bindParam(17, $empty);
                $stmtInsert->bindParam(18, $empty);
                $stmtInsert->bindParam(19, $empty);
                $stmtInsert->bindParam(20, $empty);
                $stmtInsert->bindParam(21, $empty);
                $stmtInsert->bindParam(22, $empty);
                $stmtInsert->bindParam(23, $empty);
                $stmtInsert->bindParam(24, $empty);
                $stmtInsert->bindParam(25, $empty);
                $stmtInsert->bindParam(26, $empty);
                $stmtInsert->bindParam(27, $empty);
                $stmtInsert->bindParam(28, $empty);
                $stmtInsert->bindParam(29, $empty);
                $stmtInsert->bindParam(30, $empty);
                $stmtInsert->bindParam(31, $empty);
                $stmtInsert->bindParam(32, $empty);
                $stmtInsert->bindParam(33, $empty);
                $stmtInsert->bindParam(34, $empty);
                $stmtInsert->bindParam(35, $idpic);
                $stmtInsert->bindParam(36, $periode);
                $stmtInsert->bindParam(37, $empty);
                $stmtInsert->bindParam(38, $empty);
                $stmtInsert->bindParam(39, $empty);
                $stmtInsert->bindParam(40, $comment);
                $stmtInsert->bindParam(41, $datetime);
                $stmtInsert->bindParam(42, $fortable);
                $stmtInsert->bindParam(43, $layer);
                $stmtInsert->bindParam(44, $id_atasan);
                $stmtInsert->bindParam(45, $approvalStatus);

                // Execute the INSERT statement for the current table
                if (!$stmtInsert->execute()) {
                    // If an error occurs, set the $errors variable to true
                    $errors = true;
                }
            } 

                $stmtInsertFin = $koneksi->prepare(sprintf($queryInsertFinal, $tableFinal));

                // Bind parameters
                $stmtInsertFin->bindParam(1, $id);
                $stmtInsertFin->bindParam(2, $idkar);
                $stmtInsertFin->bindParam(3, $value1);
                $stmtInsertFin->bindParam(4, $value2);
                $stmtInsertFin->bindParam(5, $value3);
                $stmtInsertFin->bindParam(6, $value4);
                $stmtInsertFin->bindParam(7, $value5);
                $stmtInsertFin->bindParam(8, $score1);
                $stmtInsertFin->bindParam(9, $score2);
                $stmtInsertFin->bindParam(10, $score3);
                $stmtInsertFin->bindParam(11, $score4);
                $stmtInsertFin->bindParam(12, $score5);
                $stmtInsertFin->bindParam(13, $total_score);
                $stmtInsertFin->bindParam(14, $synergized1);
                $stmtInsertFin->bindParam(15, $synergized2);
                $stmtInsertFin->bindParam(16, $synergized3);
                $stmtInsertFin->bindParam(17, $integrity1);
                $stmtInsertFin->bindParam(18, $integrity2);
                $stmtInsertFin->bindParam(19, $integrity3);
                $stmtInsertFin->bindParam(20, $growth1);
                $stmtInsertFin->bindParam(21, $growth2);
                $stmtInsertFin->bindParam(22, $growth3);
                $stmtInsertFin->bindParam(23, $adaptive1);
                $stmtInsertFin->bindParam(24, $adaptive2);
                $stmtInsertFin->bindParam(25, $adaptive3);
                $stmtInsertFin->bindParam(26, $passion1);
                $stmtInsertFin->bindParam(27, $passion2);
                $stmtInsertFin->bindParam(28, $passion3);
                $stmtInsertFin->bindParam(29, $leadership1);
                $stmtInsertFin->bindParam(30, $leadership2);
                $stmtInsertFin->bindParam(31, $leadership3);
                $stmtInsertFin->bindParam(32, $leadership4);
                $stmtInsertFin->bindParam(33, $leadership5);
                $stmtInsertFin->bindParam(34, $leadership6);
                $stmtInsertFin->bindParam(35, $idpic);
                $stmtInsertFin->bindParam(36, $periode);
                $stmtInsertFin->bindParam(37, $total_culture);
                $stmtInsertFin->bindParam(38, $total_leadership);
                $stmtInsertFin->bindParam(39, $rating);
                $stmtInsertFin->bindParam(40, $comment);
                $stmtInsertFin->bindParam(41, $datetime);
                $stmtInsertFin->bindParam(42, $fortable);
                $stmtInsertFin->bindParam(43, $layerApproval);
                $stmtInsertFin->bindParam(44, $atasanReview);
                $stmtInsertFin->bindParam(45, $resultLRating['id_atasan']);
                $stmtInsertFin->bindParam(46, $resultLRating['layer']);
                $stmtInsertFin->bindParam(47, $approval_review);

                // Execute the INSERT statement for the current table
                if (!$stmtInsertFin->execute()) {
                    // If an error occurs, set the $errors variable to true
                    $errors = true;
                }

            // Commit the transaction if there are no errors
            if (!$errors) {
                $koneksi->commit();
            } else {
                // Rollback the transaction if there are errors
                $koneksi->rollBack();
                echo "An error occurred during data insertion.";
            }
        } catch (PDOException $e) {
            // Handle any exceptions that may occur
            echo "Database Error: " . $e->getMessage();
        }
    // include_once('mail/mailsettings.php');	
            //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            //     $body = "<p>Salam SIGAP, </P> <b>$pic</b> $a16 : <br><br>
            //     <table border = 0>
            //         <tr>
            //             <td>$a2</td>
            //             <td style=\"width:70%;\">: $ckaryawan[Nama_Lengkap]</td>  
            //         </tr>
            //         <tr>
            //             <td>$a4</td>
            //             <td>: $nik</td>  
            //         </tr>
            //         <tr>
            //             <td>$a5</td>
            //             <td>: $ckaryawan[Nama_Departemen]</td>
            //         </tr>
            //         <tr>
            //             <td>$a6</td>
            //             <td>: $ckaryawan[Nama_Jabatan]</td> 
            //         </tr>
            //         <tr>
            //             <td>$a8</td>
            //             <td>: $ckaryawan[tmk]</td>
            //         </tr>
            //         <tr>
            //             <td>$a10</td>
            //             <td>: $ckaryawan[Nama_Golongan]</td>
            //         </tr>
            //         <tr>
            //             <td>$a3</td>
            //             <td  style=\"width:70%;\">: $ckaryawan[Nama_Perusahaan]</td>
            //         </tr>
            //         <tr>					
            //             <td>$a9</td>
            //             <td>: $periode</td>
            //         </tr>
            //         <tr>
            //             <th>&nbsp;</th>
            //             <td>&nbsp;</th> 
            //         </tr>
            //         <tr>
            //             <td>$a14 : </td>
            //             <td colspan=\"3\">http://172.30.1.38:8080/pa</td> 
            //         </tr>
            //     </table>
            //     <br>$a15
                    
            //      ";
                
            //     $mail->Subject = "Penilaian PA ($ckaryawan[Nama_Lengkap])";
                
            //     $mail->MsgHTML($body);
                
            //     // if($nik==$nik_input){
            //     //     if($emailatasan1=='brian@kpn-corp.com' || $emailatasan1=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
            //     //         $mail->AddAddress("eriton.dewa@kpnplantation.com");
            //     //     }else{
            //     //         $mail->AddAddress($emailatasan1);
            //     //     }
            //     // }else if($atasan1==$nik_input){ 
            //     //     if($emailatasan2=='brian@kpn-corp.com' || $emailatasan2=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
            //     //         $mail->AddAddress("eriton.dewa@kpnplantation.com");
            //     //     }else{
            //     //         $mail->AddAddress($emailatasan2);
            //     //     }
            //     // }else{
            //     //     $mail->AddAddress("eriton.dewa@kpnplantation.com");
            //     // }
                
            //     // $mail->AddCC("alfian.azis@cemindo.com");
            //     $mail->AddBCC("alfian.azis@cemindo.com");
            //     if(!$mail->Send()) 
            //     {
            //         // $qinsertactmailerror	= mysqli_query ($koneksi,"insert into activity_mailerror (idactivity, date) values ($iderrornya, now())");
            //         // echo "Mailer Error: " . $mail->ErrorInfo;
                
            //     }
            //     else
            //     {
            //         echo "<script>console.log('email sended')</script>";
            //     } 

            // Assuming $myDataVariable is the data you want to pass
            $myDataVariable = "MyData"; // Replace "YourDataHere" with the actual data you want to send
            // Append the data to the URL using query parameters
            header('Location: home.php?link=mydata&data=' . urlencode($myDataVariable));
            exit;
        } else {
            ?>
            <script>
                window.location='home.php?link=mydata';
                // console.log("Error");
            </script>
            <?php
        }
        
        $stmtInsert->closeCursor();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}else if($code == 'updateNilaiAwal') {
    $idkar = $_POST["idkar"];
    $idpic = $_POST["idpic"];
    $value1 = $_POST["value1"];
    $value2 = $_POST["value2"];
    $value3 = $_POST["value3"];
    $value4 = $_POST["value4"];
    $value5 = $_POST["value5"];
    $score1 = $_POST["score1"];
    $score2 = $_POST["score2"];
    $score3 = $_POST["score3"];
    $score4 = $_POST["score4"];
    $score5 = $_POST["score5"];
    $total_score = $_POST["total_score"];
    $fortable = $_POST["fortable"];
    $periode = 2023;
    $synergized1 = isset($_POST["synergized1"]) ? $_POST["synergized1"] : null;
    $synergized2 = isset($_POST["synergized2"]) ? $_POST["synergized2"] : null;
    $synergized3 = isset($_POST["synergized3"]) ? $_POST["synergized3"] : null;
    $integrity1 = isset($_POST["integrity1"]) ? $_POST["integrity1"] : null;
    $integrity2 = isset($_POST["integrity2"]) ? $_POST["integrity2"] : null;
    $integrity3 = isset($_POST["integrity3"]) ? $_POST["integrity3"] : null;
    $growth1 = isset($_POST["growth1"]) ? $_POST["growth1"] : null;
    $growth2 = isset($_POST["growth2"]) ? $_POST["growth2"] : null;
    $growth3 = isset($_POST["growth3"]) ? $_POST["growth3"] : null;
    $adaptive1 = isset($_POST["adaptive1"]) ? $_POST["adaptive1"] : null;
    $adaptive2 = isset($_POST["adaptive2"]) ? $_POST["adaptive2"] : null;
    $adaptive3 = isset($_POST["adaptive3"]) ? $_POST["adaptive3"] : null;
    $passion1 = isset($_POST["passion1"]) ? $_POST["passion1"] : null;
    $passion2 = isset($_POST["passion2"]) ? $_POST["passion2"] : null;
    $passion3 = isset($_POST["passion3"]) ? $_POST["passion3"] : null;
    $leadership1 = isset($_POST["leadership1"]) ? $_POST["leadership1"] : null;
    $leadership2 = isset($_POST["leadership2"]) ? $_POST["leadership2"] : null;
    $leadership3 = isset($_POST["leadership3"]) ? $_POST["leadership3"] : null;
    $leadership4 = isset($_POST["leadership4"]) ? $_POST["leadership4"] : null;
    $leadership5 = isset($_POST["leadership5"]) ? $_POST["leadership5"] : null;
    $leadership6 = isset($_POST["leadership6"]) ? $_POST["leadership6"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
    $finalAvg = $total_leadership == 0 ? 2 : 3;
    $final_score = floor(number_format(($total_score + $total_culture + $total_leadership) / $finalAvg , 2));
    $rating = $final_score;
    
    $errors = false;

    try {
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Define the SQL query with placeholders
            $sql2023 = "UPDATE %s
                    SET
                        updated_by = :idpic,
                        value_1 = :value1,
                        value_2 = :value2,
                        value_3 = :value3,
                        value_4 = :value4,
                        value_5 = :value5,
                        score_1 = :score1,
                        score_2 = :score2,
                        score_3 = :score3,
                        score_4 = :score4,
                        score_5 = :score5,
                        total_score = :total_score,
                        updated_date = :updated_date,
                        synergized1 = :synergized1,
                        synergized2 = :synergized2,
                        synergized3 = :synergized3,
                        integrity1 = :integrity1,
                        integrity2 = :integrity2,
                        integrity3 = :integrity3,
                        growth1 = :growth1,
                        growth2 = :growth2,
                        growth3 = :growth3,
                        adaptive1 = :adaptive1,
                        adaptive2 = :adaptive2,
                        adaptive3 = :adaptive3,
                        passion1 = :passion1,
                        passion2 = :passion2,
                        passion3 = :passion3,
                        leadership1 = :leadership1,
                        leadership2 = :leadership2,
                        leadership3 = :leadership3,
                        leadership4 = :leadership4,
                        leadership5 = :leadership5,
                        leadership6 = :leadership6,
                        total_culture = :total_culture,
                        total_leadership = :total_leadership,
                        comment = :comment
                    WHERE idkar = :idkar AND approver_id = :idpic";
    
            $sqlFinal = "UPDATE %s
                    SET
                        updated_by = :idpic,
                        value_1 = :value1,
                        value_2 = :value2,
                        value_3 = :value3,
                        value_4 = :value4,
                        value_5 = :value5,
                        score_1 = :score1,
                        score_2 = :score2,
                        score_3 = :score3,
                        score_4 = :score4,
                        score_5 = :score5,
                        total_score = :total_score,
                        updated_date = :updated_date,
                        synergized1 = :synergized1,
                        synergized2 = :synergized2,
                        synergized3 = :synergized3,
                        integrity1 = :integrity1,
                        integrity2 = :integrity2,
                        integrity3 = :integrity3,
                        growth1 = :growth1,
                        growth2 = :growth2,
                        growth3 = :growth3,
                        adaptive1 = :adaptive1,
                        adaptive2 = :adaptive2,
                        adaptive3 = :adaptive3,
                        passion1 = :passion1,
                        passion2 = :passion2,
                        passion3 = :passion3,
                        leadership1 = :leadership1,
                        leadership2 = :leadership2,
                        leadership3 = :leadership3,
                        leadership4 = :leadership4,
                        leadership5 = :leadership5,
                        leadership6 = :leadership6,
                        total_culture = :total_culture,
                        total_leadership = :total_leadership,
                        comment = :comment
                    WHERE idkar = :idkar";
        
            $table2023 = 'transaksi_2023';
            $tableFinal = 'transaksi_2023_final';
        
            // Create a prepared statement for each table
            $stmt2023 = $koneksi->prepare(sprintf($sql2023, $table2023));
            $stmtFinal = $koneksi->prepare(sprintf($sqlFinal, $tableFinal));
        
            // Bind the common parameters (used in both statements)
            $commonParams = [
                ':idpic' => $idpic,
                ':value1' => $value1,
                ':value2' => $value2,
                ':value3' => $value3,
                ':value4' => $value4,
                ':value5' => $value5,
                ':score1' => $score1,
                ':score2' => $score2,
                ':score3' => $score3,
                ':score4' => $score4,
                ':score5' => $score5,
                ':total_score' => $total_score,
                ':updated_date' => $datetime,
                ':synergized1' => $synergized1,
                ':synergized2' => $synergized2,
                ':synergized3' => $synergized3,
                ':integrity1' => $integrity1,
                ':integrity2' => $integrity2,
                ':integrity3' => $integrity3,
                ':growth1' => $growth1,
                ':growth2' => $growth2,
                ':growth3' => $growth3,
                ':adaptive1' => $adaptive1,
                ':adaptive2' => $adaptive2,
                ':adaptive3' => $adaptive3,
                ':passion1' => $passion1,
                ':passion2' => $passion2,
                ':passion3' => $passion3,
                ':leadership1' => $leadership1,
                ':leadership2' => $leadership2,
                ':leadership3' => $leadership3,
                ':leadership4' => $leadership4,
                ':leadership5' => $leadership5,
                ':leadership6' => $leadership6,
                ':total_culture' => $total_culture,
                ':total_leadership' => $total_leadership,
                ':comment' => $comment,
                ':idkar' => $idkar,
            ];
        

        // Bind the common parameters to both statements
        $stmt2023->execute($commonParams);
        $stmtFinal->execute($commonParams);
    
        // Check for errors
        $errors = !$stmt2023->rowCount() || !$stmtFinal->rowCount();
    
        if (!$errors) {
            $koneksi->commit();
            header('Location: home.php?link=mydata');
            exit;
        } else {
            echo "Error";
            header('Location: home.php?link=mydata');
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }    

}else if($code == 'submitReviewA1') {

    try {
        $idkar = $_POST["idkar"];
        $idpic = $_POST["idpic"];
        $value1 = $_POST["value1"];
        $value2 = $_POST["value2"];
        $value3 = $_POST["value3"];
        $value4 = $_POST["value4"];
        $value5 = $_POST["value5"];
        $score1 = $_POST["score1"];
        $score2 = $_POST["score2"];
        $score3 = $_POST["score3"];
        $score4 = $_POST["score4"];
        $score5 = $_POST["score5"];
        $total_score = $_POST["total_score"];
        $fortable = $_POST["fortable"];
        $periode = 2023;
        $synergized1 = floatval(isset($_POST["synergized1"]) ? $_POST["synergized1"] : 0);
        $synergized2 = floatval(isset($_POST["synergized2"]) ? $_POST["synergized2"] : 0);
        $synergized3 = floatval(isset($_POST["synergized3"]) ? $_POST["synergized3"] : 0);
        $integrity1 = floatval(isset($_POST["integrity1"]) ? $_POST["integrity1"] : 0);
        $integrity2 = floatval(isset($_POST["integrity2"]) ? $_POST["integrity2"] : 0);
        $integrity3 = floatval(isset($_POST["integrity3"]) ? $_POST["integrity3"] : 0);
        $growth1 = floatval(isset($_POST["growth1"]) ? $_POST["growth1"] : 0);
        $growth2 = floatval(isset($_POST["growth2"]) ? $_POST["growth2"] : 0);
        $growth3 = floatval(isset($_POST["growth3"]) ? $_POST["growth3"] : 0);
        $adaptive1 = floatval(isset($_POST["adaptive1"]) ? $_POST["adaptive1"] : 0);
        $adaptive2 = floatval(isset($_POST["adaptive2"]) ? $_POST["adaptive2"] : 0);
        $adaptive3 = floatval(isset($_POST["adaptive3"]) ? $_POST["adaptive3"] : 0);
        $passion1 = floatval(isset($_POST["passion1"]) ? $_POST["passion1"] : 0);
        $passion2 = floatval(isset($_POST["passion2"]) ? $_POST["passion2"] : 0);
        $passion3 = floatval(isset($_POST["passion3"]) ? $_POST["passion3"] : 0);
        $leadership1 = floatval(isset($_POST["leadership1"]) ? $_POST["leadership1"] : 0);
        $leadership2 = floatval(isset($_POST["leadership2"]) ? $_POST["leadership2"] : 0);
        $leadership3 = floatval(isset($_POST["leadership3"]) ? $_POST["leadership3"] : 0);
        $leadership4 = floatval(isset($_POST["leadership4"]) ? $_POST["leadership4"] : 0);
        $leadership5 = floatval(isset($_POST["leadership5"]) ? $_POST["leadership5"] : 0);
        $leadership6 = floatval(isset($_POST["leadership6"]) ? $_POST["leadership6"] : 0);
        $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;
        
        $layer = isset($_POST["layer"]) ? $_POST["layer"] : null;
        $next_approver_level = "L" . (intval(substr($layer, 1)) + 1);
        $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
        $avg = $leadership6 == 0 ? 5 : 6;
        $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
        $finalAvg = $total_leadership == 0 ? 2 : 3;
        $final_score = floor(number_format(($total_score + $total_culture + $total_leadership) / $finalAvg , 2));
    
        $checkLayer = "SELECT * FROM atasan WHERE idkar = :id AND id = (SELECT id + 1 FROM atasan WHERE idkar = :id AND id_atasan = :idpic)";
    
        $stmt1 = $koneksi->prepare($checkLayer);
        $stmt1->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmt1->bindParam(':idpic', $idpic, PDO::PARAM_INT);
        $stmt1->execute();
    
        $resultLayer = $stmt1->fetch(PDO::FETCH_ASSOC);

        $cekKpiAtasan = "SELECT a.layer, a.id_atasan, b.kpi_unit
        FROM atasan a
        LEFT JOIN kpi_unit_2023 b ON b.idkar=a.id_atasan
        WHERE a.idkar=:id AND a.layer=:next_approver_level";
        
        $stmtCekKpiAtasan = $koneksi->prepare($cekKpiAtasan);
        $stmtCekKpiAtasan->bindParam(':next_approver_level', $next_approver_level, PDO::PARAM_INT);
        $stmtCekKpiAtasan->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmtCekKpiAtasan->execute();

        $resultKpiAtasan = $stmtCekKpiAtasan->fetch(PDO::FETCH_ASSOC);
        $countKpiAtasan = $stmtCekKpiAtasan->rowCount();

        $cekLevelReviewWithRating = "SELECT a.layer, a.id_atasan, b.kpi_unit
        FROM atasan a
        LEFT JOIN kpi_unit_2023 b ON b.idkar=a.id_atasan
        WHERE a.idkar=:id AND b.kpi_unit!='' ORDER BY a.id ASC LIMIT 1";
        
        $stmtLevelReviewWithRating = $koneksi->prepare($cekLevelReviewWithRating);
        $stmtLevelReviewWithRating->bindParam(':id', $idkar, PDO::PARAM_INT);
        $stmtLevelReviewWithRating->execute();

        $resultLevelReviewWithRating = $stmtLevelReviewWithRating->fetch(PDO::FETCH_ASSOC);

        $rating = $countKpiAtasan ? $final_score : null;
        $id_review = $countKpiAtasan ? ($resultKpiAtasan['kpi_unit'] ? $resultKpiAtasan['id_atasan'] : $idpic) : $idpic;
        $layers = $countKpiAtasan ? ($resultKpiAtasan['kpi_unit'] ? $resultKpiAtasan['layer'] : $layer) : $layer;
        $approval_review = $resultLevelReviewWithRating['id_atasan']==$idpic ? 'Pending' : 'Approved';

        // Additional code for other queries and data manipulation...
    
        try {
            $koneksi->beginTransaction();
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $update2023 = "UPDATE transaksi_2023 SET
                        value_1 = :value1,
                        value_2 = :value2,
                        value_3 = :value3,
                        value_4 = :value4,
                        value_5 = :value5,
                        score_1 = :score1,
                        score_2 = :score2,
                        score_3 = :score3,
                        score_4 = :score4,
                        score_5 = :score5,
                        total_score = :total_score,
                        synergized1 = :synergized1,
                        synergized2 = :synergized2,
                        synergized3 = :synergized3,
                        integrity1 = :integrity1,
                        integrity2 = :integrity2,
                        integrity3 = :integrity3,
                        growth1 = :growth1,
                        growth2 = :growth2,
                        growth3 = :growth3,
                        adaptive1 = :adaptive1,
                        adaptive2 = :adaptive2,
                        adaptive3 = :adaptive3,
                        passion1 = :passion1,
                        passion2 = :passion2,
                        passion3 = :passion3,
                        leadership1 = :leadership1,
                        leadership2 = :leadership2,
                        leadership3 = :leadership3,
                        leadership4 = :leadership4,
                        leadership5 = :leadership5,
                        leadership6 = :leadership6,
                        total_culture = :total_culture,
                        total_leadership = :total_leadership,
                        comment = :comment,
                        updated_by = :idpic,
                        updated_date = :updated_date,
                        approval_status = :approval_status
                        WHERE idkar = :idkar AND approver_id = :idpic";

            $stmtUpdate2023 = $koneksi->prepare($update2023);
        
            $stmtUpdate2023->bindParam(':value1', $value1);
            $stmtUpdate2023->bindParam(':value2', $value2);
            $stmtUpdate2023->bindParam(':value3', $value3);
            $stmtUpdate2023->bindParam(':value4', $value4);
            $stmtUpdate2023->bindParam(':value5', $value5);
            $stmtUpdate2023->bindParam(':score1', $score1);
            $stmtUpdate2023->bindParam(':score2', $score2);
            $stmtUpdate2023->bindParam(':score3', $score3);
            $stmtUpdate2023->bindParam(':score4', $score4);
            $stmtUpdate2023->bindParam(':score5', $score5);
            $stmtUpdate2023->bindParam(':total_score', $total_score);
            $stmtUpdate2023->bindParam(':synergized1', $synergized1);
            $stmtUpdate2023->bindParam(':synergized2', $synergized2);
            $stmtUpdate2023->bindParam(':synergized3', $synergized3);
            $stmtUpdate2023->bindParam(':integrity1', $integrity1);
            $stmtUpdate2023->bindParam(':integrity2', $integrity2);
            $stmtUpdate2023->bindParam(':integrity3', $integrity3);
            $stmtUpdate2023->bindParam(':growth1', $growth1);
            $stmtUpdate2023->bindParam(':growth2', $growth2);
            $stmtUpdate2023->bindParam(':growth3', $growth3);
            $stmtUpdate2023->bindParam(':adaptive1', $adaptive1);
            $stmtUpdate2023->bindParam(':adaptive2', $adaptive2);
            $stmtUpdate2023->bindParam(':adaptive3', $adaptive3);
            $stmtUpdate2023->bindParam(':passion1', $passion1);
            $stmtUpdate2023->bindParam(':passion2', $passion2);
            $stmtUpdate2023->bindParam(':passion3', $passion3);
            $stmtUpdate2023->bindParam(':leadership1', $leadership1);
            $stmtUpdate2023->bindParam(':leadership2', $leadership2);
            $stmtUpdate2023->bindParam(':leadership3', $leadership3);
            $stmtUpdate2023->bindParam(':leadership4', $leadership4);
            $stmtUpdate2023->bindParam(':leadership5', $leadership5);
            $stmtUpdate2023->bindParam(':leadership6', $leadership6);
            $stmtUpdate2023->bindParam(':total_culture', $total_culture);
            $stmtUpdate2023->bindParam(':total_leadership', $total_leadership);
            $stmtUpdate2023->bindParam(':comment', $comment);
            $stmtUpdate2023->bindParam(':idpic', $idpic);
            $stmtUpdate2023->bindParam(':updated_date', $datetime);
            $stmtUpdate2023->bindParam(':approval_status', $approval_review);
            $stmtUpdate2023->bindParam(':idkar', $idkar);
        
            $stmtUpdate2023->execute();

            $updateFinal = "UPDATE transaksi_2023_final SET
                        value_1 = :value1,
                        value_2 = :value2,
                        value_3 = :value3,
                        value_4 = :value4,
                        value_5 = :value5,
                        score_1 = :score1,
                        score_2 = :score2,
                        score_3 = :score3,
                        score_4 = :score4,
                        score_5 = :score5,
                        total_score = :total_score,
                        synergized1 = :synergized1,
                        synergized2 = :synergized2,
                        synergized3 = :synergized3,
                        integrity1 = :integrity1,
                        integrity2 = :integrity2,
                        integrity3 = :integrity3,
                        growth1 = :growth1,
                        growth2 = :growth2,
                        growth3 = :growth3,
                        adaptive1 = :adaptive1,
                        adaptive2 = :adaptive2,
                        adaptive3 = :adaptive3,
                        passion1 = :passion1,
                        passion2 = :passion2,
                        passion3 = :passion3,
                        leadership1 = :leadership1,
                        leadership2 = :leadership2,
                        leadership3 = :leadership3,
                        leadership4 = :leadership4,
                        leadership5 = :leadership5,
                        leadership6 = :leadership6,
                        total_culture = :total_culture,
                        total_leadership = :total_leadership,
                        approval_review = :approval_review,
                        rating = :rating,
                        comment = :comment,
                        approver_review_id = :id_review,
                        layer = :layer,
                        updated_by = :idpic,
                        updated_date = :updated_date
                        WHERE idkar = :idkar";

            $stmtUpdateFinal = $koneksi->prepare($updateFinal);
    
            $stmtUpdateFinal->bindParam(':value1', $value1);
            $stmtUpdateFinal->bindParam(':value2', $value2);
            $stmtUpdateFinal->bindParam(':value3', $value3);
            $stmtUpdateFinal->bindParam(':value4', $value4);
            $stmtUpdateFinal->bindParam(':value5', $value5);
            $stmtUpdateFinal->bindParam(':score1', $score1);
            $stmtUpdateFinal->bindParam(':score2', $score2);
            $stmtUpdateFinal->bindParam(':score3', $score3);
            $stmtUpdateFinal->bindParam(':score4', $score4);
            $stmtUpdateFinal->bindParam(':score5', $score5);
            $stmtUpdateFinal->bindParam(':total_score', $total_score);
            $stmtUpdateFinal->bindParam(':synergized1', $synergized1);
            $stmtUpdateFinal->bindParam(':synergized2', $synergized2);
            $stmtUpdateFinal->bindParam(':synergized3', $synergized3);
            $stmtUpdateFinal->bindParam(':integrity1', $integrity1);
            $stmtUpdateFinal->bindParam(':integrity2', $integrity2);
            $stmtUpdateFinal->bindParam(':integrity3', $integrity3);
            $stmtUpdateFinal->bindParam(':growth1', $growth1);
            $stmtUpdateFinal->bindParam(':growth2', $growth2);
            $stmtUpdateFinal->bindParam(':growth3', $growth3);
            $stmtUpdateFinal->bindParam(':adaptive1', $adaptive1);
            $stmtUpdateFinal->bindParam(':adaptive2', $adaptive2);
            $stmtUpdateFinal->bindParam(':adaptive3', $adaptive3);
            $stmtUpdateFinal->bindParam(':passion1', $passion1);
            $stmtUpdateFinal->bindParam(':passion2', $passion2);
            $stmtUpdateFinal->bindParam(':passion3', $passion3);
            $stmtUpdateFinal->bindParam(':leadership1', $leadership1);
            $stmtUpdateFinal->bindParam(':leadership2', $leadership2);
            $stmtUpdateFinal->bindParam(':leadership3', $leadership3);
            $stmtUpdateFinal->bindParam(':leadership4', $leadership4);
            $stmtUpdateFinal->bindParam(':leadership5', $leadership5);
            $stmtUpdateFinal->bindParam(':leadership6', $leadership6);
            $stmtUpdateFinal->bindParam(':total_culture', $total_culture);
            $stmtUpdateFinal->bindParam(':total_leadership', $total_leadership);
            $stmtUpdateFinal->bindParam(':approval_review', $approval_review);
            $stmtUpdateFinal->bindParam(':rating', $rating);
            $stmtUpdateFinal->bindParam(':comment', $comment);
            $stmtUpdateFinal->bindParam(':id_review', $id_review);
            $stmtUpdateFinal->bindParam(':layer', $layers);
            $stmtUpdateFinal->bindParam(':idkar', $idkar);
            $stmtUpdateFinal->bindParam(':idpic', $idpic);
            $stmtUpdateFinal->bindParam(':updated_date', $datetime);

        
            $stmtUpdateFinal->execute();

            $koneksi->commit();
            
            echo "<script>
                    window.location='home.php?link=mydata';
                    console.log('Data submitted successfully!');
                    </script>";
        } catch (PDOException $e) {
            $koneksi->rollBack();
            echo '<script>console.log("Error: ' . $e->getMessage() . '");</script>';
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}else if($code == 'getDataEditAwal') {
    // Initialize an empty response array
    $response = array();

    // Check if the HTTP method is GET
        // Perform your database query here
        try {
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Example query: Select all data from a table named 'your_table'
            $query = "SELECT a.*, DATE_FORMAT(b.mulai_bekerja, '%d-%m-%Y') AS tmk, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, c.fortable, d.Nama_OU, e.Nama_Departemen, f.Nama_Perusahaan, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan = :id AND layer='L1') as jumlah_subo 
            FROM transaksi_2023_final AS a 
            LEFT JOIN $karyawan AS b ON b.id = a.idkar 
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
            LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
            LEFT JOIN daftarperusahaan AS f ON f.Kode_Perusahaan = b.Kode_Perusahaan
            WHERE a.idkar= :id";
            $stmt = $koneksi->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch data as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $selectedResult = array();
            foreach ($result as $item) {
                
                $selectedResult[] = array(
                    'id' => $item['id'],
                    'idkar' => $item['idkar'],
                    'created_by' => $item['created_by'],
                    'total_score' => $item['total_score'],
                    'periode' => $item['periode'],
                    'tmk' => $item['tmk'],
                    'NIK' => $item['NIK'],
                    'nik_baru' => $item['nik_baru'],
                    'Nama_Lengkap' => $item['Nama_Lengkap'],
                    'Nama_Jabatan' => $item['Nama_Jabatan'],
                    'Nama_Golongan' => $item['Nama_Golongan'],
                    'Nama_OU' => $item['Nama_OU'],
                    'Nama_Departemen' => $item['Nama_Departemen'],
                    'Nama_Perusahaan' => $item['Nama_Perusahaan'],
                    'jumlah_subo' => $item['jumlah_subo'],
                    'fortable' => $item['fortable'],
                    'comment' => $item['comment'],
                    'rating' => $item['rating'],
                    'objective' => array(
                        'value1' => $item['value_1'],
                        'value2' => $item['value_2'],
                        'value3' => $item['value_3'],
                        'value4' => $item['value_4'],
                        'value5' => $item['value_5']
                    ),
                    'score' => array(
                        'score1' => $item['score_1'],
                        'score2' => $item['score_2'],
                        'score3' => $item['score_3'],
                        'score4' => $item['score_4'],
                        'score5' => $item['score_5']
                    ),
                    'culture' => array(
                        'synergized1' => $item['synergized1'],
                        'synergized2' => $item['synergized2'],
                        'synergized3' => $item['synergized3'],
                        'integrity1' => $item['integrity1'],
                        'integrity2' => $item['integrity2'],
                        'integrity3' => $item['integrity3'],
                        'growth1' => $item['growth1'],
                        'growth2' => $item['growth2'],
                        'growth3' => $item['growth3'],
                        'adaptive1' => $item['adaptive1'],
                        'adaptive2' => $item['adaptive2'],
                        'adaptive3' => $item['adaptive3'],
                        'passion1' => $item['passion1'],
                        'passion2' => $item['passion2'],
                        'passion3' => $item['passion3'],
                    ),
                    'leadership' => array(
                        'leadership1' => $item['leadership1'],
                        'leadership2' => $item['leadership2'],
                        'leadership3' => $item['leadership3'],
                        'leadership4' => $item['leadership4'],
                        'leadership5' => $item['leadership5'],
                        'leadership6' => $item['leadership6'],                        
                    ),
                );
            }

            // Add the filtered result to the response array
            $response['data'] = $selectedResult;
        
        } catch (PDOException $e) {
            // Handle database errors here
            $response['error'] = 'Database error: ' . $e->getMessage();
        }

    // Convert the response array to JSON and output it
    header('Content-Type: application/json');
    echo json_encode($response);
}else if($code == 'getDataReview') {
    // Initialize an empty response array
    $response = array();

    // Check if the HTTP method is GET
        // Perform your database query here
        try {
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Example query: Select all data from a table named 'your_table'
            $query = "SELECT trf.*, DATE_FORMAT(b.mulai_bekerja, '%d-%m-%Y') AS tmk, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, c.fortable, d.Nama_OU, e.Nama_Departemen, f.Nama_Perusahaan, DATE_FORMAT(trf.created_date, '%d-%m-%Y') AS created_date, 
            (SELECT COUNT(idkar) FROM atasan WHERE id_atasan = :id AND layer='L1') AS jumlah_subo, 
            a1.id_atasan AS id_atasan1, a2.id_atasan AS id_atasan2, a3.id_atasan AS id_atasan3, ka1.Nama_Lengkap AS nama_a1, ka2.Nama_Lengkap AS nama_a2, ka3.Nama_Lengkap AS nama_a3
            FROM transaksi_2023_final AS trf
            LEFT JOIN transaksi_2023 AS tr ON tr.idkar=trf.idkar
            LEFT JOIN karyawan_2023 AS b ON b.id = trf.idkar
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan
            LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
            LEFT JOIN daftarperusahaan AS f ON f.Kode_Perusahaan = b.Kode_Perusahaan
            LEFT JOIN atasan AS a1 ON a1.idkar=trf.idkar AND a1.layer='L1'
            LEFT JOIN karyawan_2023 AS ka1 ON ka1.id=a1.id_atasan
            LEFT JOIN atasan AS a2 ON a2.idkar=trf.idkar AND a2.layer='L2'
            LEFT JOIN karyawan_2023 AS ka2 ON ka2.id=a2.id_atasan
            LEFT JOIN atasan AS a3 ON a3.idkar=trf.idkar AND a3.layer='L3'
            LEFT JOIN karyawan_2023 AS ka3 ON ka3.id=a3.id_atasan
            WHERE trf.idkar= :id
            GROUP BY trf.idkar";
            $stmt = $koneksi->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Fetch data as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $selectedResult = array();
            foreach ($result as $item) {
                
                $selectedResult[] = array(
                    'id' => $item['id'],
                    'idkar' => $item['idkar'],
                    'total_score' => $item['total_score'],
                    'periode' => $item['periode'],
                    'tmk' => $item['tmk'],
                    'NIK' => $item['NIK'],
                    'nik_baru' => $item['nik_baru'],
                    'Nama_Lengkap' => $item['Nama_Lengkap'],
                    'Nama_Jabatan' => $item['Nama_Jabatan'],
                    'Nama_Golongan' => $item['Nama_Golongan'],
                    'Nama_OU' => $item['Nama_OU'],
                    'Nama_Departemen' => $item['Nama_Departemen'],
                    'Nama_Perusahaan' => $item['Nama_Perusahaan'],
                    'jumlah_subo' => $item['jumlah_subo'],
                    'fortable' => $item['fortable'],
                    'comment' => $item['comment'],
                    'rating' => $item['rating'],
                    'id_atasan1' => $item['id_atasan1'],
                    'nama_a1' => $item['nama_a1'],
                    'id_atasan2' => $item['id_atasan2'],
                    'nama_a2' => $item['nama_a2'],
                    'id_atasan3' => $item['id_atasan3'],
                    'nama_a3' => $item['nama_a3'],
                    'updated_by' => $item['updated_by'],
                    'objective' => array(
                        'value1' => $item['value_1'],
                        'value2' => $item['value_2'],
                        'value3' => $item['value_3'],
                        'value4' => $item['value_4'],
                        'value5' => $item['value_5']
                    ),
                    'score' => array(
                        'score1' => $item['score_1'],
                        'score2' => $item['score_2'],
                        'score3' => $item['score_3'],
                        'score4' => $item['score_4'],
                        'score5' => $item['score_5']
                    ),
                    'culture' => array(
                        'synergized1' => $item['synergized1'],
                        'synergized2' => $item['synergized2'],
                        'synergized3' => $item['synergized3'],
                        'integrity1' => $item['integrity1'],
                        'integrity2' => $item['integrity2'],
                        'integrity3' => $item['integrity3'],
                        'growth1' => $item['growth1'],
                        'growth2' => $item['growth2'],
                        'growth3' => $item['growth3'],
                        'adaptive1' => $item['adaptive1'],
                        'adaptive2' => $item['adaptive2'],
                        'adaptive3' => $item['adaptive3'],
                        'passion1' => $item['passion1'],
                        'passion2' => $item['passion2'],
                        'passion3' => $item['passion3'],
                    ),
                    'leadership' => array(
                        'leadership1' => $item['leadership1'],
                        'leadership2' => $item['leadership2'],
                        'leadership3' => $item['leadership3'],
                        'leadership4' => $item['leadership4'],
                        'leadership5' => $item['leadership5'],
                        'leadership6' => $item['leadership6'],                        
                    ),
                );
            }

            // Add the filtered result to the response array
            $response['data'] = $selectedResult;
        
        } catch (PDOException $e) {
            // Handle database errors here
            $response['error'] = 'Database error: ' . $e->getMessage();
        }

    // Convert the response array to JSON and output it
    header('Content-Type: application/json');
    echo json_encode($response);

}else if($code == 'submitReviewSuperior') {
    $pic = $_POST["pic"];
    $idpic = $_POST["idpic"];
    $idkar = $_POST["idkar"];
    $value1 = isset($_POST["value1"]) ? $_POST["value1"] : 0;
    $value2 = isset($_POST["value2"]) ? $_POST["value2"] : 0;
    $value3 = isset($_POST["value3"]) ? $_POST["value3"] : 0;
    $value4 = isset($_POST["value4"]) ? $_POST["value4"] : 0;
    $value5 = isset($_POST["value5"]) ? $_POST["value5"] : 0;
    $score1 = isset($_POST["score1"]) ? $_POST["score1"] : 0;
    $score2 = isset($_POST["score2"]) ? $_POST["score2"] : 0;
    $score3 = isset($_POST["score3"]) ? $_POST["score3"] : 0;
    $score4 = isset($_POST["score4"]) ? $_POST["score4"] : 0;
    $score5 = isset($_POST["score5"]) ? $_POST["score5"] : 0;
    $total_score = isset($_POST["total_score"]) ? $_POST["total_score"] : 0;
    $fortable = $_POST["fortable"];
    $periode = 2023;
    $synergized1 = floatval(isset($_POST["synergized1"]) ? $_POST["synergized1"] : 0);
    $synergized2 = floatval(isset($_POST["synergized2"]) ? $_POST["synergized2"] : 0);
    $synergized3 = floatval(isset($_POST["synergized3"]) ? $_POST["synergized3"] : 0);
    $integrity1 = floatval(isset($_POST["integrity1"]) ? $_POST["integrity1"] : 0);
    $integrity2 = floatval(isset($_POST["integrity2"]) ? $_POST["integrity2"] : 0);
    $integrity3 = floatval(isset($_POST["integrity3"]) ? $_POST["integrity3"] : 0);
    $growth1 = floatval(isset($_POST["growth1"]) ? $_POST["growth1"] : 0);
    $growth2 = floatval(isset($_POST["growth2"]) ? $_POST["growth2"] : 0);
    $growth3 = floatval(isset($_POST["growth3"]) ? $_POST["growth3"] : 0);
    $adaptive1 = floatval(isset($_POST["adaptive1"]) ? $_POST["adaptive1"] : 0);
    $adaptive2 = floatval(isset($_POST["adaptive2"]) ? $_POST["adaptive2"] : 0);
    $adaptive3 = floatval(isset($_POST["adaptive3"]) ? $_POST["adaptive3"] : 0);
    $passion1 = floatval(isset($_POST["passion1"]) ? $_POST["passion1"] : 0);
    $passion2 = floatval(isset($_POST["passion2"]) ? $_POST["passion2"] : 0);
    $passion3 = floatval(isset($_POST["passion3"]) ? $_POST["passion3"] : 0);
    $leadership1 = floatval(isset($_POST["leadership1"]) ? $_POST["leadership1"] : 0);
    $leadership2 = floatval(isset($_POST["leadership2"]) ? $_POST["leadership2"] : 0);
    $leadership3 = floatval(isset($_POST["leadership3"]) ? $_POST["leadership3"] : 0);
    $leadership4 = floatval(isset($_POST["leadership4"]) ? $_POST["leadership4"] : 0);
    $leadership5 = floatval(isset($_POST["leadership5"]) ? $_POST["leadership5"] : 0);
    $leadership6 = floatval(isset($_POST["leadership6"]) ? $_POST["leadership6"] : 0);
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;
    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
    $rating = $idkar == $idpic ? (isset($_POST["rating"]) ? $_POST["rating"] : 0) : $total_score;

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score FROM transaksi_2023_subo AS a WHERE a.created_by='$idpic'";

        $result = $koneksi->query($sql);

        if ($result) {
            $employees = $result->fetchAll(PDO::FETCH_ASSOC);
            $employee_available =  count($employees);

        } else {
            echo "<script>console.log('Error : data not found')</script>";
        }
    } catch (PDOException $e) {
        echo "error", $e->getMessage();
    }

    try {

        if (!$employee_available) {
            // Process the data here
            // Define the common SQL INSERT statement
        $queryInsert = "INSERT INTO transaksi_2023_subo (idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, created_by, periode, total_culture, total_leadership, rating, `comment`, created_date, fortable) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $koneksi->beginTransaction();

            // Create a prepared statement with the table name
            $stmtInsert = $koneksi->prepare($queryInsert);

            // Bind parameters
            $stmtInsert->bindParam(1, $idkar);
            $stmtInsert->bindParam(2, $value1);
            $stmtInsert->bindParam(3, $value2);
            $stmtInsert->bindParam(4, $value3);
            $stmtInsert->bindParam(5, $value4);
            $stmtInsert->bindParam(6, $value5);
            $stmtInsert->bindParam(7, $score1);
            $stmtInsert->bindParam(8, $score2);
            $stmtInsert->bindParam(9, $score3);
            $stmtInsert->bindParam(10, $score4);
            $stmtInsert->bindParam(11, $score5);
            $stmtInsert->bindParam(12, $total_score);
            $stmtInsert->bindParam(13, $synergized1);
            $stmtInsert->bindParam(14, $synergized2);
            $stmtInsert->bindParam(15, $synergized3);
            $stmtInsert->bindParam(16, $integrity1);
            $stmtInsert->bindParam(17, $integrity2);
            $stmtInsert->bindParam(18, $integrity3);
            $stmtInsert->bindParam(19, $growth1);
            $stmtInsert->bindParam(20, $growth2);
            $stmtInsert->bindParam(21, $growth3);
            $stmtInsert->bindParam(22, $adaptive1);
            $stmtInsert->bindParam(23, $adaptive2);
            $stmtInsert->bindParam(24, $adaptive3);
            $stmtInsert->bindParam(25, $passion1);
            $stmtInsert->bindParam(26, $passion2);
            $stmtInsert->bindParam(27, $passion3);
            $stmtInsert->bindParam(28, $leadership1);
            $stmtInsert->bindParam(29, $leadership2);
            $stmtInsert->bindParam(30, $leadership3);
            $stmtInsert->bindParam(31, $leadership4);
            $stmtInsert->bindParam(32, $leadership5);
            $stmtInsert->bindParam(33, $leadership6);
            $stmtInsert->bindParam(34, $idpic);
            $stmtInsert->bindParam(35, $periode);
            $stmtInsert->bindParam(36, $total_culture);
            $stmtInsert->bindParam(37, $total_leadership);
            $stmtInsert->bindParam(38, $rating);
            $stmtInsert->bindParam(39, $comment);
            $stmtInsert->bindParam(40, $datetime);
            $stmtInsert->bindParam(41, $fortable);

            // Execute the INSERT statement for the current table
            if ($stmtInsert->execute()) {
                // If an error occurs, set the $errors variable to true
                $koneksi->commit();
            }

            ?>
            <script>
                window.location='home.php?link=mydata';
                // console.log("Data created successfully!");
            </script>
            <?php
            $stmtInsert->closeCursor();
        } else {
            ?>
            <script>
                window.location='home.php?link=mydata';
                // console.log("Karyawan telah menilai superiornya");
            </script>
            <?php
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}else if($code == 'submitReviewPeers') {
    $pic = $_POST["pic"];
    $idpic = $_POST["idpic"];
    $idkar = $_POST["idkar"];
    $synergized1 = floatval(isset($_POST["synergized1"]) ? $_POST["synergized1"] : 0);
    $synergized2 = floatval(isset($_POST["synergized2"]) ? $_POST["synergized2"] : 0);
    $synergized3 = floatval(isset($_POST["synergized3"]) ? $_POST["synergized3"] : 0);
    $integrity1 = floatval(isset($_POST["integrity1"]) ? $_POST["integrity1"] : 0);
    $integrity2 = floatval(isset($_POST["integrity2"]) ? $_POST["integrity2"] : 0);
    $integrity3 = floatval(isset($_POST["integrity3"]) ? $_POST["integrity3"] : 0);
    $growth1 = floatval(isset($_POST["growth1"]) ? $_POST["growth1"] : 0);
    $growth2 = floatval(isset($_POST["growth2"]) ? $_POST["growth2"] : 0);
    $growth3 = floatval(isset($_POST["growth3"]) ? $_POST["growth3"] : 0);
    $adaptive1 = floatval(isset($_POST["adaptive1"]) ? $_POST["adaptive1"] : 0);
    $adaptive2 = floatval(isset($_POST["adaptive2"]) ? $_POST["adaptive2"] : 0);
    $adaptive3 = floatval(isset($_POST["adaptive3"]) ? $_POST["adaptive3"] : 0);
    $passion1 = floatval(isset($_POST["passion1"]) ? $_POST["passion1"] : 0);
    $passion2 = floatval(isset($_POST["passion2"]) ? $_POST["passion2"] : 0);
    $passion3 = floatval(isset($_POST["passion3"]) ? $_POST["passion3"] : 0);
    $leadership1 = floatval(isset($_POST["leadership1"]) ? $_POST["leadership1"] : 0);
    $leadership2 = floatval(isset($_POST["leadership2"]) ? $_POST["leadership2"] : 0);
    $leadership3 = floatval(isset($_POST["leadership3"]) ? $_POST["leadership3"] : 0);
    $leadership4 = floatval(isset($_POST["leadership4"]) ? $_POST["leadership4"] : 0);
    $leadership5 = floatval(isset($_POST["leadership5"]) ? $_POST["leadership5"] : 0);
    $leadership6 = floatval(isset($_POST["leadership6"]) ? $_POST["leadership6"] : 0);
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;
    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);

    try {

            // Process the data here
            $updateQuery = "UPDATE transaksi_2023_peers SET
            updated_by = :idpic,
            updated_date = :updated_date,
            synergized1 = :synergized1,
            synergized2 = :synergized2,
            synergized3 = :synergized3,
            integrity1 = :integrity1,
            integrity2 = :integrity2,
            integrity3 = :integrity3,
            growth1 = :growth1,
            growth2 = :growth2,
            growth3 = :growth3,
            adaptive1 = :adaptive1,
            adaptive2 = :adaptive2,
            adaptive3 = :adaptive3,
            passion1 = :passion1,
            passion2 = :passion2,
            passion3 = :passion3,
            leadership1 = :leadership1,
            leadership2 = :leadership2,
            leadership3 = :leadership3,
            leadership4 = :leadership4,
            leadership5 = :leadership5,
            leadership6 = :leadership6,
            leadership6 = :leadership6,
            total_culture = :total_culture,
            total_leadership = :total_leadership
            WHERE idkar = :idkar AND peers = :idpic";

            $koneksi->beginTransaction();

            // Create a prepared statement with the table name
            $stmtUpdate = $koneksi->prepare($updateQuery);

            $stmtUpdate->bindParam(':idkar', $idkar);
            $stmtUpdate->bindParam(':idpic', $idpic);
            $stmtUpdate->bindParam(':updated_date', $datetime);
            $stmtUpdate->bindParam(':synergized1', $synergized1);
            $stmtUpdate->bindParam(':synergized2', $synergized2);
            $stmtUpdate->bindParam(':synergized3', $synergized3);
            $stmtUpdate->bindParam(':integrity1', $integrity1);
            $stmtUpdate->bindParam(':integrity2', $integrity2);
            $stmtUpdate->bindParam(':integrity3', $integrity3);
            $stmtUpdate->bindParam(':growth1', $growth1);
            $stmtUpdate->bindParam(':growth2', $growth2);
            $stmtUpdate->bindParam(':growth3', $growth3);
            $stmtUpdate->bindParam(':adaptive1', $adaptive1);
            $stmtUpdate->bindParam(':adaptive2', $adaptive2);
            $stmtUpdate->bindParam(':adaptive3', $adaptive3);
            $stmtUpdate->bindParam(':passion1', $passion1);
            $stmtUpdate->bindParam(':passion2', $passion2);
            $stmtUpdate->bindParam(':passion3', $passion3);
            $stmtUpdate->bindParam(':leadership1', $leadership1);
            $stmtUpdate->bindParam(':leadership2', $leadership2);
            $stmtUpdate->bindParam(':leadership3', $leadership3);
            $stmtUpdate->bindParam(':leadership4', $leadership4);
            $stmtUpdate->bindParam(':leadership5', $leadership5);
            $stmtUpdate->bindParam(':leadership6', $leadership6);
            $stmtUpdate->bindParam(':total_culture', $total_culture);
            $stmtUpdate->bindParam(':total_leadership', $total_leadership);

            // Execute the INSERT statement for the current table
            if ($stmtUpdate->execute()) {
                // If an error occurs, set the $errors variable to true
                $koneksi->commit();
                ?>
                <script>
                    window.location='home.php?link=mydata';
                    // console.log("Data created successfully!");
                </script>
                <?php
            }

            $stmtInsert->closeCursor();

        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}

?>
