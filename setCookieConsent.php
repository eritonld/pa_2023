<?php
// Set the 'cookieConsent' cookie with the SameSite attribute set to None
setcookie('cookieConsent', 'accepted', [
    'expires' => time() + (86400 * 90), // Expiration time (30 days)
    'path' => '/',
    'secure' => true, // Require secure connection (HTTPS)
    'httponly' => true, // Make the cookie accessible only through HTTP(S) requests
    'samesite' => 'None' // Set SameSite attribute to None for cross-site access
]);
?>
