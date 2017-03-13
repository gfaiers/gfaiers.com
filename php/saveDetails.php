<?php
include_once("../includes/sessions.php");

if ($_SESSION['user_id'] == "") {
    die("Save error, you're not logged in.");
} else {
    $enc_email = $_SESION['user_id'];
}

// read the contents of the table to check if anything needs changing
include_once("../includes/user_reader.php");
include_once("../includes/functions.php");
include_once("../includes/security.php");
$sql_string = "";
if ($_POST['email_post'] !== EMAIL){
    // if this is changed it has to re-send the validation email to check that the account it's being changed to is valid
    $enc_email_new = openssl_encrypt(
        pkcs7_pad($_POST['email_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $secret_iv              // initialisation vector (for set value)
    );
}

if (($_POST['first_name_post'] !== FIRST_NAME) && ($_POST['first_name_post'] !== "")) {
    $enc_first_name = openssl_encrypt(
        pkcs7_pad($_POST['first_name_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "first_name='$enc_first_name'";
    } else {
        $sql_string .= ", first_name='$enc_first_name'";
    }
}
if (($_POST['surname_post'] !== SURNAME) && ($_POST['surname_post'] !== "")) {
    $enc_surname = openssl_encrypt(
        pkcs7_pad($_POST['surname_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "surname='$enc_surname'";
    } else {
        $sql_string .= ", surname='$enc_surname'";
    }
}
if (($_POST['address_line_1_post'] !== ADDRESS_LINE_1) && ($_POST['address_line_1_post'] !== "")) {
    $enc_address_line_1 = openssl_encrypt(
        pkcs7_pad($_POST['address_line_1_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "address_line_1='$enc_address_line_1'";
    } else {
        $sql_string .= ", address_line_1='$enc_address_line_1'";
    }
}
if (($_POST['address_line_2_post'] !== ADDRESS_LINE_2) && ($_POST['address_line_2_post'] !== "")) {
    $enc_address_line_2 = openssl_encrypt(
        pkcs7_pad($_POST['address_line_2_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "address_line_2='$enc_address_line_2'";
    } else {
        $sql_string .= ", address_line_2='$enc_address_line_2'";
    }
}
if (($_POST['town_post'] !== TOWN) && ($_POST['town_post'] !== "")) {
    $enc_town = openssl_encrypt(
        pkcs7_pad($_POST['town_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "town='$enc_town'";
    } else {
        $sql_string .= ", town='$enc_town'";
    }
}
if (($_POST['county_post'] !== COUNTY) && ($_POST['county_post'] !== "")) {
    $enc_county = openssl_encrypt(
        pkcs7_pad($_POST['county_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "county='$enc_county'";
    } else {
        $sql_string .= ", county='$enc_county'";
    }
}
if (($_POST['postcode_post'] !== POSTCODE) && ($_POST['postcode_post'] !== "")) {
    $enc_postcode = openssl_encrypt(
        pkcs7_pad($_POST['postcode_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "postcode='$enc_postcode'";
    } else {
        $sql_string .= ", postcode='$enc_postcode'";
    }
}
if (($_POST['contact_number_post'] !== CONTACT_NUMBER) && ($_POST['contact_number_post'] !== "")) {
    $enc_contact_number = openssl_encrypt(
        pkcs7_pad($_POST['contact_number_post'], 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        IV                      // initialisation vector (for set value)
    );
    if (strlen($sql_string) == 0) {
        $sql_string = "contact_number='$enc_contact_number'";
    } else {
        $sql_string .= ", contact_number='$enc_contact_number'";
    }
}
if ($sql_string === "") {
    die('B<div class="alert alert-danger" role="alert">Nothing new to save.</div>');
}
$sql_users_update = "UPDATE users SET ".$sql_string." WHERE id='".$enc_email."'";
include_once('../includes/db_connect.php');
// Check connection
if (!$connection) {
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
if (!mysqli_query($connection, $sql_users_update)) {
    echo('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_error($connection) . '</div>');
}
// reset the values in the SESSION
$_SESSION['first_name'] = $first_name;
$_SESSION['user_id'] = $enc_email;
echo('A<div class="alert alert-success" role="alert"><h3>Updated</h3>All changes have been saved.</div>');