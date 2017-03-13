<?php
include_once("../includes/sessions.php");
include_once("../includes/db_connect.php");
include_once("../includes/functions.php");
include_once("../includes/security.php");

// this needs to delete the record from the db for the cookie

if (isset($_COOKIE[$cookie_name])) {
    $cookie = pkcs7_unpad(openssl_decrypt(
        $_COOKIE[$cookie_name],
        'AES-256-CBC',
        $cookie_key,
        0,
        $cookie_iv
    ));
    
    $cookie_email = substr($cookie, 64, strlen($cookie));
    $old_session = substr($cookie, 0, 32);
    
    // delete the old cookie from the database
    $sql_auth_login_delete = "DELETE FROM auth_tokens WHERE session='$old_session'";
    if (mysqli_query($connection, $sql_auth_login_delete)) { // save to the auth_login table
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
    }
}
session_destroy();