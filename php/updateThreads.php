<?php
header("Content-Type: application/json");
include_once("../includes/sessions.php");
if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("../includes/db_connect.php");
if (!$connection) {
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("../includes/functions.php");
include_once("../includes/security.php");
$enc_email = $_SESSION['user_id'];
$a = -1;
$sql_load_thread = "SELECT * FROM threads WHERE sender_id='$enc_email' OR recipient_id='$enc_email' ORDER BY timestamp DESC";
$check = mysqli_query($connection, $sql_load_thread) or die(mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    while($row_thread = mysqli_fetch_assoc($check)) {
        $a++;
        $thread_id_upd[$a] = $row_thread['thread_id'];
        $timestamp[$a] = $row_thread['timestamp'];
        $sender_id_thread = $row_thread['sender_id'];
        $thread_iv = pkcs7_unpad(openssl_decrypt(
            $row_thread['thread_iv'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $secret_iv
        ));
        $sender_name = pkcs7_unpad(openssl_decrypt(
            $row_thread['sender_name'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $thread_iv
        ));
        $recipient_name = pkcs7_unpad(openssl_decrypt(
            $row_thread['recipient_name'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $thread_iv
        ));
        $option = pkcs7_unpad(openssl_decrypt(
            $row_thread['option'],
            'AES-256-CBC',
            $encryption_key,
            0,
            $thread_iv
        ));
        $sql_message_status = "SELECT status FROM messages WHERE thread_id='".$row_thread['thread_id']."' AND sender_id<>'".$enc_email."' AND status='1'";
        if ($result = mysqli_query($connection, $sql_message_status)) {
            $row_count = mysqli_num_rows($result);
        }
        if ($row_count != 0) {
            $badge[$a] = ' <span class="badge">'.$row_count.'</span>';
        } else {
            $badge[$a] = 'no unread messages';
        }
        // needs to read from the message table to get this
        $sql_message_preview = "SELECT sender_id, content FROM messages WHERE thread_id='".$row_thread['thread_id']."' AND timestamp='".$timestamp[$a]."'";
        $check_message_preview = mysqli_query($connection, $sql_message_preview) or die(mysqli_error($connection));
        $check2_message_preview = mysqli_num_rows($check_message_preview);
        if ($check2_message_preview != 0) {
            // this will never fail
            while($row_message = mysqli_fetch_assoc($check_message_preview)) {
                $message = pkcs7_unpad(openssl_decrypt(
                    $row_message['content'],
                    'AES-256-CBC',
                    $encryption_key,
                    0,
                    $thread_iv
                ));
                $sender_id_message = $row_message['sender_id'];
            }
        }
        if ($message == '<span class="glyphicon glyphicon-thumbs-up extra_large"></span>') {
            $message = '<span class="glyphicon glyphicon-thumbs-up"></span>';
        }
        if ($message == '<span class="glyphicon glyphicon-thumbs-down extra_large"></span>') {
            $message = '<span class="glyphicon glyphicon-thumbs-down"></span>';
        }
        if ($enc_email == $sender_id_thread) {
            $name[$a] = $recipient_name;
            if ($enc_email == $sender_id_message) {
                $preview[$a] = "You: " . $message;
            } else {
                $first_name = substr($recipient_name, 0, strpos($recipient_name, ' '));
                $preview[$a] = $first_name . ": " . $message;
            }
        } else {
            $name[$a] = $sender_name;
            if ($enc_email == $sender_id_message) {
                $preview[$a] = "You: " . $message;
            } else {
                $first_name = substr($sender_name, 0, strpos($sender_name, ' '));
                $preview[$a] = $first_name . ": " . $message;
            }
        }
        switch ($option) {
            case "Software":
                $img = "sd.png";
                break;
            case "Website":
                $img = "wd.png";
                break;
            case "Tech Support":
                $img = "tg.png";
                break;
            case "Contact":
                $img = "cm.png";
                break;
        }
        $img_path[$a] = $img;
    }
} else {
    $update_threads[0]["err"] = "No communication found";
}
for ($b = 0; $b <= $a; $b++) {
    $update_threads[$b]['thread_id_upd'] = $thread_id_upd[$b];
    $update_threads[$b]['timestamp'] = $timestamp[$b];
    $update_threads[$b]['option'] = $img_path[$b];
    $update_threads[$b]['name'] = $name[$b];
    $update_threads[$b]['badge'] = $badge[$b];
    $update_threads[$b]['preview'] = $preview[$b];
}
$json = json_encode($update_threads);
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