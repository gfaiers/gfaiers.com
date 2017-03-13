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
// the user has got to the page correctly, now open the database connection
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
$password = $_POST['password_post']; // needs to be hashed
$remember_me = $_POST['remember_me_post']; // "on" for checked, "" for not checked

// encrypt the email address to check 
$enc_email = openssl_encrypt(
    pkcs7_pad($email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);

$sql_login_attempts_read = "SELECT * FROM login_attempts WHERE id = '$enc_email'";
$check = mysqli_query($connection, $sql_login_attempts_read) or die("B".mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    // this should only run through once, as only one email will be found
    while($row_login_attempts = mysqli_fetch_assoc($check)) {
        // read the correct values
        $time = $row_login_attempts["time"]; // this is the time of the last failed login attempt
        $count = $row_login_attempts["count"]; // this is the number of failed login attempts for the account
        $locked = $row_login_attempts["locked"]; // this is the value for if the user is locked out or not
    }
} else {
    // If the user doesn't appear in the login_attempts table, then there is an error
    session_write_close();
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert">'.$email.' is not registered</div>');
}
if ($locked == 1) { // 0 is unlocked
    session_write_close();
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert">'.$email.' is locked out</div>');
}
$sql_users_read = "SELECT * FROM users WHERE id = '$enc_email'";
$check = mysqli_query($connection, $sql_users_read) or die('B<div class="alert alert-danger" role="alert">'.mysqli_error($connection).'</div>');
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
        $rights = $row_users["rights"];
        if (password_verify($password,$row_users["password"])) { // varify the password entered is correct
            // reset the count on login_attempts
            // LOGIN COMPLETE
            $count = 0;
            $time = null;
            $locked = 0;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['user_id'] = $enc_email;
            $_SESSION['rights'] = $rights;
            // to check the value of the posted contact fields, if they are filled then save to table
            $contact_option = $_POST['contact_option_post'];
            $contact_details = $_POST['contact_details_post'];
            $expire = time() + (86400 * 28);
            $expiration = date('Y-m-d H:i:s', $expire); // 86400 = 1 day * 28 = 4 weeks
            if ($contact_option !== "") {
                $to = "geoff@gfaiers.com";
                    reSubmitCommunicationSession: {
                    // it now needs to check if the session is already used in the database
                    $comms_session = bin2hex(openssl_random_pseudo_bytes(16)); // generate the session
                    $iv_size = 16; // 128 bits
                    $session_iv = openssl_random_pseudo_bytes($iv_size, $strong);
                    $sql_communication_search = "SELECT * FROM communication WHERE session ='$comms_session'";
                    $check = mysqli_query($connection, $sql_communication_search) or die('A<div class="alert alert-danger" role="alert">'.mysqli_error($connection).'</div>');
                    $check2 = mysqli_num_rows($check);
                    if ($check2 != 0) { // if a result is found then the session is already in use, generate another
                        goto reSubmitCommunicationSession;
                    }
                }
                $enc_to = openssl_encrypt(
                    pkcs7_pad($to, 16),     // padded data
                    'AES-256-CBC',          // cipher and mode
                    $encryption_key,        // secret key
                    0,                      // options (not used)
                    $secret_iv              // initialisation vector (for set value)
                );
                $enc_request = openssl_encrypt(
                    pkcs7_pad($contact_details, 16),  // padded data
                    'AES-256-CBC',          // cipher and mode
                    $encryption_key,        // secret key
                    0,                      // options (not used)
                    $session_iv              // initialisation vector (for set value)
                );
                $enc_details = openssl_encrypt(
                    pkcs7_pad($contact_option, 16),  // padded data
                    'AES-256-CBC',          // cipher and mode
                    $encryption_key,        // secret key
                    0,                      // options (not used)
                    $session_iv              // initialisation vector (for set value)
                );
                $sql_communication_save = "INSERT INTO communication (session, session_iv, sender, recipient, option, details, date) VALUES ('".$comms_session."', '".$session_iv."', '".$enc_email."', '".$enc_to."', '".$enc_request."', '".$enc_details."', '".$expiration."')";
                if (!mysqli_query($connection, $sql_communication_save)) {
                    die("ACommunication save to database failed: " . $sql_communication_save . ": " . mysqli_error($connection));
                }
            }
            $cookie_name = "hE34uigF977giFEg0897rgh9w";
            if ($remember_me == "on") {
                $cookie_key = 'Pl3SWl9uf28KHn9W';
                $cookie_iv = 'w9Nhk82FU9Lws3Lp';
                
                // SET NEW COOKIE UP
                // cookie_value = token(hashed) and 
                // cookie_value = authenticator(hashed) and 
                // cookie_value = enc_email(different to encryption stored)
                // all encrypted again together
                reSubmitSession: {
                    $session = bin2hex(openssl_random_pseudo_bytes(16)); // generate the session (as it's seen as a new login from the device, so will make a new session in the DB)
                    // it now needs to check if the session is already used in the database

                    $sql_auth_tokens_search = "SELECT * FROM auth_tokens WHERE session ='$session'";
                    $check = mysqli_query($connection, $sql_auth_tokens_search) or die('B<div class="alert alert-danger" role="alert">'.mysqli_error($connection).'</div>');
                    $check2 = mysqli_num_rows($check);
                    if ($check2 != 0) { // if a result is found then the session is already in use, generate another
                        goto reSubmitSession;
                    }
                }
                
                $auth = bin2hex(openssl_random_pseudo_bytes(16)); // new auth token (new one generated each login for the individual login session)
                $auth_hash = password_hash($auth, PASSWORD_BCRYPT, ['cost' => 10]);
                
                $cookie_email = openssl_encrypt(
                    pkcs7_pad($email, 16),  // padded data
                    'AES-256-CBC',          // cipher and mode
                    $cookie_key,        // secret key
                    0,                      // options (not used)
                    $cookie_iv              // initialisation vector (for set value)
                );
                $cookie_temp = $session.$auth.$cookie_email;
                
                $cookie_value = openssl_encrypt(
                    pkcs7_pad($cookie_temp, 16),  // padded data
                    'AES-256-CBC',          // cipher and mode
                    $cookie_key,        // secret key
                    0,                      // options (not used)
                    $cookie_iv              // initialisation vector (for set value)
                );
                // cookie name, value, expiration time, directory ("/" is for whole site) , true is for httponly (javascript can't access cookie)
                setcookie($cookie_name, $cookie_value, $expire, '/', NULL, NULL, true); 
                // save the new cookie in the database
                $sql_auth_login_save = "INSERT INTO auth_tokens (session, auth, userid, expires) VALUES ('".$session."', '".$auth_hash."', '".$enc_email."', '".$expiration."')";
                if (!mysqli_query($connection, $sql_auth_login_save)) { // save to the auth_login table
                    die("BCookie save to database failed");
                }
                echo("A");
            } else {
                unset($_COOKIE[$cookie_name]);
                setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
                echo("A");
            }
        } else {
            // this needs to itterate the count in the database for the user
            $count++;
            $time = date("Y-m-d H:i:s");
            if ($count == 5) {
                $locked = 1;
                $subject = "gfaiers.com account locked";
                $message = "$first_name $surname, your account for gfaiers.com has been locked. Please click this link to unlock the account and set a new password.";
                $headers = "From: noreply@gfaiers.com";
                mail($email,$subject,$message,$headers);
                echo('B<div class="alert alert-danger" role="alert"><h3>Account Locked</h3>Due to too many concecuative failed login attempts the account '.$email.' has now been locked out.  Please check the email account to reset the password and unlock the account.</div>');
            } else {
                $locked = 0;
                echo('C<div class="alert alert-danger" role="alert">Incorrect Password</div>');
            }
        }
    }
}
// save to the login_attempts table
$sql_login_attempts_write = "UPDATE login_attempts SET time='".$time."', count='".$count."', locked='".$locked."' WHERE id='".$enc_email."'";
if (mysqli_query($connection, $sql_login_attempts_write)) {
} else {
    echo('B<div class="alert alert-danger" role="alert"><h3>Error</h3>Message: ' . mysqli_error($connection) . '</div>');
}
session_write_close();
mysqli_close($connection);