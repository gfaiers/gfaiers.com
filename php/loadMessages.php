<?php
header("Content-Type: application/json");
$thread_id = $_POST['thread_id_post'];
$user_email = $_POST['user_email_post'];
if ($thread_id === "") {
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
//$thread_id = "61471707bc82c81de8254539d9a8aa61"; // enable this just for testing
// Collect what you need in the $data variable.
include_once("../includes/db_connect.php");
include_once("../includes/security.php");
// Check connection
if (!$connection) {
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
$a = -1;
$sql_load_thread = "SELECT thread_iv FROM threads WHERE thread_id='".$thread_id."'";
$check = mysqli_query($connection, $sql_load_thread) or die(mysqli_error($connection));
while($row_thread_iv = mysqli_fetch_assoc($check)) {
    $thread_iv = pkcs7_unpad(openssl_decrypt(
        $row_thread_iv['thread_iv'],
        'AES-256-CBC',
        $encryption_key,
        0,
        $secret_iv
    ));
}
$sql_load_messages = "SELECT sender_id, content, status, timestamp FROM messages WHERE thread_id='".$thread_id."' ORDER BY timestamp ASC";
$check = mysqli_query($connection, $sql_load_messages) or die(mysqli_error($connection));
while($row_load_messages = mysqli_fetch_assoc($check)) {
    $a ++;
    $sender[$a] = pkcs7_unpad(openssl_decrypt(
        $row_load_messages['sender_id'],
        'AES-256-CBC',
        $encryption_key,
        0,
        $secret_iv
    ));
    $message[$a] = pkcs7_unpad(openssl_decrypt(
        $row_load_messages['content'],
        'AES-256-CBC',
        $encryption_key,
        0,
        $thread_iv
    ));
    $status[$a] = $row_load_messages['status'];
    $timestamp[$a] = $row_load_messages['timestamp'];
}
// encrypt the email address to check 
$enc_email = openssl_encrypt(
    pkcs7_pad($user_email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);
$sql_update_status = "UPDATE messages SET status='0' WHERE thread_id='$thread_id' AND status='1' AND sender_id<>'$enc_email'";
if (!mysqli_query($connection, $sql_update_status)) {
    mysqli_close($connection);
    die("Err MYSQLI UPDATE");
}
for ($b = 0; $b <= $a; $b++) {
    $message_log[$b]['sender_id'] = $sender[$b];
    $message_log[$b]['content'] = $message[$b];
    $message_log[$b]['status'] = $status[$b];
    $message_log[$b]['timestamp'] = $timestamp[$b];
}
$json = json_encode($message_log);
if ($json === false) {
    // Avoid echo of empty string (which is invalid JSON), and
    // JSONify the error message instead:
    $json = json_encode(array("jsonError", json_last_error_msg()));
    if ($json === false) {
        // This should not happen, but we go all the way now:
        $json = '{"jsonError": "unknown"}';
    }
    // Set HTTP response status code to: 500 - Internal Server Error
    http_response_code(500);
}
echo $json;
mysqli_close($connection);