<?php 
include("conf/conf.php");

// setcookie('id', '', time() - 3600, '/');
// setcookie('pic', '', time() - 3600, '/');
// setcookie('cookieConsent', '', time() - 3600, '/');

setcookie('id', '', [
    'expires' => time() - 3600, // Expiration time (30 days)
    'path' => '/',
    'secure' => true, // Require secure connection (HTTPS)
    'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
    'samesite' => 'None' // Set SameSite attribute to None for cross-site access
]);

setcookie('pic', '', [
    'expires' => time() - 3600, // Expiration time (30 days)
    'path' => '/',
    'secure' => true, // Require secure connection (HTTPS)
    'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
    'samesite' => 'None' // Set SameSite attribute to None for cross-site access
]);


header('Location: '.$base_url);

?>