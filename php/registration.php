<?php
// initial check to make sure they've navigated to the document correctly
$email = strtolower($_POST['email_post']);
if ($email == ''){
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
// checks if the email is in use
// encrypt the email address the first time, to save as the ID.
$enc_email = openssl_encrypt(
    pkcs7_pad($email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);

// find if the encrypted email address is registered in the database
// select each ID in USERS table which matches the EMAIL entered
$sql = "SELECT id FROM users WHERE id = '$enc_email'";
$check = mysqli_query($connection, $sql) or die("B".mysqli_error($connection));
$check2 = mysqli_num_rows($check);
// if the name exists it gives an error
if ($check2 != 0) {
    // the number of rows isn't 0 so there is already someone registered with this email
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Error</h3>' . $email . ' is already registered on this site.</div>');
}

// the email address hasn't been found, so continue with everything else
$first_name = ucwords(strtolower($_POST['first_name_post']));
$surname = ucwords(strtolower($_POST['surname_post']));
$password = $_POST['password_post'];
$count = 0;
$locked = 0;
$time = null;
$rights = 0;
// here we hash the password
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);

// $strong will be true if the key is crypto safe

$iv_size = 16; // 128 bits
$iv = openssl_random_pseudo_bytes($iv_size, $strong);

$enc_first_name = openssl_encrypt(
    pkcs7_pad($first_name, 16), // padded data
    'AES-256-CBC',              // cipher and mode
    $encryption_key,            // secret key
    0,                          // options (not used)
    $iv                         // initialisation vector
);
$enc_surname = openssl_encrypt(
    pkcs7_pad($surname, 16),    // padded data
    'AES-256-CBC',              // cipher and mode
    $encryption_key,            // secret key
    0,                          // options (not used)
    $iv                         // initialisation vector
);
$enc_iv = openssl_encrypt(
    pkcs7_pad($iv, 16),     // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector
);
// now we insert it into the database users_to_activate
$token = md5(rand(0,9000)); // this also needs to check that there are no tokens with the same number in the database (if the website ever becomes popular then this will be a must as user accounts will clash on registration.)
$sql = "INSERT INTO users_to_activate (token, id, password, first_name, surname, rights, iv) VALUES ('".$token."', '".$enc_email."', '".$hash."', '".$enc_first_name."', '".$enc_surname."', '".$rights."', '".$enc_iv."')";
if (mysqli_query($connection, $sql)) { // save to the users_to_activate table
    // mail use the link with token to let them activate the account
    $subject = "gfaiers.com registration";
$message = 'Thanks for registering to gfaiers.com, '.$first_name.' '.$surname.'.
Please click this link to activate your account and complete registration: https://www.gfaiers.com/php/activate.php?v='.$token.'

This link will only work for the next 24 hours, after that point you\'ll need to re-register.

Many thanks,
Geoff Faiers
www.gfaiers.com

Please don\'t reply to this email, I can be contacted via the website.';
    $headers = "From: noreply@gfaiers.com";
    mail($email,$subject,$message,$headers);
    mysqli_close($connection);
    die('A<div class="alert alert-success" role="alert"><h3>Success</h3>An email has been sent to '.$email.' with instructions to activate your account</div>');
} else {
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Error</h3>' . $sql . '<br/>' . mysqli_error($connection) .'</div>');
}