<?php
include_once("../includes/sessions.php");
$email = $_POST['email_post'];
if ($email == '') {
    session_write_close();
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
// check if the user has got the code correct, if they have then continue
$code = $_POST['code_post'];
if ($code != $_SESSION['reset_code']) {
    // if not then clear the code from the session and send back the error message
    unset($_SESSION['reset_code']);
    session_write_close();
    die('B<div class="alert alert-danger" role="alert">Incorrect code.</div>');
}
unset($_SESSION['reset_code']);
// the user has got to the page correctly, now open the database connection
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    // database error, reset the code and send error
    unset($_SESSION['reset_code']);
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
// encrypt the email so that it can used for the ID for in the users table
$enc_email = openssl_encrypt(
    pkcs7_pad($email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);
$hash = password_hash($_POST['password_post'], PASSWORD_BCRYPT, ['cost' => 13]);
$sql_users = "UPDATE users SET password='".$hash."' WHERE id = '".$enc_email."'";
if (mysqli_query($connection, $sql_users)) {
    // success, updated password
    echo'A<div class="alert alert-success" role="alert">Password changed.</div>';
} else {
    // error, password not updated, email not recorgnised, should never be the casek
    echo'B<div class="alert alert-danger" role="alert">Email not registered.</div>';
}
session_write_close();
mysqli_close($connection);