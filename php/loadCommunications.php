<?php
header("Content-Type: application/json");
$session_id = $_POST['session_id_post'];
if ($session_id === "") {
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
// $session_id = "cb19195a25ac8c992a892875ecb4e69f"; // enable this just for testing
// Collect what you need in the $data variable.
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    mysqli_close($connection);
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
$a = -1;
$messages = array();
$sql_load_messages = "SELECT session_iv, sender, details, date FROM communication WHERE session='".$session_id."' ORDER BY date ASC";
$check = mysqli_query($connection, $sql_load_messages) or die(mysqli_error($connection));
while($row_load_messages = mysqli_fetch_assoc($check)) {
    $a ++;
    $sender[$a] = pkcs7_unpad(openssl_decrypt(
        $row_load_messages['sender'],
        'AES-256-CBC',
        $encryption_key,
        0,
        $secret_iv
    ));
    $message[$a] = pkcs7_unpad(openssl_decrypt(
        $row_load_messages['details'],
        'AES-256-CBC',
        $encryption_key,
        0,
        $row_load_messages['session_iv']
    ));
    $timestamp[$a] = $row_load_messages['date'];
}
for ($b = 0; $b <= $a; $b++) {
    $message_log[$b]['sender'] = $sender[$b];
    $message_log[$b]['details'] = $message[$b];
    $message_log[$b]['date'] = $timestamp[$b];
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