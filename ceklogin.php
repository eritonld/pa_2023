<?php
include("conf/conf.php");
include("function.php");

// Validate and sanitize user input
$username = $_POST['username'];
$password = $_POST['password'];

$expired = 30 * 24 * 60 * 60; // 30 days in seconds
$expiredCookies = 90 * 24 * 60 * 60; // 90 days in seconds

$pengacak = "HJBDSUYGQ783242BHJSSDFSD";

try {
    // Establish a PDO database connection

    // Prepare a SQL statement to retrieve user data
    $stmt = $koneksi->prepare("SELECT id, username, pic, password, active FROM user_pa WHERE username = :username OR nik_baru = :username");
	// echo "SELECT id, username, pic, password, role, active FROM user_pa WHERE username = :username OR nik_baru = :username";
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $rowCount =  $stmt->rowCount();

    // $roleArray = explode(',', $row['role']);

    // if (in_array("user", $roleArray)) {
    // $viewAdmin = 0;
    // } else {
    // $viewAdmin = 1;
    // }

    if($rowCount){
        if ($row && md5($pengacak . md5($password) . $pengacak) == $row['password'] && $row['active'] == 'Y') {
           
            //setCookieWithOptions('id', $row['id'], $expired);
            //setCookieWithOptions('pic', $row['pic'], $expired);
            // if($viewAdmin){
            //     setCookieWithOptions('id_admin', $row['id'], $expired);
            //     setCookieWithOptions('pic_admin', $row['pic'], $expired);
            // }
            //setCookieWithOptions('username', $row['username'], $expiredCookies);
        
        	setcookie('id', $row['id'], time() + $expired, '/');
            setcookie('pic', $row['pic'], time() + $expired, '/');
            setcookie('username', $row['username'], time() + $expiredCookies, '/');
    
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
