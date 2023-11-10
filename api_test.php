<?php
// Include your database connection and functions
include ('conf/conf.php');
// include("function_test.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $idkar = $_POST['idkar'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $createdBy = $_POST['created_by'];

    try {
        $query = "INSERT INTO transaksi_2023_final_ (idkar, title, content, created_by, approval_status) VALUES (:idkar, :title, :content, :createdBy, 'Pending')";

        $stmt = $koneksi->prepare($query);
        $stmt->bindParam(':idkar', $idkar, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':createdBy', $createdBy, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>window.location='home.php?link=test_form';</script>";
        } else {
            echo "<script>window.location='home.php?link=test_form';</script>";
        }
        // Redirect to a success page or perform any other necessary action
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    
    exit();

}
?>
