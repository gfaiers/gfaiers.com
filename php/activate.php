<?php
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
$token = $_GET['v'];
$sql_usres_to_activate_select = "SELECT * FROM users_to_activate WHERE token = '$token'";
$check = mysqli_query($connection, $sql_usres_to_activate_select) or die("B".mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    // this should only run through once, as only one email will be found
    while($row_users_to_activate = mysqli_fetch_assoc($check)) {
        // read the correct values
        $enc_email = $row_users_to_activate['id'];
        $hash = $row_users_to_activate['password'];
        $enc_first_name = $row_users_to_activate['first_name'];
        $enc_surname = $row_users_to_activate['surname'];
        $rights = $row_users_to_activate['rights'];
        $enc_iv = $row_users_to_activate['iv'];
    }
} else {
    // If the user doesn't appear in the login_attempts table, then there is an error
    mysqli_close($connection);
    die('Link expired');
}
$sql_usres_to_activate_delete = "DELETE FROM users_to_activate WHERE token = '".$token."'";
if (mysqli_query($connection, $sql_usres_to_activate_delete)) {
    // entry deleted
} else {
    die('B<div class="alert alert-danger" role="alert"><h3>Error</h3>Error deleting entry.</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
$email = pkcs7_unpad(openssl_decrypt(
    $enc_email,
    'AES-256-CBC',
    $encryption_key,
    0,
    $secret_iv
));
$count = 0;
$locked = 0;
$time = null;
$rights = 0;
$sql_users= "INSERT INTO users (id, password, first_name, surname, rights, iv) VALUES ('".$enc_email."', '".$hash."', '".$enc_first_name."', '".$enc_surname."', '".$rights."', '".$enc_iv."')";
$sql_users_insert = "INSERT INTO login_attempts (id, time, count, locked) VALUES ('".$enc_email."', '".$time."', '".$count."', '".$locked."')";
if (mysqli_query($connection, $sql_users)) { // save to the users table
    if (mysqli_query($connection, $sql_users_insert)) { // save to the login_attempts table
        // account varified
        mysqli_close($connection);
        $subject = "gfaiers.com registration";
$message = 'Thanks for registering to gfaiers.com, '.$first_name.' '.$surname.'.
Your account is now activated and ready to use.  Please navigate to www.gfaiers.com and login through the navigation menu.

Many thanks,
Geoff Faiers
www.gfaiers.com

Please don\'t reply to this email, I can be contacted via the website.';
        $headers = "From: noreply@gfaiers.com";
        mail($email,$subject,$message,$headers);
        die("<script>window.close();</script>");
    } else {
        mysqli_close($connection);
        die('B<div class="alert alert-danger" role="alert"><h3>Error</h3>' . $sql . '<br/>' . mysqli_error($connection) .'</div>');
    }
} else {
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Error</h3>' . $sql . '<br/>' . mysqli_error($connection) .'</div>');
}