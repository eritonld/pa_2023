<?php
include("tabel_setting.php");
include("function.php");
$koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Example query: Select all data from a table named 'your_table'
$query = "SELECT b.fortable, (SELECT COUNT(idkar) FROM atasan WHERE id_atasan = :id) as jumlah_subo, (
    SELECT id_atasan
    FROM atasan
    WHERE idkar = :id ORDER BY id ASC LIMIT 1) AS id_atasan, (
    SELECT layer
    FROM atasan
    WHERE idkar = :id ORDER BY id ASC LIMIT 1) AS layer
FROM $karyawan AS a 
LEFT JOIN daftargolongan AS b ON b.Kode_Golongan=a.Kode_Golongan
WHERE a.id= :id";
$stmt = $koneksi->prepare($query);
$stmt->bindParam(':id', $scekuser['id'], PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

// $queryPeers = "SELECT idkar FROM transaksi_2023_peers WHERE peers = '$scekuser[id]'";
// $stmtPeer = $koneksi->prepare($queryPeers);
// $stmtPeer->execute();
// $resultPeers = $stmtPeer->fetchAll(PDO::FETCH_ASSOC);
// $cekPeers =  count($resultPeers);
// echo $cekPeers;
// Fetch data as an associative array
$fortable = $results['fortable'] != "staff" ? $results['fortable'] : ($results['jumlah_subo'] > 0 ? "staffb" : "staff");

try {
    $queryView = "SELECT CASE
    WHEN
        (SELECT COUNT(a.id) AS total
         FROM transaksi_2023_final AS a
         LEFT JOIN atasan AS b ON b.idkar = a.idkar AND b.id_atasan = '$idmaster_pa'
         WHERE b.id_atasan = '$idmaster_pa' AND a.layer = b.layer) = 
        (SELECT COUNT(id) 
         FROM atasan 
         WHERE id_atasan = '$idmaster_pa')
    THEN 1
    ELSE 0
    END AS result";

    $resultView = $koneksi->query($queryView);

    $view = $resultView->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}
// echo $view['result'];

try {
    $queryPending23 = "SELECT a.Nama_Lengkap, c.approval_status FROM $karyawan a 
    LEFT JOIN atasan b ON b.idkar=a.id 
    LEFT JOIN transaksi_2023 c ON c.idkar=a.id AND c.approver_id='$idmaster_pa'
    WHERE b.id_atasan='$idmaster_pa' AND isnull(c.id) AND a.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')
    UNION 
    SELECT b.Nama_Lengkap, d.Nama_Lengkap AS approver_name FROM transaksi_2023_final a 
    LEFT JOIN $karyawan b ON b.id=a.idkar
    LEFT JOIN transaksi_2023 c ON c.idkar=a.idkar AND c.approver_id='$idmaster_pa'
    LEFT JOIN $karyawan d ON d.id=a.approver_rating_id
    WHERE (a.approver_review_id='$idmaster_pa' AND a.approval_review='Pending' OR a.approver_rating_id='$idmaster_pa' AND c.approval_status!='Pending') AND b.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')";

    $resultPending23 = $koneksi->query($queryPending23);

    $pending23 = $resultPending23->fetchAll(PDO::FETCH_ASSOC);

    $countPending23 = count($pending23);

    $queryPending45 = "SELECT a.Nama_Lengkap, c.approval_status FROM $karyawan a 
    LEFT JOIN atasan b ON b.idkar=a.id 
    LEFT JOIN transaksi_2023 c ON c.idkar=a.id AND c.approver_id='$idmaster_pa'
    WHERE b.id_atasan='$idmaster_pa' AND isnull(c.id) AND a.Kode_Golongan IN ('GL013','GL014','GL016','GL017')
    UNION 
    SELECT b.Nama_Lengkap, d.Nama_Lengkap AS approver_name FROM transaksi_2023_final a 
    LEFT JOIN $karyawan b ON b.id=a.idkar
    LEFT JOIN transaksi_2023 c ON c.idkar=a.idkar AND c.approver_id='$idmaster_pa'
    LEFT JOIN $karyawan d ON d.id=a.approver_rating_id
    WHERE (a.approver_review_id='$idmaster_pa' AND a.approval_review='Pending' OR a.approver_rating_id='$idmaster_pa' AND c.approval_status!='Pending') AND b.Kode_Golongan IN ('GL013','GL014','GL016','GL017')";

    $resultPending45 = $koneksi->query($queryPending45);

    $pending45 = $resultPending45->fetchAll(PDO::FETCH_ASSOC);

    $countPending45 = count($pending45);

    $queryPending67 = "SELECT a.Nama_Lengkap, c.approval_status FROM $karyawan a 
    LEFT JOIN atasan b ON b.idkar=a.id 
    LEFT JOIN transaksi_2023 c ON c.idkar=a.id AND c.approver_id='$idmaster_pa'
    WHERE b.id_atasan='$idmaster_pa' AND isnull(c.id) AND a.Kode_Golongan IN ('GL020','GL021','GL024','GL025')
    UNION 
    SELECT b.Nama_Lengkap, d.Nama_Lengkap AS approver_name FROM transaksi_2023_final a 
    LEFT JOIN $karyawan b ON b.id=a.idkar
    LEFT JOIN transaksi_2023 c ON c.idkar=a.idkar AND c.approver_id='$idmaster_pa'
    LEFT JOIN $karyawan d ON d.id=a.approver_rating_id
    WHERE (a.approver_review_id='$idmaster_pa' AND a.approval_review='Pending' OR a.approver_rating_id='$idmaster_pa' AND c.approval_status!='Pending') AND b.Kode_Golongan IN ('GL020','GL021','GL024','GL025')";

    $resultPending67 = $koneksi->query($queryPending67);

    $pending67 = $resultPending67->fetchAll(PDO::FETCH_ASSOC);

    $countPending67 = count($pending67);

    $queryPending89 = "SELECT a.Nama_Lengkap, c.approval_status FROM $karyawan a 
    LEFT JOIN atasan b ON b.idkar=a.id 
    LEFT JOIN transaksi_2023 c ON c.idkar=a.id AND c.approver_id='$idmaster_pa'
    WHERE b.id_atasan='$idmaster_pa' AND isnull(c.id) AND a.Kode_Golongan IN ('GL028','GL029','GL031','GL032')
    UNION 
    SELECT b.Nama_Lengkap, d.Nama_Lengkap AS approver_name FROM transaksi_2023_final a 
    LEFT JOIN $karyawan b ON b.id=a.idkar
    LEFT JOIN transaksi_2023 c ON c.idkar=a.idkar AND c.approver_id='$idmaster_pa'
    LEFT JOIN $karyawan d ON d.id=a.approver_rating_id
    WHERE (a.approver_review_id='$idmaster_pa' AND a.approval_review='Pending' OR a.approver_rating_id='$idmaster_pa' AND c.approval_status!='Pending') AND b.Kode_Golongan IN ('GL028','GL029','GL031','GL032')";

    $resultPending89 = $koneksi->query($queryPending89);

    $pending89 = $resultPending89->fetchAll(PDO::FETCH_ASSOC);

    $countPending89 = count($pending89);

} catch (PDOException $e) {
    echo $e->getMessage();
}
try {
    $queryTarget = "SELECT
    c.ranges,
    c.grade,
    ROUND((COUNT(a.idkar) * c.percent_a) / 100) AS target_a,
    ROUND((COUNT(a.idkar) * c.percent_b) / 100) AS target_b,
    COUNT(a.idkar) - ROUND((COUNT(a.idkar) * c.percent_a) / 100) - ROUND((COUNT(a.idkar) * c.percent_b) / 100) - ROUND((COUNT(a.idkar) * c.percent_c) / 100) - ROUND((COUNT(a.idkar) * c.percent_d) / 100) AS target_c,
    ROUND((COUNT(a.idkar) * c.percent_d) / 100) AS target_d,
    ROUND((COUNT(a.idkar) * c.percent_e) / 100) AS target_e,
    COUNT(a.idkar) AS total_subo
    FROM atasan AS a
    LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar = a.id_atasan
    LEFT JOIN kriteria AS c ON c.grade = b.kpi_unit AND c.tahun = '$tahunperiode'
    WHERE id_atasan = '$idmaster_pa'";

    $resultTarget = $koneksi->query($queryTarget);

    $targetRating = $resultTarget->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $queryKriteria = "SELECT a.id,
    CASE WHEN (SELECT COUNT(idkar) FROM atasan AS a LEFT JOIN karyawan_$tahunperiode AS b ON b.id=a.idkar WHERE a.id_atasan='$idmaster_pa' AND b.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')) <= 11 THEN 'secondary' ELSE 'primary' END AS JG23, 
    CASE WHEN (SELECT COUNT(idkar) FROM atasan AS a LEFT JOIN karyawan_$tahunperiode AS b ON b.id=a.idkar WHERE a.id_atasan='$idmaster_pa' AND b.Kode_Golongan IN ('GL013','GL014','GL016','GL017')) <= 11 THEN 'secondary' ELSE 'primary' END AS JG45,
    CASE WHEN (SELECT COUNT(idkar) FROM atasan AS a LEFT JOIN karyawan_$tahunperiode AS b ON b.id=a.idkar WHERE a.id_atasan='$idmaster_pa' AND b.Kode_Golongan IN ('GL020','GL021','GL024','GL025')) <= 11 THEN 'secondary' ELSE 'primary' END AS JG67,
    CASE WHEN (SELECT COUNT(idkar) FROM atasan AS a LEFT JOIN karyawan_$tahunperiode AS b ON b.id=a.idkar WHERE a.id_atasan='$idmaster_pa' AND b.Kode_Golongan IN ('GL028','GL029','GL031','GL032')) <= 11 THEN 'secondary' ELSE 'primary' END AS JG89
    FROM karyawan_$tahunperiode AS a LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar=a.id WHERE a.id='$idmaster_pa'";

    $stmtKriteria = $koneksi->query($queryKriteria);
    $resultKriteria = $stmtKriteria->fetch(PDO::FETCH_ASSOC);

    $queryTarget23 = "SELECT c.ranges, c.grade, c.percent_a, c.percent_b, c.percent_c, c.percent_d, c.percent_e, 
        ROUND((COUNT(a.idkar) * c.percent_a) / 100) AS target_a, 
        ROUND((COUNT(a.idkar) * c.percent_b) / 100) AS target_b, 
        ROUND(COUNT(a.idkar) - (((COUNT(a.idkar) * c.percent_a) / 100) + 
        ((COUNT(a.idkar) * c.percent_b) / 100) + 
        ((COUNT(a.idkar) * c.percent_d) / 100) + 
        ((COUNT(a.idkar) * c.percent_e) / 100))) AS target_c, 
        ROUND((COUNT(a.idkar) * c.percent_d) /100 , 0) AS target_d, 
        ROUND((COUNT(a.idkar) * c.percent_e) / 100) AS target_e, 
        (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + (COUNT(a.idkar) - (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100))) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100)) AS Total, (c.percent_a + c.percent_b + c.percent_c + c.percent_d + c.percent_e) AS Total_Percent, COUNT(a.idkar) AS total_subo
        FROM atasan AS a
        LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar = a.id_atasan
        LEFT JOIN karyawan_$tahunperiode AS k ON k.id = a.idkar
        LEFT JOIN kriteria AS c ON c.grade = b.kpi_unit AND c.tahun = '$tahunperiode' AND c.kesimpulan='$resultKriteria[JG23]' 
        WHERE id_atasan = '$idmaster_pa' AND k.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')";

    $resultTarget23 = $koneksi->query($queryTarget23);

    $queryTarget45 = "SELECT c.ranges, c.grade, c.percent_a, c.percent_b, c.percent_c, c.percent_d, c.percent_e, 
        ROUND((COUNT(a.idkar) * c.percent_a) / 100) AS target_a, 
        ROUND((COUNT(a.idkar) * c.percent_b) / 100) AS target_b, 
        ROUND(COUNT(a.idkar) - (((COUNT(a.idkar) * c.percent_a) / 100) + 
        ((COUNT(a.idkar) * c.percent_b) / 100) + 
        ((COUNT(a.idkar) * c.percent_d) / 100) + 
        ((COUNT(a.idkar) * c.percent_e) / 100))) AS target_c, 
        ROUND((COUNT(a.idkar) * c.percent_d) /100 , 0) AS target_d, 
        ROUND((COUNT(a.idkar) * c.percent_e) / 100) AS target_e, 
        (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + (COUNT(a.idkar) - (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100))) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100)) AS Total, (c.percent_a + c.percent_b + c.percent_c + c.percent_d + c.percent_e) AS Total_Percent, COUNT(a.idkar) AS total_subo
        FROM atasan AS a
        LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar = a.id_atasan
        LEFT JOIN karyawan_$tahunperiode AS k ON k.id = a.idkar
        LEFT JOIN kriteria AS c ON c.grade = b.kpi_unit AND c.tahun = '$tahunperiode' AND c.kesimpulan='$resultKriteria[JG45]' 
        WHERE id_atasan = '$idmaster_pa' AND k.Kode_Golongan IN ('GL013','GL014','GL016','GL017')";

    $resultTarget45 = $koneksi->query($queryTarget45);

    $queryTarget67 = "SELECT c.ranges, c.grade, c.percent_a, c.percent_b, c.percent_c, c.percent_d, c.percent_e, 
        ROUND((COUNT(a.idkar) * c.percent_a) / 100) AS target_a, 
        ROUND((COUNT(a.idkar) * c.percent_b) / 100) AS target_b, 
        ROUND(COUNT(a.idkar) - (((COUNT(a.idkar) * c.percent_a) / 100) + 
        ((COUNT(a.idkar) * c.percent_b) / 100) + 
        ((COUNT(a.idkar) * c.percent_d) / 100) + 
        ((COUNT(a.idkar) * c.percent_e) / 100))) AS target_c, 
        ROUND((COUNT(a.idkar) * c.percent_d) /100 , 0) AS target_d, 
        ROUND((COUNT(a.idkar) * c.percent_e) / 100) AS target_e, 
        (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + (COUNT(a.idkar) - (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100))) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100)) AS Total, (c.percent_a + c.percent_b + c.percent_c + c.percent_d + c.percent_e) AS Total_Percent, COUNT(a.idkar) AS total_subo
        FROM atasan AS a
        LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar = a.id_atasan
        LEFT JOIN karyawan_$tahunperiode AS k ON k.id = a.idkar
        LEFT JOIN kriteria AS c ON c.grade = b.kpi_unit AND c.tahun = '$tahunperiode' AND c.kesimpulan='$resultKriteria[JG67]'
        WHERE id_atasan = '$idmaster_pa' AND k.Kode_Golongan IN ('GL020','GL021','GL024','GL025')";

    $resultTarget67 = $koneksi->query($queryTarget67);

    $queryTarget89 = "SELECT c.ranges, c.grade, c.percent_a, c.percent_b, c.percent_c, c.percent_d, c.percent_e, 
        ROUND((COUNT(a.idkar) * c.percent_a) / 100) AS target_a, 
        ROUND((COUNT(a.idkar) * c.percent_b) / 100) AS target_b, 
        ROUND(COUNT(a.idkar) - (((COUNT(a.idkar) * c.percent_a) / 100) + 
        ((COUNT(a.idkar) * c.percent_b) / 100) + 
        ((COUNT(a.idkar) * c.percent_d) / 100) + 
        ((COUNT(a.idkar) * c.percent_e) / 100))) AS target_c, 
        ROUND((COUNT(a.idkar) * c.percent_d) /100 , 0) AS target_d, 
        ROUND((COUNT(a.idkar) * c.percent_e) / 100) AS target_e, 
        (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + (COUNT(a.idkar) - (ROUND((COUNT(a.idkar) * c.percent_a) / 100) + ROUND((COUNT(a.idkar) * c.percent_b) / 100) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100))) + ROUND((COUNT(a.idkar) * c.percent_d) / 100) + ROUND((COUNT(a.idkar) * c.percent_e) / 100)) AS Total, (c.percent_a + c.percent_b + c.percent_c + c.percent_d + c.percent_e) AS Total_Percent, COUNT(a.idkar) AS total_subo
        FROM atasan AS a
        LEFT JOIN kpi_unit_$tahunperiode AS b ON b.idkar = a.id_atasan
        LEFT JOIN karyawan_$tahunperiode AS k ON k.id = a.idkar
        LEFT JOIN kriteria AS c ON c.grade = b.kpi_unit AND c.tahun = '$tahunperiode' AND c.kesimpulan='$resultKriteria[JG89]'
        WHERE id_atasan = '$idmaster_pa' AND k.Kode_Golongan IN ('GL028','GL029','GL031','GL032')";

    $resultTarget89 = $koneksi->query($queryTarget89);

    $targetRating23 = $resultTarget23->fetch(PDO::FETCH_ASSOC);
    $targetRating45 = $resultTarget45->fetch(PDO::FETCH_ASSOC);
    $targetRating67 = $resultTarget67->fetch(PDO::FETCH_ASSOC);
    $targetRating89 = $resultTarget89->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}

try {
    $sql = "SELECT
    SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) AS A,
    SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) AS B,
    SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) AS C,
    SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) AS D,
    SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
  FROM (
    SELECT
      CASE
        WHEN b.rating = 5 THEN 'A'
        WHEN b.rating = 4 THEN 'B'
        WHEN b.rating = 3 THEN 'C'
        WHEN b.rating = 2 THEN 'D'
        WHEN b.rating = 1 THEN 'E'
        ELSE 'no rating'
      END AS convertRating
    FROM transaksi_2023_final AS b
    LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
    LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
    LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
    WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
  ) AS subquery";

    $result = $koneksi->query($sql);

    $rating = $result->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

try {
   
    $query23 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL004','GL005','GL006','GL007','GL008','GL009')  -- condition
    ) AS subquery";
    $query45 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL013','GL014','GL016','GL017')  -- condition
    ) AS subquery";
    $query67 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL020','GL021','GL024','GL025')  -- condition
    ) AS subquery";
    $query89 = "SELECT
    COALESCE(SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END), 0) AS A,
    COALESCE(SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END), 0) AS B,
    COALESCE(SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END), 0) AS C,
    COALESCE(SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END), 0) AS D,
    COALESCE(SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END), 0) AS E,
    SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) AS Total,
    (SUM(CASE WHEN convertRating = 'A' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_A,
    (SUM(CASE WHEN convertRating = 'B' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_B,
    (SUM(CASE WHEN convertRating = 'C' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_C,
    (SUM(CASE WHEN convertRating = 'D' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_D,
    (SUM(CASE WHEN convertRating = 'E' THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Percent_E,
    (SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END) / SUM(CASE WHEN convertRating IN ('A', 'B', 'C', 'D', 'E') THEN 1 ELSE 0 END)) * 100 AS Total_Percent
    FROM (
        SELECT
            CASE
                WHEN b.rating = 5 THEN 'A'
                WHEN b.rating = 4 THEN 'B'
                WHEN b.rating = 3 THEN 'C'
                WHEN b.rating = 2 THEN 'D'
                WHEN b.rating = 1 THEN 'E'
                ELSE 'no rating'
            END AS convertRating
        FROM transaksi_2023_final AS b
        LEFT JOIN karyawan_2023 AS k ON k.id = b.idkar
        LEFT JOIN atasan AS a1 ON a1.idkar = b.idkar AND a1.layer = 'L1'
        LEFT JOIN atasan AS a2 ON a2.idkar = b.idkar AND a2.layer = 'L2'
        LEFT JOIN atasan AS a3 ON a3.idkar = b.idkar AND a3.layer = 'L3'
        WHERE (a1.id_atasan = '$idmaster_pa' OR a2.id_atasan = '$idmaster_pa' OR a3.id_atasan = '$idmaster_pa')
            AND k.Kode_Golongan IN ('GL028','GL029','GL031','GL032')  -- condition
    ) AS subquery";

    $result23 = $koneksi->query($query23);
    $rating23 = $result23->fetch(PDO::FETCH_ASSOC);

    $result45 = $koneksi->query($query45);
    $rating45 = $result45->fetch(PDO::FETCH_ASSOC);

    $result67 = $koneksi->query($query67);
    $rating67 = $result67->fetch(PDO::FETCH_ASSOC);

    $result89 = $koneksi->query($query89);
    $rating89 = $result89->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo json_encode(array("error" => $e->getMessage()));
}

?>
<style type="text/css">
.proses {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('dist/img/ellipsis.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .9;
}
</style>
<div id="proses" class="proses" style="display: none"></div>
    <div class="row">
    <section class="col-lg-12 connectedSortable">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#TabRating1"><?php echo "$myrating1"; ?></a>
                </li>
                <li>
                    <a data-toggle="tab" href="#TabRating2" ><?php echo "$myrating2"; ?></a>
                </li>
                <li>
                    <a data-toggle="tab" href="#TabRating3" ><?php echo "$myrating3"; ?></a>
                </li>
                <li>
                    <a data-toggle="tab" href="#TabRating4" ><?php echo "$myrating4"; ?></a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="TabRating1" class="tab-pane active">
                    <div class="section-pending <?= $countPending23 ? '' : 'hidden'; ?>">
                        <label for="pending_table">Pending List</label>
                        <table id="pending_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                                foreach ($pending23 as $row) {
                                    $layer = $row['approval_status']==''?'No Data Appraisal' : 'Pending : '.$row['approval_status'];
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['Nama_Lengkap'] . "</td>";
                                    echo "<td>" . $layer . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-rating <?= $countPending23 ? 'hidden' : ''; ?>">
                        <div class="row">
                            <div class="col-md-1">
                                <input id="target23_a" type="hidden" class="form-control" value="<?= $targetRating23['target_a']; ?>">
                                <input id="target23_b" type="hidden" class="form-control" value="<?= $targetRating23['target_b']; ?>">
                                <input id="target23_c" type="hidden" class="form-control" value="<?= $targetRating23['target_c']; ?>">
                                <input id="target23_d" type="hidden" class="form-control" value="<?= $targetRating23['target_d']; ?>">
                                <input id="target23_e" type="hidden" class="form-control" value="<?= $targetRating23['target_e']; ?>">
                                <input id="total23" type="hidden" class="form-control" value="<?= $targetRating23['Total']; ?>">
                            </div>
                        </div>
                        <div class="row <?= $targetRating23['total_subo'] ? '' : 'hidden'; ?>">
                            <div class="col-md-8">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                                            <th colspan="2" class="success">Targeted Ratings</th>
                                            <th colspan="2" class="warning">Your Ratings</th>
                                        </tr>
                                        <tr>
                                            <th class="success">Employee</th>
                                            <th class="success">%</th>
                                            <th class="warning">Employee</th>
                                            <th class="warning">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A</td>
                                            <td><span><?= $targetRating23['target_a']; ?></span></td>
                                            <td><span><?= number_format($targetRating23['percent_a'], 1); ?>%</span></td>
                                            <td><span id="rate23_a"><?= $rating23['A']; ?></span></td>
                                            <td><span id="percent23_a"><?= number_format($rating23['Percent_A'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>B</td>
                                            <td><span><?= $targetRating23['target_b']; ?></span></td>
                                            <td><span><?= number_format($targetRating23['percent_b'], 1); ?>%</span></td>
                                            <td><span id="rate23_b"><?= $rating23['B']; ?></span></td>
                                            <td><span id="percent23_b"><?= number_format($rating23['Percent_B'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>C</td>
                                            <td><span><?= $targetRating23['target_c']; ?></span></td>
                                            <td><span><?= number_format($targetRating23['percent_c'], 1); ?>%</span></td>
                                            <td><span id="rate23_c"><?= $rating23['C']; ?></span></td>
                                            <td><span id="percent23_c"><?= number_format($rating23['Percent_C'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>D</td>
                                            <td><span><?= $targetRating23['target_d']; ?></span></td>
                                            <td><span><?= number_format($targetRating23['percent_d'], 1); ?>%</span></td>
                                            <td><span id="rate23_d"><?= $rating23['D']; ?></span></td>
                                            <td><span id="percent23_d"><?= number_format($rating23['Percent_D'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>E</td>
                                            <td><span><?= $targetRating23['target_e']; ?></span></td>
                                            <td><span><?= number_format($targetRating23['percent_e'], 1); ?>%</span></td>
                                            <td><span id="rate23_e"><?= $rating23['E']; ?></span></td>
                                            <td><span id="percent23_e"><?= number_format($rating23['Percent_E'], 1); ?>%</span></td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td><?= $targetRating23['Total']; ?></td>
                                            <td><?= number_format($targetRating23['Total_Percent'], 1); ?>%</td>
                                            <td><?= $rating23['Total']; ?></td>
                                            <td><?= number_format($rating23['Total_Percent'], 1); ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submitRating23">Submit Ratings</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" id="exportRating23">Export Ratings</button>
                            </div>
                        </div>
                        <table id="tableRating1" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th>Grade</th>
                                    <th>Unit</th>
                                    <th>Division</th>
                                    <th>Suggested Ratings</th>
                                    <th style="background-color: yellow;">Your Ratings</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div id="TabRating2" class="tab-pane">
                <div class="section-pending <?= $countPending45 ? '' : 'hidden'; ?>">
                        <label for="pending_table">Pending List</label>
                        <table id="pending_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                                foreach ($pending45 as $row) {
                                    $layer = $row['approval_status']==''?'No Data Appraisal' : 'Pending : '.$row['approval_status'];
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['Nama_Lengkap'] . "</td>";
                                    echo "<td>" . $layer . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-rating <?= $countPending45 ? 'hidden' : ''; ?>">
                        <div class="row">
                            <div class="col-md-1">
                                <input id="target45_a" type="hidden" class="form-control" value="<?= $targetRating45['target_a']; ?>">
                                <input id="target45_b" type="hidden" class="form-control" value="<?= $targetRating45['target_b']; ?>">
                                <input id="target45_c" type="hidden" class="form-control" value="<?= $targetRating45['target_c']; ?>">
                                <input id="target45_d" type="hidden" class="form-control" value="<?= $targetRating45['target_d']; ?>">
                                <input id="target45_e" type="hidden" class="form-control" value="<?= $targetRating45['target_e']; ?>">
                                <input id="total45" type="hidden" class="form-control" value="<?= $targetRating45['Total']; ?>">
                            </div>
                        </div>
                        <div class="row <?= $targetRating45['total_subo'] ? '' : 'hidden'; ?>">
                            <div class="col-md-8">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                                            <th colspan="2" class="success">Targeted Ratings</th>
                                            <th colspan="2" class="warning">Your Ratings</th>
                                        </tr>
                                        <tr>
                                            <th class="success">Employee</th>
                                            <th class="success">%</th>
                                            <th class="warning">Employee</th>
                                            <th class="warning">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A</td>
                                            <td><span><?= $targetRating45['target_a']; ?></span></td>
                                            <td><span><?= number_format($targetRating45['percent_a'], 1); ?>%</span></td>
                                            <td><span id="rate45_a"><?= $rating45['A']; ?></span></td>
                                            <td><span id="percent45_a"><?= number_format($rating45['Percent_A'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>B</td>
                                            <td><span><?= $targetRating45['target_b']; ?></span></td>
                                            <td><span><?= number_format($targetRating45['percent_b'], 1); ?>%</span></td>
                                            <td><span id="rate45_b"><?= $rating45['B']; ?></span></td>
                                            <td><span id="percent45_b"><?= number_format($rating45['Percent_B'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>C</td>
                                            <td><span><?= $targetRating45['target_c']; ?></span></td>
                                            <td><span><?= number_format($targetRating45['percent_c'], 1); ?>%</span></td>
                                            <td><span id="rate45_c"><?= $rating45['C']; ?></span></td>
                                            <td><span id="percent45_c"><?= number_format($rating45['Percent_C'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>D</td>
                                            <td><span><?= $targetRating45['target_d']; ?></span></td>
                                            <td><span><?= number_format($targetRating45['percent_d'], 1); ?>%</span></td>
                                            <td><span id="rate45_d"><?= $rating45['D']; ?></span></td>
                                            <td><span id="percent45_d"><?= number_format($rating45['Percent_D'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>E</td>
                                            <td><span><?= $targetRating45['target_e']; ?></span></td>
                                            <td><span><?= number_format($targetRating45['percent_e'], 1); ?>%</span></td>
                                            <td><span id="rate45_e"><?= $rating45['E']; ?></span></td>
                                            <td><span id="percent45_e"><?= number_format($rating45['Percent_E'], 1); ?>%</span></td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td><?= $targetRating45['Total']; ?></td>
                                            <td><?= number_format($targetRating45['Total_Percent'], 1); ?>%</td>
                                            <td><?= $rating45['Total']; ?></td>
                                            <td><?= number_format($rating45['Total_Percent'], 1); ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submitRating45">Submit Ratings</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" id="exportRating45">Export Ratings</button>
                            </div>
                        </div>
                            <table id="tableRating2" class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Grade</th>
                                        <th>Unit</th>
                                        <th>Division</th>
                                        <th>Suggested Ratings</th>
                                        <th style="background-color: yellow;">Your Ratings</th>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                </div>
                <div id="TabRating3" class="tab-pane">
                <div class="section-pending <?= $countPending67 ? '' : 'hidden'; ?>">
                        <label for="pending_table">Pending List</label>
                        <table id="pending_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                                foreach ($pending67 as $row) {
                                    $layer = $row['approval_status']==''?'No Data Appraisal' : 'Pending : '.$row['approval_status'];
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['Nama_Lengkap'] . "</td>";
                                    echo "<td>" . $layer . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-rating <?= $countPending67 ? 'hidden' : ''; ?>">
                        <div class="row">
                            <div class="col-md-1">
                                <input id="target67_a" type="hidden" class="form-control" value="<?= $targetRating67['target_a']; ?>">
                                <input id="target67_b" type="hidden" class="form-control" value="<?= $targetRating67['target_b']; ?>">
                                <input id="target67_c" type="hidden" class="form-control" value="<?= $targetRating67['target_c']; ?>">
                                <input id="target67_d" type="hidden" class="form-control" value="<?= $targetRating67['target_d']; ?>">
                                <input id="target67_e" type="hidden" class="form-control" value="<?= $targetRating67['target_e']; ?>">
                                <input id="total67" type="hidden" class="form-control" value="<?= $targetRating67['Total']; ?>">
                            </div>
                        </div>
                        <div class="row <?= $targetRating67['total_subo'] ? '' : 'hidden'; ?>">
                            <div class="col-md-8">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                                            <th colspan="2" class="success">Targeted Ratings</th>
                                            <th colspan="2" class="warning">Your Ratings</th>
                                        </tr>
                                        <tr>
                                            <th class="success">Employee</th>
                                            <th class="success">%</th>
                                            <th class="warning">Employee</th>
                                            <th class="warning">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A</td>
                                            <td><span><?= $targetRating67['target_a']; ?></span></td>
                                            <td><span><?= number_format($targetRating67['percent_a'], 1); ?>%</span></td>
                                            <td><span id="rate67_a"><?= $rating67['A']; ?></span></td>
                                            <td><span id="percent67_a"><?= number_format($rating67['Percent_A'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>B</td>
                                            <td><span><?= $targetRating67['target_b']; ?></span></td>
                                            <td><span><?= number_format($targetRating67['percent_b'], 1); ?>%</span></td>
                                            <td><span id="rate67_b"><?= $rating67['B']; ?></span></td>
                                            <td><span id="percent67_b"><?= number_format($rating67['Percent_B'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>C</td>
                                            <td><span><?= $targetRating67['target_c']; ?></span></td>
                                            <td><span><?= number_format($targetRating67['percent_c'], 1); ?>%</span></td>
                                            <td><span id="rate67_c"><?= $rating67['C']; ?></span></td>
                                            <td><span id="percent67_c"><?= number_format($rating67['Percent_C'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>D</td>
                                            <td><span><?= $targetRating67['target_d']; ?></span></td>
                                            <td><span><?= number_format($targetRating67['percent_d'], 1); ?>%</span></td>
                                            <td><span id="rate67_d"><?= $rating67['D']; ?></span></td>
                                            <td><span id="percent67_d"><?= number_format($rating67['Percent_D'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>E</td>
                                            <td><span><?= $targetRating67['target_e']; ?></span></td>
                                            <td><span><?= number_format($targetRating67['percent_e'], 1); ?>%</span></td>
                                            <td><span id="rate67_e"><?= $rating67['E']; ?></span></td>
                                            <td><span id="percent67_e"><?= number_format($rating67['Percent_E'], 1); ?>%</span></td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td><?= $targetRating67['Total']; ?></td>
                                            <td><?= number_format($targetRating67['Total_Percent'], 1); ?>%</td>
                                            <td><?= $rating67['Total']; ?></td>
                                            <td><?= number_format($rating67['Total_Percent'], 1); ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submitRating67">Submit Ratings</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" id="exportRating67">Export Ratings</button>
                            </div>
                        </div>
                            <table id="tableRating3" class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Grade</th>
                                        <th>Unit</th>
                                        <th>Division</th>
                                        <th>Suggested Ratings</th>
                                        <th style="background-color: yellow;">Your Ratings</th>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                </div>
                <div id="TabRating4" class="tab-pane">
                <div class="section-pending <?= $countPending89 ? '' : 'hidden'; ?>">
                        <label for="pending_table">Pending List</label>
                        <table id="pending_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                                foreach ($pending89 as $row) {
                                    $layer = $row['approval_status']==''?'No Data Appraisal' : 'Pending : '.$row['approval_status'];
                                    echo "<tr>";
                                    echo "<td>" . $no . "</td>";
                                    echo "<td>" . $row['Nama_Lengkap'] . "</td>";
                                    echo "<td>" . $layer . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="section-rating <?= $countPending89 ? 'hidden' : ''; ?>">
                        <div class="row">
                            <div class="col-md-1">
                                <input id="target89_a" type="hidden" class="form-control" value="<?= $targetRating89['target_a']; ?>">
                                <input id="target89_b" type="hidden" class="form-control" value="<?= $targetRating89['target_b']; ?>">
                                <input id="target89_c" type="hidden" class="form-control" value="<?= $targetRating89['target_c']; ?>">
                                <input id="target89_d" type="hidden" class="form-control" value="<?= $targetRating89['target_d']; ?>">
                                <input id="target89_e" type="hidden" class="form-control" value="<?= $targetRating89['target_e']; ?>">
                                <input id="total89" type="hidden" class="form-control" value="<?= $targetRating89['Total']; ?>">
                            </div>
                        </div>
                        <div class="row <?= $targetRating89['total_subo'] ? '' : 'hidden'; ?>">
                            <div class="col-md-8">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="info" style="vertical-align: middle;">KPI</th>
                                            <th colspan="2" class="success">Targeted Ratings</th>
                                            <th colspan="2" class="warning">Your Ratings</th>
                                        </tr>
                                        <tr>
                                            <th class="success">Employee</th>
                                            <th class="success">%</th>
                                            <th class="warning">Employee</th>
                                            <th class="warning">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>A</td>
                                            <td><span><?= $targetRating89['target_a']; ?></span></td>
                                            <td><span><?= number_format($targetRating89['percent_a'], 1); ?>%</span></td>
                                            <td><span id="rate89_a"><?= $rating89['A']; ?></span></td>
                                            <td><span id="percent89_a"><?= number_format($rating89['Percent_A'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>B</td>
                                            <td><span><?= $targetRating89['target_b']; ?></span></td>
                                            <td><span><?= number_format($targetRating89['percent_b'], 1); ?>%</span></td>
                                            <td><span id="rate89_b"><?= $rating89['B']; ?></span></td>
                                            <td><span id="percent89_b"><?= number_format($rating89['Percent_B'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>C</td>
                                            <td><span><?= $targetRating89['target_c']; ?></span></td>
                                            <td><span><?= number_format($targetRating89['percent_c'], 1); ?>%</span></td>
                                            <td><span id="rate89_c"><?= $rating89['C']; ?></span></td>
                                            <td><span id="percent89_c"><?= number_format($rating89['Percent_C'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>D</td>
                                            <td><span><?= $targetRating89['target_d']; ?></span></td>
                                            <td><span><?= number_format($targetRating89['percent_d'], 1); ?>%</span></td>
                                            <td><span id="rate89_d"><?= $rating89['D']; ?></span></td>
                                            <td><span id="percent89_d"><?= number_format($rating89['Percent_D'], 1); ?>%</span></td>
                                        </tr>
                                        <tr>
                                            <td>E</td>
                                            <td><span><?= $targetRating89['target_e']; ?></span></td>
                                            <td><span><?= number_format($targetRating89['percent_e'], 1); ?>%</span></td>
                                            <td><span id="rate89_e"><?= $rating89['E']; ?></span></td>
                                            <td><span id="percent89_e"><?= number_format($rating89['Percent_E'], 1); ?>%</span></td>
                                        </tr>
                                        <tr class="text-bold">
                                            <td>Total</td>
                                            <td><?= $targetRating89['Total']; ?></td>
                                            <td><?= number_format($targetRating89['Total_Percent'], 1); ?>%</td>
                                            <td><?= $rating89['Total']; ?></td>
                                            <td><?= number_format($rating89['Total_Percent'], 1); ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" id="submitRating89">Submit Ratings</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" id="exportRating89">Export Ratings</button>
                            </div>
                        </div>
                            <table id="tableRating4" class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Grade</th>
                                        <th>Unit</th>
                                        <th>Division</th>
                                        <th>Suggested Ratings</th>
                                        <th style="background-color: yellow;">Your Ratings</th>
                                    </tr>
                                </thead>
                            </table>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    </div>

</div>

<script>
    $(document).ready(function () {
        let table1 = $("#tableRating1").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating&jg=23",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });

        let table2 = $("#tableRating2").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating&jg=45",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;

                    }

                },
            ]
        });
        let table3 = $("#tableRating3").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating&jg=67",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });
        let table4 = $("#tableRating4").DataTable({
            "bPaginate": true,
            "bInfo": true,
            "autoWidth": false,
            "processing": true,
            "language": {
                "loadingRecords": "<span class='fa-stack fa-lg' style='margin-left: 50%;'>\n\
                                    <i class='fa fa-refresh fa-spin fa-fw fast-spin' style='color:rgb(75, 183, 245);'></i>\n\
                                </span>",
            },
            "ajax": "apiController.php?code=getRating&jg=89",
            "type": "GET",
            "columns": [
                { "data": 'no', "name": 'id', render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                { "data": 'Nama_Lengkap' },
                { "data": 'Nama_Jabatan' },
                { "data": 'Nama_Golongan' },
                { "data": 'Nama_OU' },
                { "data": 'Nama_Departemen' },
                { "data": 'convertRating' },
                {
                    data: null,
                    render: function (data, type, row) {
                            var selectHtml = '<select style="width: 100%;" class="form-control" name="rating_value" id="rating_value" required>';
                            
                            var options = [
                                { value: '5', label: 'A' },
                                { value: '4', label: 'B' },
                                { value: '3', label: 'C' },
                                { value: '2', label: 'D' },
                                { value: '1', label: 'E' }
                            ];
                            
                            for (var i = 0; i < options.length; i++) {
                                var selectedAttribute = data.rating == options[i].value ? 'selected' : '';
                                selectHtml += '<option value="' + options[i].value + '" ' + selectedAttribute + '>' + options[i].label + '</option>';
                            }
                            
                            selectHtml += '</select>';
                            
                            return selectHtml;
                    }

                },
            ]
        });

        table1.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            let ratingElementIds = ["percent23_e", "percent23_d", "percent23_c", "percent23_b", "percent23_a"];
            // Iterate through each row in the DataTable
            table1.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            for (let i = 1; i <= 5; i++) {
                let ratingKey = i.toString();
                let count = ratingCounts[ratingKey];
                let percentage = (count / totalCount) * 100;
                $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");
            }

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#rate23_a").text(ratingCounts['5']);
            $("#rate23_b").text(ratingCounts['4']);
            $("#rate23_c").text(ratingCounts['3']);
            $("#rate23_d").text(ratingCounts['2']);
            $("#rate23_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table2.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            let ratingElementIds = ["percent45_e", "percent45_d", "percent45_c", "percent45_b", "percent45_a"];
            // Iterate through each row in the DataTable
            table2.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            // Calculate the percentage for each rating value and update the corresponding elements
            for (let i = 1; i <= 5; i++) {
                let ratingKey = i.toString();
                let count = ratingCounts[ratingKey];
                let percentage = (count / totalCount) * 100;
                $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");
            }

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#rate45_a").text(ratingCounts['5']);
            $("#rate45_b").text(ratingCounts['4']);
            $("#rate45_c").text(ratingCounts['3']);
            $("#rate45_d").text(ratingCounts['2']);
            $("#rate45_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table3.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            let ratingElementIds = ["percent67_e", "percent67_d", "percent67_c", "percent67_b", "percent67_a"];
            // Iterate through each row in the DataTable
            table3.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);

            for (let i = 1; i <= 5; i++) {
                let ratingKey = i.toString();
                let count = ratingCounts[ratingKey];
                let percentage = (count / totalCount) * 100;
                $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");
            }

            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#rate67_a").text(ratingCounts['5']);
            $("#rate67_b").text(ratingCounts['4']);
            $("#rate67_c").text(ratingCounts['3']);
            $("#rate67_d").text(ratingCounts['2']);
            $("#rate67_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

        table4.on('change', '#rating_value', function() {
            let selectedValues = [];

            let ratingCounts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
            let ratingElementIds = ["percent89_e", "percent89_d", "percent89_c", "percent89_b", "percent89_a"];
            // Iterate through each row in the DataTable
            table4.rows().every(function () {
                let rowData = this.data();
                let selectedValue = $(this.node()).find('select[name="rating_value"]').val();
                selectedValues.push({ id: rowData.id, rating: selectedValue });

                // Increment the count for the selected rating value
                if (selectedValue in ratingCounts) {
                    ratingCounts[selectedValue]++;
                } else {
                    // Handle the selected value as needed
                }
            });

            // Calculate the total count
            let totalCount = Object.values(ratingCounts).reduce((total, count) => total + count, 0);
            for (let i = 1; i <= 5; i++) {
                let ratingKey = i.toString();
                let count = ratingCounts[ratingKey];
                let percentage = (count / totalCount) * 100;
                $("#" + ratingElementIds[i - 1]).text(percentage.toFixed(1) + "%");
            }
            
            // You can access the count for each rating value in the ratingCounts object
            console.log("Rating Counts:", ratingCounts);

            // Update the HTML of the <span> elements with counts
            $("#rate89_a").text(ratingCounts['5']);
            $("#rate89_b").text(ratingCounts['4']);
            $("#rate89_c").text(ratingCounts['3']);
            $("#rate89_d").text(ratingCounts['2']);
            $("#rate89_e").text(ratingCounts['1']);
            // You can perform any further actions with the selected values and counts here.
        });

    function matchContent(value) {
        const elements = [value+'_a', value+'_b', value+'_c', value+'_d', value+'_e'];
        const employee = $('#total'+value).val();
        const tables   = value==='23'? table1 : (value==='45'? table2 : (value==='67'? table3 : table4));
        const id_atasan = $('#id_atasan').val();
        let allMatch = true;

        for (const element of elements) {
            const rateContent = parseInt(document.getElementById(`rate${element}`).textContent);
            const targetValue = parseInt(document.getElementById(`target${element}`).value);
            const tdElement = document.querySelector(`td span#rate${element}`).parentElement;

            if (element === value+'_a') {
                if (employee>=2 || rateContent <= targetValue) {
                    tdElement.classList.remove("danger");
                    tdElement.classList.add("success");
                } else {
                    // alert(`Rating ( ${element.toUpperCase()} ) allocation must be less than or equal to ${targetValue} employees`);
                    tdElement.classList.add("danger");
                    allMatch = false;
                }
            } else if (element === value+'_b') {
                if (employee>=1 || rateContent <= targetValue) {
                    tdElement.classList.remove("danger");
                    tdElement.classList.add("success");
                } else {
                    // alert(`Rating ( ${element.toUpperCase()} ) allocation must be less than or equal to ${targetValue} employees`);
                    tdElement.classList.add("danger");
                    allMatch = false;
                }
            } else if (element === value+'_c') {
                if (employee>=1 || rateContent === targetValue) {
                    tdElement.classList.remove("danger");
                    tdElement.classList.add("success");
                } else {
                    // alert(`Rating ( ${element.toUpperCase()} ) allocation must be exactly ${targetValue} employees`);
                    tdElement.classList.add("danger");
                    allMatch = false;
                }
            } else if (element === value+'_d') {
                const rateContentE = parseInt(document.getElementById('rate'+value+'_e').textContent);
                if (rateContent + rateContentE >= targetValue) {
                    tdElement.classList.remove("danger");
                    tdElement.classList.add("success");
                } else {
                    // alert(`The combined rating of ( ${element.toUpperCase()} and E ) must be greater than or equal to ${targetValue} employees`);
                    tdElement.classList.add("danger");
                    allMatch = false;
                }
            } else if (element === value+'_e') {
                if (rateContent >= targetValue) {
                    tdElement.classList.remove("danger");
                    tdElement.classList.add("success");
                } else {
                    // alert(`Rating allocation must be greater than or equal to ${targetValue} employees`);
                    tdElement.classList.add("danger");
                    allMatch = false;
                }
            }
        }

        if(!allMatch){
            alert(`Rating allocation is not match, please re-adjust Your Ratings`);
        }

        if (allMatch) {
            // Add "success" class to <td> elements containing <span> elements with IDs from the array
            for (const element of elements) {
                const tdElement = document.querySelector(`td span#rate${element}`).parentElement;
                tdElement.classList.add("success");
            }
            const confirmSubmit = confirm("All ratings match. Do you want to submit?");
            if (confirmSubmit) {
                let results = [];
                // Iterate through each row in the DataTable
                tables.rows().every(function () {
                    let rowData = this.data();
                    let selectedValue = $(this.node()).find('select[name="rating_value"]').val();

                    let rowObject = {
                        "id": rowData.id,
                        "rating": selectedValue,
                        "idkar": rowData.idkar,
                        "idpic": rowData.id_atasan,
                        "id_atasan": id_atasan,
                    };

                    results.push(rowObject);

                });
                // console.log(results);
                // Create the data to send as a POST request
                let postData = {
                    results: results
                };

                $.ajax({
                    type: "POST",
                    url: "apiController.php?code=updateRating", // Replace with the actual URL to which you want to send the data
                    data: JSON.stringify(postData),
                    success: function(response) {
                        // Handle the response from the server
                        console.log("POST request successful:", response);
                        
                    },
                    error: function(error) {
                        // Handle any errors that occur during the POST request
                        console.error("POST request failed:", error);
                    }
                });
            }
        }
    }

    function exportExcel(value){
        const tables   = value==='23'? table1 : (value==='45'? table2 : (value==='67'? table3 : table4));
        let results = [];
        // Iterate through each row in the DataTable
        tables.rows().every(function () {
            let rowData = this.data();
            let selectedValue = $(this.node()).find('select[name="rating_value"]').val();

            let rowObject = {
                "Nama_Lengkap": rowData.Nama_Lengkap,
                "Nama_Jabatan": rowData.Nama_Jabatan,
                "Nama_Golongan": rowData.Nama_Golongan,
                "suggestedRating": rowData.rating,
                "proposedRating": selectedValue,
                "exportBy": rowData.nama_atasan_view,
                "Nama_Departemen": rowData.Nama_Departemen,
            };

            results.push(rowObject);

        });

        if (results.length === 0) {
            alert('No data to export.');
            return; // Stop further execution
        }

        fetch('exportRating.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ 
                results: results 
            }),
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'rating_pa.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        });
           
    }

    document.getElementById("submitRating23").addEventListener("click", function() {
        matchContent('23');
    });

    document.getElementById("submitRating45").addEventListener("click", function() {
        matchContent('45');
    });

    document.getElementById("submitRating67").addEventListener("click", function() {
        matchContent('67');
    });

    document.getElementById("submitRating89").addEventListener("click", function() {
        matchContent('89');
    });

    document.getElementById("exportRating23").addEventListener("click", function() {
        exportExcel('23');
    });

    document.getElementById("exportRating45").addEventListener("click", function() {
        exportExcel('45');
    });

    document.getElementById("exportRating67").addEventListener("click", function() {
        exportExcel('67');
    });

    document.getElementById("exportRating89").addEventListener("click", function() {
        exportExcel('89');
    });


    })
</script>