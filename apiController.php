<?php
include 'conf/conf.php'; // Include the database connection script
session_start();

include("tabel_setting.php");
use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require 'vendor/autoload.php';

$code 		= isset($_GET['code']) ? $_GET['code'] : '';
$id 		= isset($_GET['id']) ? $_GET['id'] : '';
$date		= Date('Y-m-d');
$datetime	= Date('Y-m-d H:i:s');
$iduser     = isset($_SESSION['idmaster_pa']) ? $_SESSION['idmaster_pa'] : '';

if($code == 'getPenilaian') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, a.rating_a1, a.rating_a2, a.rating_a3, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.Nama_Lengkap AS nama_a1, h.Nama_Lengkap AS nama_a2, i.Nama_Lengkap AS nama_a3
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                LEFT JOIN $karyawan AS g ON g.id=f.id_atasan1
                LEFT JOIN $karyawan AS h ON h.id=f.id_atasan2
                LEFT JOIN $karyawan AS i ON i.id=f.id_atasan3
                WHERE (a.created_by='$iduser' || a.idkar='$iduser')";
    
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
    

}else if($code == 'getPenilaianA1') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, a.created_by, a.rating_a1, a.rating_a2, a.rating_a3, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.Nama_Lengkap AS nama_a1, h.Nama_Lengkap AS nama_a2, i.Nama_Lengkap AS nama_a3
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                LEFT JOIN $karyawan AS g ON g.id=f.id_atasan1
                LEFT JOIN $karyawan AS h ON h.id=f.id_atasan2
                LEFT JOIN $karyawan AS i ON i.id=f.id_atasan3
                WHERE f.id_atasan1='$iduser'";
    
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
        $sql = "SELECT a.id, a.idkar, a.total_score, a.rating_a3, f.id_atasan2, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, g.Nama_Lengkap AS nama_a3
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                LEFT JOIN $karyawan AS g ON g.id=f.id_atasan3
                WHERE f.id_atasan2='$iduser'";
    
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
        $sql = "SELECT a.id, a.idkar, a.total_score, f.id_atasan3, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date 
                FROM transaksi_2023 AS a 
                LEFT JOIN $karyawan AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
                LEFT JOIN atasan AS f ON f.idkar=a.idkar
                WHERE f.id_atasan3='$iduser'";
    
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
                WHERE a.idkar=f.id_atasan1";
    
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

}else if($code == 'submitNilaiAwal') {
    $pic = $_POST["pic"];
    $idpic = $_POST["idpic"];
    $idkar = $_POST["idkar"];
    $id_atasan1 = $_POST["id_atasan1"];
    $email_atasan1 = $_POST["email_atasan1"];
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
        $stmt1->bindParam(':id', $idkar, PDO::PARAM_STR);
        $stmt1->execute();

        $ckaryawan = $stmt1->fetch(PDO::FETCH_ASSOC);

        $nik = $ckaryawan['nik_baru'] ? $ckaryawan['nik_baru'] : $ckaryawan['NIK'];

        if ($ckaryawan) {
            // Process the data here
            // Define the common SQL INSERT statement
        $queryInsert = "INSERT INTO %s (`id`, idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, created_by, periode, total_culture, total_leadership, rating_a1, comment_a1, created_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($idpic == $idkar) {
            $tableNames = ['transaksi_2023', 'transaksi_2023_awal'];
        } else {
            $tableNames = ['transaksi_2023', 'transaksi_2023_awal', 'transaksi_2023_a1'];
        }

        // Initialize a variable to track any errors
        $errors = false;

        try {
            // Begin a transaction
            $koneksi->beginTransaction();

            // Loop through each table name and execute the INSERT statement
            foreach ($tableNames as $tableName) {
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
                $stmtInsert->bindParam(14, $synergized1);
                $stmtInsert->bindParam(15, $synergized2);
                $stmtInsert->bindParam(16, $synergized3);
                $stmtInsert->bindParam(17, $integrity1);
                $stmtInsert->bindParam(18, $integrity2);
                $stmtInsert->bindParam(19, $integrity3);
                $stmtInsert->bindParam(20, $growth1);
                $stmtInsert->bindParam(21, $growth2);
                $stmtInsert->bindParam(22, $growth3);
                $stmtInsert->bindParam(23, $adaptive1);
                $stmtInsert->bindParam(24, $adaptive2);
                $stmtInsert->bindParam(25, $adaptive3);
                $stmtInsert->bindParam(26, $passion1);
                $stmtInsert->bindParam(27, $passion2);
                $stmtInsert->bindParam(28, $passion3);
                $stmtInsert->bindParam(29, $leadership1);
                $stmtInsert->bindParam(30, $leadership2);
                $stmtInsert->bindParam(31, $leadership3);
                $stmtInsert->bindParam(32, $leadership4);
                $stmtInsert->bindParam(33, $leadership5);
                $stmtInsert->bindParam(34, $leadership6);
                $stmtInsert->bindParam(35, $idpic);
                $stmtInsert->bindParam(36, $periode);
                $stmtInsert->bindParam(37, $total_culture);
                $stmtInsert->bindParam(38, $total_leadership);
                $stmtInsert->bindParam(39, $rating);
                $stmtInsert->bindParam(40, $comment);
                $stmtInsert->bindParam(41, $datetime);

                // Execute the INSERT statement for the current table
                if (!$stmtInsert->execute()) {
                    // If an error occurs, set the $errors variable to true
                    $errors = true;
                }
            }

            // Commit the transaction if there are no errors
            if (!$errors) {
                $koneksi->commit();
                include_once('mail/mailsettings.php');	
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $body = "<p>Salam SIGAP, </P> <b>$pic</b> $a16 : <br><br>
                <table border = 0>
                    <tr>
                        <td>$a2</td>
                        <td style=\"width:70%;\">: $ckaryawan[Nama_Lengkap]</td>  
                    </tr>
                    <tr>
                        <td>$a4</td>
                        <td>: $nik</td>  
                    </tr>
                    <tr>
                        <td>$a5</td>
                        <td>: $ckaryawan[Nama_Departemen]</td>
                    </tr>
                    <tr>
                        <td>$a6</td>
                        <td>: $ckaryawan[Nama_Jabatan]</td> 
                    </tr>
                    <tr>
                        <td>$a8</td>
                        <td>: $ckaryawan[tmk]</td>
                    </tr>
                    <tr>
                        <td>$a10</td>
                        <td>: $ckaryawan[Nama_Golongan]</td>
                    </tr>
                    <tr>
                        <td>$a3</td>
                        <td  style=\"width:70%;\">: $ckaryawan[Nama_Perusahaan]</td>
                    </tr>
                    <tr>					
                        <td>$a9</td>
                        <td>: $periode</td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td>&nbsp;</th> 
                    </tr>
                    <tr>
                        <td>$a14 : </td>
                        <td colspan=\"3\">http://172.30.1.38:8080/pa</td> 
                    </tr>
                </table>
                <br>$a15
                    
                 ";
                
                $mail->Subject = "Penilaian PA ($ckaryawan[Nama_Lengkap])";
                
                $mail->MsgHTML($body);
                
                // if($nik==$nik_input){
                //     if($emailatasan1=='brian@kpn-corp.com' || $emailatasan1=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
                //         $mail->AddAddress("eriton.dewa@kpnplantation.com");
                //     }else{
                //         $mail->AddAddress($emailatasan1);
                //     }
                // }else if($atasan1==$nik_input){ 
                //     if($emailatasan2=='brian@kpn-corp.com' || $emailatasan2=='Brian@kpn-corp.com' || $atasan1=='15-01-759-0374' || $atasan2=='15-01-759-0374'){
                //         $mail->AddAddress("eriton.dewa@kpnplantation.com");
                //     }else{
                //         $mail->AddAddress($emailatasan2);
                //     }
                // }else{
                //     $mail->AddAddress("eriton.dewa@kpnplantation.com");
                // }
                
                // $mail->AddCC("alfian.azis@cemindo.com");
                $mail->AddBCC("alfian.azis@cemindo.com");
                if(!$mail->Send()) 
                {
                    // $qinsertactmailerror	= mysqli_query ($koneksi,"insert into activity_mailerror (idactivity, date) values ($iderrornya, now())");
                    // echo "Mailer Error: " . $mail->ErrorInfo;
                
                }
                else
                {
                    ?>
                    <script>console.log("email sended")</script>
                    <?php	
                } 
            } else {
                // Rollback the transaction if there are errors
                $koneksi->rollBack();
                echo "An error occurred during data insertion.";
            }
        } catch (PDOException $e) {
            // Handle any exceptions that may occur
            echo "Database Error: " . $e->getMessage();
        }

            ?>
            <script>
                window.location='home.php?link=mydata';
                // console.log("Data created successfully!");
            </script>
            <?php
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
    $comment = isset($_POST["comment_a1"]) ? $_POST["comment_a1"] : null;
    $errors = false;
    try {
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE %s SET 
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
                    comment_a1 = :comment
                    WHERE idkar = :idkar";
        
            if ($idpic == $idkar) {
                $tableNames = ['transaksi_2023', 'transaksi_2023_awal'];
            } else {
                $tableNames = ['transaksi_2023', 'transaksi_2023_awal', 'transaksi_2023_a1'];
            }

            foreach ($tableNames as $tableName) {
                // Create a prepared statement with the table name
                $stmt = $koneksi->prepare(sprintf($sql, $tableName));
            // Bind the parameters
            $stmt->bindParam(':idkar', $idkar);
            $stmt->bindParam(':idpic', $idpic);
            $stmt->bindParam(':value1', $value1);
            $stmt->bindParam(':value2', $value2);
            $stmt->bindParam(':value3', $value3);
            $stmt->bindParam(':value4', $value4);
            $stmt->bindParam(':value5', $value5);
            $stmt->bindParam(':score1', $score1);
            $stmt->bindParam(':score2', $score2);
            $stmt->bindParam(':score3', $score3);
            $stmt->bindParam(':score4', $score4);
            $stmt->bindParam(':score5', $score5);
            $stmt->bindParam(':total_score', $total_score);
            $stmt->bindParam(':updated_date', $datetime);
            $stmt->bindParam(':synergized1', $synergized1);
            $stmt->bindParam(':synergized2', $synergized2);
            $stmt->bindParam(':synergized3', $synergized3);
            $stmt->bindParam(':integrity1', $integrity1);
            $stmt->bindParam(':integrity2', $integrity2);
            $stmt->bindParam(':integrity3', $integrity3);
            $stmt->bindParam(':growth1', $growth1);
            $stmt->bindParam(':growth2', $growth2);
            $stmt->bindParam(':growth3', $growth3);
            $stmt->bindParam(':adaptive1', $adaptive1);
            $stmt->bindParam(':adaptive2', $adaptive2);
            $stmt->bindParam(':adaptive3', $adaptive3);
            $stmt->bindParam(':passion1', $passion1);
            $stmt->bindParam(':passion2', $passion2);
            $stmt->bindParam(':passion3', $passion3);
            $stmt->bindParam(':leadership1', $leadership1);
            $stmt->bindParam(':leadership2', $leadership2);
            $stmt->bindParam(':leadership3', $leadership3);
            $stmt->bindParam(':leadership4', $leadership4);
            $stmt->bindParam(':leadership5', $leadership5);
            $stmt->bindParam(':leadership6', $leadership6);
            $stmt->bindParam(':comment', $comment);
       
            if (!$stmt->execute()) {
                // If an error occurs, set the $errors variable to true
                $errors = true;
            }
        
        }
        if (!$errors) {
            $koneksi->commit();
            ?>
            <script>
                window.location='home.php?link=mydata';
                console.log("Data updated successfully!");
            </script>
            <?php
        } else {
            ?>
            <script>
                // window.location='home.php?link=mydata';
                console.log("Error");
            </script>
            <?php
        }
        
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}else if($code == 'submitReviewA1') {
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
    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score FROM transaksi_2023_a1 AS a WHERE a.idkar='$idkar'";

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
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = "UPDATE %s SET
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
                    total_culture = :total_culture,
                    total_leadership = :total_leadership,
                    rating_a1 = :rating,
                    comment_a1 = :comment
                    WHERE idkar = :idkar";

        if($employee_available){

            $tableNames = ['transaksi_2023', 'transaksi_2023_a1'];
            foreach ($tableNames as $tableName) {
                // Create a prepared statement with the table name
            $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
            $stmtUpdate->bindParam(':idkar', $idkar);
            $stmtUpdate->bindParam(':idpic', $idpic);
            $stmtUpdate->bindParam(':value1', $value1);
            $stmtUpdate->bindParam(':value2', $value2);
            $stmtUpdate->bindParam(':value3', $value3);
            $stmtUpdate->bindParam(':value4', $value4);
            $stmtUpdate->bindParam(':value5', $value5);
            $stmtUpdate->bindParam(':score1', $score1);
            $stmtUpdate->bindParam(':score2', $score2);
            $stmtUpdate->bindParam(':score3', $score3);
            $stmtUpdate->bindParam(':score4', $score4);
            $stmtUpdate->bindParam(':score5', $score5);
            $stmtUpdate->bindParam(':total_score', $total_score);
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
            $stmtUpdate->bindParam(':rating', $rating);
            $stmtUpdate->bindParam(':comment', $comment);

            $stmtUpdate->execute();
            }
        }else{

        $tableNames = ['transaksi_2023'];
        foreach ($tableNames as $tableName) {
            // Create a prepared statement with the table name
        $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
        
        $stmtUpdate->bindParam(':idkar', $idkar);
        $stmtUpdate->bindParam(':idpic', $idpic);
        $stmtUpdate->bindParam(':value1', $value1);
        $stmtUpdate->bindParam(':value2', $value2);
        $stmtUpdate->bindParam(':value3', $value3);
        $stmtUpdate->bindParam(':value4', $value4);
        $stmtUpdate->bindParam(':value5', $value5);
        $stmtUpdate->bindParam(':score1', $score1);
        $stmtUpdate->bindParam(':score2', $score2);
        $stmtUpdate->bindParam(':score3', $score3);
        $stmtUpdate->bindParam(':score4', $score4);
        $stmtUpdate->bindParam(':score5', $score5);
        $stmtUpdate->bindParam(':total_score', $total_score);
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
        $stmtUpdate->bindParam(':rating', $rating);
        $stmtUpdate->bindParam(':comment', $comment);
        
        $stmtUpdate->execute();
        }

        $insertQuery = "INSERT INTO transaksi_2023_a1 (idkar, created_by, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, total_culture, total_leadership, rating_a1, comment_a1, periode, created_date) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Create a prepared statement with the table name
            $stmtInsert = $koneksi->prepare($insertQuery);
            
            // Bind the parameters
            $stmtInsert->bindParam( 1, $idkar);
            $stmtInsert->bindParam( 2, $idpic);
            $stmtInsert->bindParam( 3, $value1);
            $stmtInsert->bindParam( 4, $value2);
            $stmtInsert->bindParam( 5, $value3);
            $stmtInsert->bindParam( 6, $value4);
            $stmtInsert->bindParam( 7, $value5);
            $stmtInsert->bindParam( 8, $score1);
            $stmtInsert->bindParam( 9, $score2);
            $stmtInsert->bindParam( 10, $score3);
            $stmtInsert->bindParam( 11, $score4);
            $stmtInsert->bindParam( 12, $score5);
            $stmtInsert->bindParam( 13, $total_score);
            $stmtInsert->bindParam( 14, $synergized1);
            $stmtInsert->bindParam( 15, $synergized2);
            $stmtInsert->bindParam( 16, $synergized3);
            $stmtInsert->bindParam( 17, $integrity1);
            $stmtInsert->bindParam( 18, $integrity2);
            $stmtInsert->bindParam( 19, $integrity3);
            $stmtInsert->bindParam( 20, $growth1);
            $stmtInsert->bindParam( 21, $growth2);
            $stmtInsert->bindParam( 22, $growth3);
            $stmtInsert->bindParam( 23, $adaptive1);
            $stmtInsert->bindParam( 24, $adaptive2);
            $stmtInsert->bindParam( 25, $adaptive3);
            $stmtInsert->bindParam( 26, $passion1);
            $stmtInsert->bindParam( 27, $passion2);
            $stmtInsert->bindParam( 28, $passion3);
            $stmtInsert->bindParam( 29, $leadership1);
            $stmtInsert->bindParam( 30, $leadership2);
            $stmtInsert->bindParam( 31, $leadership3);
            $stmtInsert->bindParam( 32, $leadership4);
            $stmtInsert->bindParam( 33, $leadership5);
            $stmtInsert->bindParam( 34, $leadership6);
            $stmtInsert->bindParam( 35, $total_culture);
            $stmtInsert->bindParam( 36, $total_leadership);
            $stmtInsert->bindParam( 37, $rating);  // Use the correct name
            $stmtInsert->bindParam( 38, $comment);  // Use the correct name
            $stmtInsert->bindParam( 39, $periode);
            $stmtInsert->bindParam( 40, $datetime);

            $stmtInsert->execute();
        }
        echo "<script>
                window.location='home.php?link=mydata';
                console.log('Data submitted successfully!');
                </script>";
        $koneksi->commit();
    } catch (PDOException $e) {
        $koneksi->rollBack();
        echo '<script>console.log("Error: ' . $e->getMessage() . '");</script>';
    }

}else if($code == 'submitReviewA1Manager') {
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

    $peersArray = array(
        isset($_POST["peers1"]) ? $_POST["peers1"] : "",
        isset($_POST["peers2"]) ? $_POST["peers2"] : "",
        isset($_POST["peers3"]) ? $_POST["peers3"] : ""
    );
    $total_culture = number_format(($synergized1 + $synergized2 + $synergized3 + $integrity1 + $integrity2 + $integrity3 + $growth1 + $growth2 + $growth3 + $adaptive1 + $adaptive2 + $adaptive3 + $passion1 + $passion2 + $passion3) / 15 , 2);
    $avg = $leadership6 == 0 ? 5 : 6;
    $total_leadership = number_format(($leadership1 + $leadership2 + $leadership3 + $leadership4 + $leadership5 + $leadership6) / $avg , 2);
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score FROM transaksi_2023_a1 AS a WHERE a.idkar='$idkar'";

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
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = "UPDATE %s SET
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
                    total_culture = :total_culture,
                    total_leadership = :total_leadership,
                    rating_a1 = :rating,
                    comment_a1 = :comment
                    WHERE idkar = :idkar";

        if($employee_available){

            $tableNames = ['transaksi_2023', 'transaksi_2023_a1'];
            foreach ($tableNames as $tableName) {
                // Create a prepared statement with the table name
            $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
            $stmtUpdate->bindParam(':idkar', $idkar);
            $stmtUpdate->bindParam(':idpic', $idpic);
            $stmtUpdate->bindParam(':value1', $value1);
            $stmtUpdate->bindParam(':value2', $value2);
            $stmtUpdate->bindParam(':value3', $value3);
            $stmtUpdate->bindParam(':value4', $value4);
            $stmtUpdate->bindParam(':value5', $value5);
            $stmtUpdate->bindParam(':score1', $score1);
            $stmtUpdate->bindParam(':score2', $score2);
            $stmtUpdate->bindParam(':score3', $score3);
            $stmtUpdate->bindParam(':score4', $score4);
            $stmtUpdate->bindParam(':score5', $score5);
            $stmtUpdate->bindParam(':total_score', $total_score);
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
            $stmtUpdate->bindParam(':rating', $rating);
            $stmtUpdate->bindParam(':comment', $comment);

            $stmtUpdate->execute();
            }

            $updatePeersQuery = "UPDATE transaksi_2023_peers SET
                    updated_by = :idpic,
                    updated_date = :updated_date,
                    periode = :periode,
                    WHERE peers = :idpeers";

            foreach ($peersArray as $peers) {
                $stmtUpdatePeers = $koneksi->prepare($updatePeersQuery);
                $stmtUpdatePeers->bindParam(':idpeers', $peers);
                $stmtUpdatePeers->bindParam(':idpic', $idpic);
                $stmtUpdatePeers->bindParam(':periode', $periode);
                $stmtUpdatePeers->bindParam(':updated_date', $datetime);

                // Execute the query for each peer
                $stmtUpdatePeers->execute();
            }

        }else{

        $tableNames = ['transaksi_2023'];
        foreach ($tableNames as $tableName) {
            // Create a prepared statement with the table name
        $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
        
        $stmtUpdate->bindParam(':idkar', $idkar);
        $stmtUpdate->bindParam(':idpic', $idpic);
        $stmtUpdate->bindParam(':value1', $value1);
        $stmtUpdate->bindParam(':value2', $value2);
        $stmtUpdate->bindParam(':value3', $value3);
        $stmtUpdate->bindParam(':value4', $value4);
        $stmtUpdate->bindParam(':value5', $value5);
        $stmtUpdate->bindParam(':score1', $score1);
        $stmtUpdate->bindParam(':score2', $score2);
        $stmtUpdate->bindParam(':score3', $score3);
        $stmtUpdate->bindParam(':score4', $score4);
        $stmtUpdate->bindParam(':score5', $score5);
        $stmtUpdate->bindParam(':total_score', $total_score);
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
        $stmtUpdate->bindParam(':rating', $rating);
        $stmtUpdate->bindParam(':comment', $comment);
        
        $stmtUpdate->execute();
        }

        $insertQuery = "INSERT INTO transaksi_2023_a1 (idkar, created_by, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, total_culture, total_leadership, rating_a1, comment_a1, periode, created_date) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Create a prepared statement with the table name
            $stmtInsert = $koneksi->prepare($insertQuery);
            
            // Bind the parameters
            $stmtInsert->bindParam( 1, $idkar);
            $stmtInsert->bindParam( 2, $idpic);
            $stmtInsert->bindParam( 3, $value1);
            $stmtInsert->bindParam( 4, $value2);
            $stmtInsert->bindParam( 5, $value3);
            $stmtInsert->bindParam( 6, $value4);
            $stmtInsert->bindParam( 7, $value5);
            $stmtInsert->bindParam( 8, $score1);
            $stmtInsert->bindParam( 9, $score2);
            $stmtInsert->bindParam( 10, $score3);
            $stmtInsert->bindParam( 11, $score4);
            $stmtInsert->bindParam( 12, $score5);
            $stmtInsert->bindParam( 13, $total_score);
            $stmtInsert->bindParam( 14, $synergized1);
            $stmtInsert->bindParam( 15, $synergized2);
            $stmtInsert->bindParam( 16, $synergized3);
            $stmtInsert->bindParam( 17, $integrity1);
            $stmtInsert->bindParam( 18, $integrity2);
            $stmtInsert->bindParam( 19, $integrity3);
            $stmtInsert->bindParam( 20, $growth1);
            $stmtInsert->bindParam( 21, $growth2);
            $stmtInsert->bindParam( 22, $growth3);
            $stmtInsert->bindParam( 23, $adaptive1);
            $stmtInsert->bindParam( 24, $adaptive2);
            $stmtInsert->bindParam( 25, $adaptive3);
            $stmtInsert->bindParam( 26, $passion1);
            $stmtInsert->bindParam( 27, $passion2);
            $stmtInsert->bindParam( 28, $passion3);
            $stmtInsert->bindParam( 29, $leadership1);
            $stmtInsert->bindParam( 30, $leadership2);
            $stmtInsert->bindParam( 31, $leadership3);
            $stmtInsert->bindParam( 32, $leadership4);
            $stmtInsert->bindParam( 33, $leadership5);
            $stmtInsert->bindParam( 34, $leadership6);
            $stmtInsert->bindParam( 35, $total_culture);
            $stmtInsert->bindParam( 36, $total_leadership);
            $stmtInsert->bindParam( 37, $rating);  // Use the correct name
            $stmtInsert->bindParam( 38, $comment);  // Use the correct name
            $stmtInsert->bindParam( 39, $periode);
            $stmtInsert->bindParam( 40, $datetime);

            $stmtInsert->execute();

            $InsertPeersQuery = "INSERT INTO transaksi_2023_peers (created_by, created_date, peers, periode, idkar) VALUES (?, ?, ?, ?, ?)";

            foreach ($peersArray as $peers) {
                $stmtInsertPeers = $koneksi->prepare($InsertPeersQuery);
                $stmtInsertPeers->bindParam( 1, $idpic);
                $stmtInsertPeers->bindParam( 2, $datetime);
                $stmtInsertPeers->bindParam( 3, $peers);
                $stmtInsertPeers->bindParam( 4, $periode);
                $stmtInsertPeers->bindParam( 5, $idkar);

                // Execute the query for each peer
                $stmtInsertPeers->execute();
            }

        }
        echo "<script>
                window.location='home.php?link=mydata';
                console.log('Data submitted successfully!');
                </script>";
        $koneksi->commit();
    } catch (PDOException $e) {
        $koneksi->rollBack();
        echo '<script>console.log("Error: ' . $e->getMessage() . '");</script>';
    }

}else if($code == 'submitReviewA2') {
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
   
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score FROM transaksi_2023_a2 AS a WHERE a.idkar='$idkar'";

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
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = "UPDATE %s SET
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
                    rating_a2 = :rating,
                    comment_a2 = :comment
                    WHERE idkar = :idkar";

        if($employee_available){

            $tableNames = ['transaksi_2023', 'transaksi_2023_a2'];
            foreach ($tableNames as $tableName) {
                // Create a prepared statement with the table name
            $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
            $stmtUpdate->bindParam(':idkar', $idkar);
            $stmtUpdate->bindParam(':idpic', $idpic);
            $stmtUpdate->bindParam(':value1', $value1);
            $stmtUpdate->bindParam(':value2', $value2);
            $stmtUpdate->bindParam(':value3', $value3);
            $stmtUpdate->bindParam(':value4', $value4);
            $stmtUpdate->bindParam(':value5', $value5);
            $stmtUpdate->bindParam(':score1', $score1);
            $stmtUpdate->bindParam(':score2', $score2);
            $stmtUpdate->bindParam(':score3', $score3);
            $stmtUpdate->bindParam(':score4', $score4);
            $stmtUpdate->bindParam(':score5', $score5);
            $stmtUpdate->bindParam(':total_score', $total_score);
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
            $stmtUpdate->bindParam(':rating', $rating);
            $stmtUpdate->bindParam(':comment', $comment);

            $stmtUpdate->execute();
            }
        }else{

        $tableNames = ['transaksi_2023'];
        foreach ($tableNames as $tableName) {
            // Create a prepared statement with the table name
        $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
        
        $stmtUpdate->bindParam(':idkar', $idkar);
        $stmtUpdate->bindParam(':idpic', $idpic);
        $stmtUpdate->bindParam(':value1', $value1);
        $stmtUpdate->bindParam(':value2', $value2);
        $stmtUpdate->bindParam(':value3', $value3);
        $stmtUpdate->bindParam(':value4', $value4);
        $stmtUpdate->bindParam(':value5', $value5);
        $stmtUpdate->bindParam(':score1', $score1);
        $stmtUpdate->bindParam(':score2', $score2);
        $stmtUpdate->bindParam(':score3', $score3);
        $stmtUpdate->bindParam(':score4', $score4);
        $stmtUpdate->bindParam(':score5', $score5);
        $stmtUpdate->bindParam(':total_score', $total_score);
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
        $stmtUpdate->bindParam(':rating', $rating);
        $stmtUpdate->bindParam(':comment', $comment);
        
        $stmtUpdate->execute();
        }

        $insertQuery = "INSERT INTO transaksi_2023_a2 (idkar, created_by, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, rating_a2, comment_a2, periode, created_date) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Create a prepared statement with the table name
            $stmtInsert = $koneksi->prepare($insertQuery);
            
            // Bind the parameters
            $stmtInsert->bindParam( 1, $idkar);
            $stmtInsert->bindParam( 2, $idpic);
            $stmtInsert->bindParam( 3, $value1);
            $stmtInsert->bindParam( 4, $value2);
            $stmtInsert->bindParam( 5, $value3);
            $stmtInsert->bindParam( 6, $value4);
            $stmtInsert->bindParam( 7, $value5);
            $stmtInsert->bindParam( 8, $score1);
            $stmtInsert->bindParam( 9, $score2);
            $stmtInsert->bindParam( 10, $score3);
            $stmtInsert->bindParam( 11, $score4);
            $stmtInsert->bindParam( 12, $score5);
            $stmtInsert->bindParam( 13, $total_score);
            $stmtInsert->bindParam( 14, $synergized1);
            $stmtInsert->bindParam( 15, $synergized2);
            $stmtInsert->bindParam( 16, $synergized3);
            $stmtInsert->bindParam( 17, $integrity1);
            $stmtInsert->bindParam( 18, $integrity2);
            $stmtInsert->bindParam( 19, $integrity3);
            $stmtInsert->bindParam( 20, $growth1);
            $stmtInsert->bindParam( 21, $growth2);
            $stmtInsert->bindParam( 22, $growth3);
            $stmtInsert->bindParam( 23, $adaptive1);
            $stmtInsert->bindParam( 24, $adaptive2);
            $stmtInsert->bindParam( 25, $adaptive3);
            $stmtInsert->bindParam( 26, $passion1);
            $stmtInsert->bindParam( 27, $passion2);
            $stmtInsert->bindParam( 28, $passion3);
            $stmtInsert->bindParam( 29, $leadership1);
            $stmtInsert->bindParam( 30, $leadership2);
            $stmtInsert->bindParam( 31, $leadership3);
            $stmtInsert->bindParam( 32, $leadership4);
            $stmtInsert->bindParam( 33, $leadership5);
            $stmtInsert->bindParam( 34, $leadership6);
            $stmtInsert->bindParam( 35, $rating);  // Use the correct name
            $stmtInsert->bindParam( 36, $comment);  // Use the correct name
            $stmtInsert->bindParam( 37, $periode);
            $stmtInsert->bindParam( 38, $datetime);

            $stmtInsert->execute();
        }
        echo "<script>
                window.location='home.php?link=mydata';
                console.log('Data submitted successfully!');
                </script>";
        $koneksi->commit();
    } catch (PDOException $e) {
        $koneksi->rollBack();
        echo '<script>console.log("Error: ' . $e->getMessage() . '");</script>';
    }

}else if($code == 'submitReviewA3') {
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
   
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : null;
    $comment = isset($_POST["comment"]) ? $_POST["comment"] : null;

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score FROM transaksi_2023_a3 AS a WHERE a.idkar='$idkar'";

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
        $koneksi->beginTransaction();
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $updateQuery = "UPDATE %s SET
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
                    rating_a3 = :rating,
                    comment_a3 = :comment
                    WHERE idkar = :idkar";

        if($employee_available){

            $tableNames = ['transaksi_2023', 'transaksi_2023_a3'];
            foreach ($tableNames as $tableName) {
                // Create a prepared statement with the table name
            $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
            $stmtUpdate->bindParam(':idkar', $idkar);
            $stmtUpdate->bindParam(':idpic', $idpic);
            $stmtUpdate->bindParam(':value1', $value1);
            $stmtUpdate->bindParam(':value2', $value2);
            $stmtUpdate->bindParam(':value3', $value3);
            $stmtUpdate->bindParam(':value4', $value4);
            $stmtUpdate->bindParam(':value5', $value5);
            $stmtUpdate->bindParam(':score1', $score1);
            $stmtUpdate->bindParam(':score2', $score2);
            $stmtUpdate->bindParam(':score3', $score3);
            $stmtUpdate->bindParam(':score4', $score4);
            $stmtUpdate->bindParam(':score5', $score5);
            $stmtUpdate->bindParam(':total_score', $total_score);
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
            $stmtUpdate->bindParam(':rating', $rating);
            $stmtUpdate->bindParam(':comment', $comment);

            $stmtUpdate->execute();
            }
        }else{

        $tableNames = ['transaksi_2023'];
        foreach ($tableNames as $tableName) {
            // Create a prepared statement with the table name
        $stmtUpdate = $koneksi->prepare(sprintf($updateQuery, $tableName));
        
        $stmtUpdate->bindParam(':idkar', $idkar);
        $stmtUpdate->bindParam(':idpic', $idpic);
        $stmtUpdate->bindParam(':value1', $value1);
        $stmtUpdate->bindParam(':value2', $value2);
        $stmtUpdate->bindParam(':value3', $value3);
        $stmtUpdate->bindParam(':value4', $value4);
        $stmtUpdate->bindParam(':value5', $value5);
        $stmtUpdate->bindParam(':score1', $score1);
        $stmtUpdate->bindParam(':score2', $score2);
        $stmtUpdate->bindParam(':score3', $score3);
        $stmtUpdate->bindParam(':score4', $score4);
        $stmtUpdate->bindParam(':score5', $score5);
        $stmtUpdate->bindParam(':total_score', $total_score);
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
        $stmtUpdate->bindParam(':rating', $rating);
        $stmtUpdate->bindParam(':comment', $comment);
        
        $stmtUpdate->execute();
        }

        $insertQuery = "INSERT INTO transaksi_2023_a3 (idkar, created_by, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, rating_a3, comment_a3, periode, created_date) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
            // Create a prepared statement with the table name
            $stmtInsert = $koneksi->prepare($insertQuery);
            
            // Bind the parameters
            $stmtInsert->bindParam( 1, $idkar);
            $stmtInsert->bindParam( 2, $idpic);
            $stmtInsert->bindParam( 3, $value1);
            $stmtInsert->bindParam( 4, $value2);
            $stmtInsert->bindParam( 5, $value3);
            $stmtInsert->bindParam( 6, $value4);
            $stmtInsert->bindParam( 7, $value5);
            $stmtInsert->bindParam( 8, $score1);
            $stmtInsert->bindParam( 9, $score2);
            $stmtInsert->bindParam( 10, $score3);
            $stmtInsert->bindParam( 11, $score4);
            $stmtInsert->bindParam( 12, $score5);
            $stmtInsert->bindParam( 13, $total_score);
            $stmtInsert->bindParam( 14, $synergized1);
            $stmtInsert->bindParam( 15, $synergized2);
            $stmtInsert->bindParam( 16, $synergized3);
            $stmtInsert->bindParam( 17, $integrity1);
            $stmtInsert->bindParam( 18, $integrity2);
            $stmtInsert->bindParam( 19, $integrity3);
            $stmtInsert->bindParam( 20, $growth1);
            $stmtInsert->bindParam( 21, $growth2);
            $stmtInsert->bindParam( 22, $growth3);
            $stmtInsert->bindParam( 23, $adaptive1);
            $stmtInsert->bindParam( 24, $adaptive2);
            $stmtInsert->bindParam( 25, $adaptive3);
            $stmtInsert->bindParam( 26, $passion1);
            $stmtInsert->bindParam( 27, $passion2);
            $stmtInsert->bindParam( 28, $passion3);
            $stmtInsert->bindParam( 29, $leadership1);
            $stmtInsert->bindParam( 30, $leadership2);
            $stmtInsert->bindParam( 31, $leadership3);
            $stmtInsert->bindParam( 32, $leadership4);
            $stmtInsert->bindParam( 33, $leadership5);
            $stmtInsert->bindParam( 34, $leadership6);
            $stmtInsert->bindParam( 35, $rating);  // Use the correct name
            $stmtInsert->bindParam( 36, $comment);  // Use the correct name
            $stmtInsert->bindParam( 37, $periode);
            $stmtInsert->bindParam( 38, $datetime);

            $stmtInsert->execute();
        }
        echo "<script>
                window.location='home.php?link=mydata';
                console.log('Data submitted successfully!');
                </script>";
        $koneksi->commit();
    } catch (PDOException $e) {
        $koneksi->rollBack();
        echo '<script>console.log("Error: ' . $e->getMessage() . '");</script>';
    }

}else if($code == 'getDataEditAwal') {
    // Initialize an empty response array
    $response = array();

    // Check if the HTTP method is GET
        // Perform your database query here
        try {
            $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Example query: Select all data from a table named 'your_table'
            $query = "SELECT a.*, DATE_FORMAT(b.mulai_bekerja, '%d-%m-%Y') AS tmk, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, c.fortable, d.Nama_OU, e.Nama_Departemen, f.Nama_Perusahaan, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan1 = :id OR id_atasan2 = :id OR id_atasan3 = :id) as jumlah_subo 
            FROM transaksi_2023 AS a 
            LEFT JOIN $karyawan AS b ON b.id = a.idkar 
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
            LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
            LEFT JOIN daftarperusahaan AS f ON f.Kode_Perusahaan = b.Kode_Perusahaan
            WHERE a.idkar= :id";
            $stmt = $koneksi->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
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
                    'comment_a1' => $item['comment_a1'],
                    'rating_a1' => $item['rating_a1'],
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
            $query = "SELECT a.*, DATE_FORMAT(b.mulai_bekerja, '%d-%m-%Y') AS tmk, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, c.fortable, d.Nama_OU, e.Nama_Departemen, f.Nama_Perusahaan, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan1 = :id OR id_atasan2 = :id OR id_atasan3 = :id) as jumlah_subo, g.id_atasan1, g.id_atasan2, g.id_atasan3, h.Nama_Lengkap as nama_a1, i.Nama_Lengkap as nama_a2, j.Nama_Lengkap as nama_a3, h.Nama_Jabatan as jabatan_a1, i.Nama_Jabatan as jabatan_a2, j.Nama_Jabatan as jabatan_a3
            FROM transaksi_2023 AS a 
            LEFT JOIN $karyawan AS b ON b.id = a.idkar 
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
            LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
            LEFT JOIN daftarperusahaan AS f ON f.Kode_Perusahaan = b.Kode_Perusahaan
            LEFT JOIN atasan AS g ON g.idkar=a.idkar
            LEFT JOIN $karyawan AS h ON h.id=g.id_atasan1
            LEFT JOIN $karyawan AS i ON i.id=g.id_atasan2
            LEFT JOIN $karyawan AS j ON j.id=g.id_atasan3
            WHERE a.idkar= :id";
            $stmt = $koneksi->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
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
                    'comment_a1' => $item['comment_a1'],
                    'comment_a2' => $item['comment_a2'],
                    'comment_a3' => $item['comment_a3'],
                    'rating_a1' => $item['rating_a1'],
                    'rating_a2' => $item['rating_a2'],
                    'rating_a3' => $item['rating_a3'],
                    'id_atasan1' => $item['id_atasan1'],
                    'nama_a1' => $item['nama_a1'],
                    'jabatan_a1' => $item['jabatan_a1'],
                    'id_atasan2' => $item['id_atasan2'],
                    'nama_a2' => $item['nama_a2'],
                    'jabatan_a2' => $item['jabatan_a2'],
                    'id_atasan3' => $item['id_atasan3'],
                    'nama_a3' => $item['nama_a3'],
                    'jabatan_a3' => $item['jabatan_a3'],
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
        $queryInsert = "INSERT INTO transaksi_2023_subo (idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, synergized1, synergized2, synergized3, integrity1, integrity2, integrity3, growth1, growth2, growth3, adaptive1, adaptive2, adaptive3, passion1, passion2, passion3, leadership1, leadership2, leadership3, leadership4, leadership5, leadership6, created_by, periode, total_culture, total_leadership, rating, `comment`, created_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
