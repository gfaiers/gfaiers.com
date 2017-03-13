<?php
header("Content-Type: application/json");
// this needs to load all the entries in messages table, that have 1 for status with the correct thread_id
$thread_id = $_POST['thread_id_post'];
$user_email = $_POST['user_email_post'];
if ($thread_id == "") {
    // q check
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    mysqli_close($connection);
    die('w<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
$enc_email = openssl_encrypt(
    pkcs7_pad($user_email, 16),  // padded data
    'AES-256-CBC',          // cipher and mode
    $encryption_key,        // secret key
    0,                      // options (not used)
    $secret_iv              // initialisation vector (for set value)
);
$sql_select_thread = "SELECT thread_iv FROM threads WHERE thread_id='$thread_id'";
$check_select_thread = mysqli_query($connection, $sql_select_thread) or die("MYSQL ERR: ".mysqli_error($connection));
$check2_select_thread = mysqli_num_rows($check_select_thread);
if ($check2_select_thread != 0) {
    while ($row_thread_iv = mysqli_fetch_assoc($check_select_thread)) {
        $thread_iv = pkcs7_unpad(openssl_decrypt(
            $row_thread_iv['thread_iv'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
    }
}
$a = -1;
$status = 1;
$sql_select_messages = "SELECT * FROM messages WHERE thread_id='$thread_id' AND status='$status' AND sender_id<>'$enc_email' ORDER BY timestamp DESC";
$check_select_messages = mysqli_query($connection, $sql_select_messages) or die("MYSQL ERR: ".mysqli_error($connection));
$check2_select_messages = mysqli_num_rows($check_select_messages);
if ($check2_select_messages != 0) {
    //there are new messages to load
    while ($row_new_messages = mysqli_fetch_assoc($check_select_messages)) {
        $a ++;
        $sender[$a] = pkcs7_unpad(openssl_decrypt(
            $row_new_messages['sender_id'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
        $message[$a] = pkcs7_unpad(openssl_decrypt(
            $row_new_messages['content'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $thread_iv
        ));
        $timestamp[$a] = $row_new_messages['timestamp'];
    }
    //update all the status in database that are in the correct thread and have status of 1
    $sql_update_status = "UPDATE messages SET status='0' WHERE thread_id='$thread_id' AND status='1'";
    if (!mysqli_query($connection, $sql_update_status)) {
        mysqli_close($connection);
        die("Err MYSQLI UPDATE");
    }
    for ($b = 0; $b <= $a; $b++) {
        $message_log[$b]['sender_id'] = $sender[$b];
        $message_log[$b]['content'] = $message[$b];
        $message_log[$b]['timestamp'] = $timestamp[$b];
    }
} else {
    $message_log[0]["err"] = "No communication found";
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