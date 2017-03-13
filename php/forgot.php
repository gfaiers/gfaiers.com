<?php
include_once("../includes/sessions.php");
$email = strtolower($_POST['email_post']); // needs to be encrypted
if ($email == '') {
    session_write_close();
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("../includes/db_connect.php");
include_once("../includes/functions.php");
include_once("../includes/security.php");
// encrypt the email address to check 
$enc_email = openssl_encrypt(
    pkcs7_pad($email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);

$sql_users_read = "SELECT * FROM users WHERE id = '$enc_email'";
$check = mysqli_query($connection, $sql_users_read) or die("B".mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    // output data of each row
    // this should only run through once, as only one email will be found
    while($row_users = mysqli_fetch_assoc($check)) {
        $enc_iv = $row_users["iv"];
        $iv = pkcs7_unpad(openssl_decrypt(
            $enc_iv,
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
        $enc_first_name = $row_users["first_name"];
        $first_name = pkcs7_unpad(openssl_decrypt(
            $enc_first_name,
            'AES-256-CBC',
            $encryption_key,
            0,
            $iv
        ));
        $enc_surname = $row_users["surname"];
        $surname = pkcs7_unpad(openssl_decrypt(
            $enc_surname,
            'AES-256-CBC',
            $encryption_key,
            0,
            $iv
        ));
    }
} else {
    session_write_close();
    mysqli_close($connection);
    die("B$email is not registered on gfaiers.com");
}
$code = rand(10000,99999);
$_SESSION['reset_code'] = $code;
$subject = "gfaiers.com reset password";
$message = "$first_name $surname, you have requested to reset your password, if you haven't requested this then please ignore this email.  
Your code for resetting your password is " . $code . "

Many thanks,
Geoff Faiers
www.gfaiers.com

Please don\'t reply to this email, I can be contacted via the website.";
$headers = "From: noreply@gfaiers.com";
mail($email,$subject,$message,$headers);
echo("AReset password email has been sent to $email.");
session_write_close();
mysqli_close($connection);