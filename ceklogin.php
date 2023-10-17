<?php
include("conf/conf.php");

// Validate and sanitize user input
$username = $_POST['username'];
$password = $_POST['password'];

$pengacak = "HJBDSUYGQ783242BHJSSDFSD";

try {
    // Establish a PDO database connection

    // Prepare a SQL statement to retrieve user data
    $stmt = $koneksi->prepare("SELECT id, pic, password, active FROM user_pa WHERE username = :username OR nik_baru = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $rowCount =  $stmt->rowCount();

    if($rowCount){
        if ($row && md5($pengacak . md5($password) . $pengacak) == $row['password'] && $row['active'] == 'Y') {
            session_start();
            $_SESSION['idmaster_pa'] = $row['id'];
    
            $datetime = date('Y-m-d H:i:s');
            $updateStmt = $koneksi->prepare("UPDATE user_pa SET lastip = :ip, lastlogin = :datetime WHERE id = :id");
            $updateStmt->bindParam(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
            $updateStmt->bindParam(':datetime', $datetime, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
    
            if ($updateStmt->execute()) {
                $code = "200";
                $message = "Welcome ".$row['pic'];
            } else {
                $code = "500";
                $message = "Error updating session";
            }
        } else {
            $code = "401";
            $message = "Wrong password";
        }
    } else {
        $code = "404";
        $message = "User not found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$result = array(
    'code' => $code,
    'message' => $message,
);


header('Content-Type: application/json');
echo json_encode($result);

?>