<?php
include("conf/conf.php");

// Validate and sanitize user input
$username = $_POST['username'];
$password = $_POST['password'];

$pengacak = "HJBDSUYGQ783242BHJSSDFSD";

try {
    // Establish a PDO database connection

    // Prepare a SQL statement to retrieve user data
    $stmt = $koneksi->prepare("SELECT id, username, pic, password, active FROM user_pa WHERE username = :username OR nik_baru = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $rowCount =  $stmt->rowCount();

    if($rowCount){
        if ($row && md5($pengacak . md5($password) . $pengacak) == $row['password'] && $row['active'] == 'Y') {
           
            // Set cookies for user session
            setcookie('id', $row['id'], [
                'expires' => time() + (86400 * 30), // Expiration time (30 days)
                'path' => '/',
                'secure' => true, // Require secure connection (HTTPS)
                'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
                'samesite' => 'None' // Set SameSite attribute to None for cross-site access
            ]);

            setcookie('pic', $row['pic'], [
                'expires' => time() + (86400 * 30), // Expiration time (30 days)
                'path' => '/',
                'secure' => true, // Require secure connection (HTTPS)
                'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
                'samesite' => 'None' // Set SameSite attribute to None for cross-site access
            ]);

            setcookie('username', $row['username'], [
                'expires' => time() + (86400 * 90), // Expiration time (30 days)
                'path' => '/',
                'secure' => true, // Require secure connection (HTTPS)
                'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
                'samesite' => 'None' // Set SameSite attribute to None for cross-site access
            ]);

            // setcookie('id', $row['id'], time() + (86400 * 30), "/"); // Cookie for id
            // setcookie('id', $row['id'], time() + 30, "/"); // Cookie for id
            // setcookie('pic', $row['pic'], time() + (86400 * 30), "/"); // Cookie for pic
            // setcookie('pic', $row['pic'], time() + 30, "/"); // Cookie for pic
    
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
