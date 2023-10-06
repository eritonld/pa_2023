<?php
include 'conf/conf.php'; // Include the database connection script
include("tabel_setting.php");
use PHPMailer\PHPMailer\PHPMailer;

//Load Composer's autoloader
require 'vendor/autoload.php';

$code 		= isset($_GET['code']) ? $_GET['code'] : '';
$id 		= isset($_GET['id']) ? $_GET['id'] : '';
$date		= Date('Y-m-d');
$datetime	= Date('Y-m-d H:i:s');

if($code == 'getPenilaian') {

    try {
        $sql = "SELECT a.id, a.idkar, a.total_score, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date 
                FROM transaksi_2023 AS a 
                LEFT JOIN karyawan_2023 AS b ON b.id = a.idkar 
                LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
                LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
                LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen";
    
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
        $queryInsert = "INSERT INTO %s (`id`, idkar, value_1, value_2, value_3, value_4, value_5, score_1, score_2, score_3, score_4, score_5, total_score, created_by, periode) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($idpic == $id_atasan1) {
            $tableNames = ['transaksi_2023', 'transaksi_2023_awal', 'transaksi_2023_a1'];
        } else {
            $tableNames = ['transaksi_2023', 'transaksi_2023_awal'];
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
                $stmtInsert->bindParam(14, $idkar);
                $stmtInsert->bindParam(15, $periode);

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
                console.log("Data created successfully!");
            </script>
            <?php
        } else {
            ?>
            <script>
                window.location='home.php?link=mydata';
                console.log("Error");
            </script>
            <?php
        }
        
        $stmtInsert->closeCursor();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}else if($code == 'updateNilaiAwal') {
    $idkar = $_POST["idkar"];
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

    try {
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE transaksi_2023 SET 
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
                    updated_by = :idkar,
                    updated_date = :updated_date
                WHERE idkar = :idkar";
        
            $stmt = $koneksi->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':idkar', $idkar);
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
        
        if ($stmt->execute()) {
            ?>
            <script>
                window.location='home.php?link=mydata';
                console.log("Data updated successfully!");
            </script>
            <?php
        } else {
            ?>
            <script>
                window.location='home.php?link=mydata';
                console.log("Error");
            </script>
            <?php
        }
        
        $stmt->closeCursor();
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
            $query = "SELECT a.id, a.idkar, a.total_score, a.periode, a.value_1, a.value_2, a.value_3, a.value_4, a.value_5, a.score_1, a.score_2, a.score_3, a.score_4, a.score_5, DATE_FORMAT(b.mulai_bekerja, '%d-%m-%Y') AS tmk, b.NIK, b.nik_baru, b.Nama_Lengkap, b.Nama_Jabatan, c.Nama_Golongan, d.Nama_OU, e.Nama_Departemen, f.Nama_Perusahaan, DATE_FORMAT(a.created_date, '%d-%m-%Y') AS created_date 
            FROM transaksi_2023 AS a 
            LEFT JOIN karyawan_2023 AS b ON b.id = a.idkar 
            LEFT JOIN daftargolongan AS c ON c.Kode_Golongan = b.Kode_Golongan 
            LEFT JOIN daftarou AS d ON d.Kode_OU = b.Kode_OU 
            LEFT JOIN daftardepartemen AS e ON e.kode_departemen = b.Kode_Departemen
            LEFT JOIN daftarperusahaan AS f ON f.Kode_Perusahaan = b.Kode_Perusahaan
            WHERE a.id='$id'";
            $stmt = $koneksi->prepare($query);
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
}

?>
