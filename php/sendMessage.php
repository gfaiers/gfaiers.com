<?php
// for sending the message to the database
$user_email = $_POST['user_email_post'];
$thread_id = $_POST['thread_id_post'];
$message = $_POST['message_post'];
$timestamp = $_POST['timestamp_post'];

if ($thread_id == "") {
    // B check
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

$sql_load_thread = "SELECT thread_iv FROM threads WHERE thread_id='$thread_id'";
$check = mysqli_query($connection, $sql_load_thread) or die("B".mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    // this should only run through once
    while($row_load_thread = mysqli_fetch_assoc($check)) {
        // load the details of the last sent message (these can be copied to the new message)
        $thread_iv = pkcs7_unpad(openssl_decrypt(
            $row_load_thread['thread_iv'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
    }
}
// the data now needs priming for saving to the database as a new message
$enc_email = openssl_encrypt(
    pkcs7_pad($user_email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);
$enc_message = openssl_encrypt(
    pkcs7_pad($message, 16),
    'AES-256-CBC',
    $encryption_key,
    0,
    $thread_iv
);
$status = 1;
$sql_write_messages = "INSERT INTO messages (thread_id, sender_id, content, status, timestamp) VALUES ('$thread_id', '$enc_email', '$enc_message', '$status', '$timestamp')";
if (!mysqli_query($connection, $sql_write_messages)) {
    die("BMYSQL ERR: " . mysqli_error($connection));
}
$sql_update_thread = "UPDATE threads SET timestamp='$timestamp' WHERE thread_id='$thread_id'";
if (!mysqli_query($connection, $sql_update_thread)) {
    die("BMYSQL ERR: " . mysqli_error($connection));
}
echo"A";