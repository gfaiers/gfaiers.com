<?php
include_once 'db_connect.php';
// Check connection
if (!$connection) {
    die('<div class="alert alert-danger" role="alert"><h1>Connection failed</h1>' . mysqli_connect_error() . '</div>');
}
include_once 'functions.php';
include_once("security.php");
$enc_email = $_SESSION['user_id'];
$email = pkcs7_unpad(openssl_decrypt(
    $enc_email,
    'AES-256-CBC',
    $encryption_key,
    0,
    $secret_iv
));
$sql_users_read = "SELECT * FROM users WHERE id = '$enc_email'";
$check = mysqli_query($connection, $sql_users_read) or die('B<div class="alert alert-danger" role="alert">'.mysqli_error($connection).'</div>');
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    // output data of each row
    // this should only run through once, as only one email will be found
    while($row_users = mysqli_fetch_assoc($check)) {
        $enc_iv = $row_users['iv'];
        $rights = $row_users['rights'];
        $enc_first_name = $row_users['first_name'];
        $enc_surname = $row_users['surname'];
        $enc_address_line_1 = $row_users['address_line_1'];
        $enc_address_line_2 = $row_users['address_line_2'];
        $enc_town = $row_users['town'];
        $enc_county = $row_users['county'];
        $enc_postcode = $row_users['postcode'];
        $enc_contact_number = $row_users['contact_number'];
    }
}
// required fields
$iv = pkcs7_unpad(openssl_decrypt(
    $enc_iv,
    'AES-256-CBC',
    $encryption_key,
    0,
    $secret_iv
));
$first_name = pkcs7_unpad(openssl_decrypt(
    $enc_first_name,
    'AES-256-CBC',
    $encryption_key,
    0,
    $iv
));
$surname = pkcs7_unpad(openssl_decrypt(
    $enc_surname,
    'AES-256-CBC',
    $encryption_key,
    0,
    $iv
));
if ($enc_address_line_1 !== NULL) {
    $address_line_1 = pkcs7_unpad(openssl_decrypt(
        $enc_address_line_1,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    ));
    if ($enc_address_line_2 !== NULL) {
        $address_line_2 = pkcs7_unpad(openssl_decrypt(
            $enc_address_line_2,
            'AES-256-CBC',
            $encryption_key,
            0,
            $iv
        ));
    }
    $town = pkcs7_unpad(openssl_decrypt(
        $enc_town,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    ));
    $county = pkcs7_unpad(openssl_decrypt(
        $enc_county,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    ));
    $postcode = pkcs7_unpad(openssl_decrypt(
        $enc_postcode,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    ));
}
if ($enc_contact_number !== NULL) {
    $contact_number = pkcs7_unpad(openssl_decrypt(
        $enc_contact_number,
        'AES-256-CBC',
        $encryption_key,
        0,
        $iv
    ));
}
define("IV", $iv);
define("EMAIL", $email);
define("FIRST_NAME", $first_name);
define("SURNAME", $surname);
define("CONTACT_NUMBER", $contact_number);
define("ADDRESS_LINE_1", $address_line_1);
define("ADDRESS_LINE_2", $address_line_2);
define("TOWN", $town);
define("COUNTY", $county);
define("POSTCODE", $postcode);