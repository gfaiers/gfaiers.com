<?php
include_once("../includes/sessions.php");
$first_name = $_POST['first_name_post']; // this is their first name
// if the first_name variable is empty then the user has navigated to this page with out following the correct path
// so inform the user that they've not followed the correct route and navigate them back to the main page
if ($first_name == "") {
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
$to = "geoff@gfaiers.com"; // this is my Email address
$last_name = $_POST['surname_post']; // this is their surname
$from = $_POST['email_address_post']; // this is the requesters Email address
$request = $_POST['contact_option_post']; // this is what the requester is asking for (radio buttons)
$details = $_POST['details_post']; // this is the details
$message = $first_name . " " . $last_name . " wrote the following:" . "\n\n" . $details; // message of email to me        
$headers = "From:" . $from; // message of email header to me
$headers2 = "From:" . $to; // message of email header to requester
if ($request == "Contact") {
    $subject = $request . "ed gfaiers.com"; // subject of their email to me
    $subject2 = $request . "ed gfaiers.com"; // subject of the email back to them
$message2 = "Here is a copy of your email to me " . $first_name . ".

" . $details . "

Many thanks,

Geoff Faiers
www.gfaiers.com"; // message of email to commentor
} else { // if not then do this
    $subject = $request . " Request"; // subject of their email to me
    $subject2 = "Copy of your " . $request . " Request"; // subject of the email back to them
$message2 = "This is an automated response, if you believe you have received this email in error please disregard it:
Here is a copy of your request " . $first_name .".

". $details . "

Many thanks,

Geoff Faiers
www.gfaiers.com"; // message of email to requester
}

// send the emails
//mail($to,$subject,$message,$headers);
//mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender

// this needs to look through the database, and find out if the user that sent the mail is already registered.  If they are, then prompt with the login screen.
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    die('A<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
// encrypt the email address to check 
$enc_email = openssl_encrypt(
    pkcs7_pad($from, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);
if (isset($_SESSION['user_id'])) {
    $currenttime = time();
    $timestamp = date('Y-m-d H:i:s', $currenttime);
    reSubmitCommunicationSession: {
        // it now needs to check if the session is already used in the database
        $thread_id = bin2hex(openssl_random_pseudo_bytes(16)); // generate the session
        $iv_size = 16; // 128 bits
        $thread_iv = openssl_random_pseudo_bytes($iv_size, $strong);
        $sql_thread_search = "SELECT * FROM threads WHERE thread_id ='$thread_id'";
        $check = mysqli_query($connection, $sql_thread_search) or die('A<div class="alert alert-danger" role="alert">'.mysqli_error($connection).'</div>');
        $check2 = mysqli_num_rows($check);
        if ($check2 != 0) { // if a result is found then the session is already in use, generate another
            goto reSubmitCommunicationSession;
        }
    }
    $sql_get_sender_name = "SELECT iv, first_name, surname FROM users WHERE id='".$_SESSION['user_id']."'";
    $check = mysqli_query($connection, $sql_get_sender_name) or die("A".mysqli_error($connection));
    while($row_get_sender_name = mysqli_fetch_assoc($check)) {
        $iv = pkcs7_unpad(openssl_decrypt(
            $row_get_sender_name['iv'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
        $first_name = pkcs7_unpad(openssl_decrypt(
            $row_get_sender_name['first_name'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $iv
        ));
        $surname = pkcs7_unpad(openssl_decrypt(
            $row_get_sender_name['surname'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $iv
        ));
    }
    $sender_name = $first_name." ".$surname;
    $recipient_name = 'Geoff Faiers';
    $enc_recipient = openssl_encrypt(
        pkcs7_pad($to, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $secret_iv             // initialisation vector (for set value)
    );
    $enc_iv = openssl_encrypt(
        pkcs7_pad($thread_iv, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $secret_iv              // initialisation vector (for set value)
    );
    $enc_sender_name = openssl_encrypt(
        pkcs7_pad($sender_name, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $thread_iv              // initialisation vector (for set value)
    );
    $enc_recipient_name = openssl_encrypt(
        pkcs7_pad($recipient_name, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $thread_iv              // initialisation vector (for set value)
    );
    $enc_option = openssl_encrypt(
        pkcs7_pad($request, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $thread_iv              // initialisation vector (for set value)
    );
    $enc_content = openssl_encrypt(
        pkcs7_pad($details, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $thread_iv              // initialisation vector (for set value)
    );
    $sql_thread_save = "INSERT INTO threads (thread_id, thread_iv, option, sender_id, recipient_id, sender_name, recipient_name, timestamp) VALUES ('".$thread_id."', '".$enc_iv."', '".$enc_option."', '".$enc_email."', '".$enc_recipient."', '".$enc_sender_name."', '".$enc_recipient_name."', '".$timestamp."')";
    if (!mysqli_query($connection, $sql_thread_save)) {
        die("ACommunication save to database failed: " . $sql_thread_save . ": " . mysqli_error($connection));
    }
    $status = 1;
    $sql_message_save = "INSERT INTO messages (thread_id, sender_id, content, status, timestamp) VALUES ('".$thread_id."', '".$enc_email."', '".$enc_content."', '".$status."', '".$timestamp."')";
    if (!mysqli_query($connection, $sql_message_save)) {
        die("AMessage save to database failed: " . $sql_message_save . ": " . mysqli_error($connection));
    }
    if ($request == "contact") {
        $success_message = '<div class="alert alert-success" role="alert"><h1>Email sent</h1><p>Your email has been sent to me at ' . $to . ' a copy has also been sent to you at ' . $from . '.</p><p>Many thanks,<br/><br/>Geoff Faiers</p></div>';
    } else { // the page dealt with a request
        $success_message = '<div class="alert alert-success" role="alert"><h1>Success</h1><p>' . $request . ' request has been sent, a copy has been sent to the email address you provided.  I\'ll be in touch as soon as possible.</p><p>Many thanks,<br/><br/>Geoff Faiers</p></div>';
    }
    echo("A".$success_message);
} else {
    $sql_users_search = "SELECT * FROM users WHERE id='$enc_email'";
    $check = mysqli_query($connection, $sql_users_search) or die("AMAILHANDLER ERROR ".mysqli_error($connection));
    $check2 = mysqli_num_rows($check);
    if ($check2 != 0) {
        // user found
        if ($request == "contact") {
            $success_message = '<div class="alert alert-success" role="alert"><h3>Email sent</h3><p>Your email has been sent to me at ' . $to . ' a copy has also been sent to you at ' . $from . '.</p><p>Please login to gfaiers.com by completing this form.</p></div>';
        } else { // the page dealt with a request
            $success_message = '<div class="alert alert-success" role="alert"><h3>Success</h3><p>' . $request . ' request has been sent, a copy has been sent to the email address you provided.  I\'ll be in touch as soon as possible.</p><p>Please login to gfaiers.com by completing this form.</p></div>';
        }
        echo("C".$success_message);
    } else {
        // user not found
        if ($request == "contact") {
            $success_message = '<div class="alert alert-success" role="alert"><h3>Email sent</h3><p>Your email has been sent to me at ' . $to . ' a copy has also been sent to you at ' . $from . '.</p><p>Please register on gfaiers.com by completing this form.</p></div>';
        } else { // the page dealt with a request
            $success_message = '<div class="alert alert-success" role="alert"><h3>Success</h3><p>' . $request . ' request has been sent, a copy has been sent to the email address you provided.  I\'ll be in touch as soon as possible.</p><p>Please register on gfaiers.com by completing this form.</p></div>';
        }
        echo("B".$success_message);
    }
}
session_write_close();
mysqli_close($connection);