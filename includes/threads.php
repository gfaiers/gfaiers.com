<?php
include_once("sessions.php");
if (!isset($_SESSION['user_id'])) {
    session_write_close();
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("db_connect.php");
if (!$connection) {
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("functions.php");
include_once("security.php");
$enc_email = $_SESSION['user_id'];
$sql_load_thread = "SELECT * FROM threads WHERE sender_id='$enc_email' OR recipient_id='$enc_email' ORDER BY timestamp DESC";
$check = mysqli_query($connection, $sql_load_thread) or die(mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    while($row_thread = mysqli_fetch_assoc($check)) {
        // this loads the details of each thread message
        $timestamp = $row_thread['timestamp'];
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
            $row_cnt = mysqli_num_rows($result);
        }
        if ($row_cnt != 0) {
            $badge = ' <span class="badge">'.$row_cnt.'</span>';
        } else {
            $badge = '';
        }
        // needs to read from the message table to get this
        $sql_message_preview = "SELECT sender_id, content FROM messages WHERE thread_id='".$row_thread['thread_id']."' AND timestamp='$timestamp'";
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
            $thread_name = $recipient_name;
            if ($enc_email == $sender_id_message) {
                $preview = "You: " . $message;
            } else {
                $first_name = substr($recipient_name, 0, strpos($recipient_name, ' '));
                $preview = $first_name . ": " . $message;
            }
        } else {
            $thread_name = $sender_name;
            if ($enc_email == $sender_id_message) {
                $preview = "You: " . $message;
            } else {
                $first_name = substr($sender_name, 0, strpos($sender_name, ' '));
                $preview = $first_name . ": " . $message;
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
        $img_path = '/media/images/'.$img;
        echo '<div class="thread_message">
                                <div class="thread_image">
                                    <img src="'.$img_path.'" class="actual_image">
                                </div>
                                <input class="'.$row_thread['thread_id'].'" type="hidden" value="'.$timestamp.'">
                                <div class="thread_preview" id="'.$row_thread['thread_id'].'">
                                    <small class="thread_sender">'.$thread_name.$badge.'</small><br/>
                                    <small class="thread_preview_text">'.$preview.'</small>
                                    <input class="thread_id" type="hidden" value="'.$row_thread['thread_id'].'"/>
                                </div>
                            </div>
';
    }
} else {
    echo("No communication found");
}