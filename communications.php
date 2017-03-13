<?php include_once("includes/sessions.php"); include_once("includes/cookies.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta property="og:url" content="http://www.gfaiers.com" />
    <meta property="og:title" content="gfaiers.com" />
    <meta property="og:description" content="Are you self employed and looking for a web presence?  Have you got a great idea for a new mobile app but don't know where to start?  Are you needing help with anything tech related?  Click this link for a great place to start." />
    <meta property="og:type" content="article" />
    <meta property="og:image" content="media/images/logo.png" />
    <meta property="title" content="gfaiers.com" />
    <meta property="description" content="Are you self employed and looking for a web presence?  Have you got a great idea for a new mobile app but don't know where to start?  Are you needing help with anything tech related?  Click this link for a great place to start." />
    <title>gfaiers.com</title>
    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/mytheme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery-3.1.1.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.2/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.2/cookieconsent.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"/>
    <link rel="manifest" href="/media/images/icon/manifest.json"/>
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5"/>
    <meta name="theme-color" content="#ffffff"/>
    <script>
        window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "#778899",
                    "text": "#ffffff"
                },
                "button": {
                    "background": "#667788",
                    "text": "#ffffff"
                }
            },
            "position": "top",
            "static": true
        })});
    </script>
</head>
<body>
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img id="comms_" class="nav_brand" src="/media/images/logo.png" alt="gfaiers.com">
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="cursor_pointer" id="comms_nav_downloads">Applications</a></li>
                    <li><a class="cursor_pointer" id="comms_nav_services">Services</a></li>
                    <li><a class="cursor_pointer" id="comms_nav_about">About</a></li>
                    <?php
                    if (isset($_SESSION['first_name'])) {
                        if ($_SESSION['rights'] == 1) { // user has admin rights
                            echo('<li class="dropdown"><a class="dropdown-toggle cursor_pointer" data-toggle="dropdown" id="nav_loggedin" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['first_name'].' <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="cursor_pointer" id="nav_details">Details</a></li>
                            <li><a class="cursor_pointer" id="nav_communications">Communications</a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Admin Controls</li>
                            <li><a class="cursor_pointer" id="nav_post_update">Update Post</a></li>
                            <li><a class="cursor_pointer" id="nav_post_delete">Delete Post</a></li>
                            <li><a class="cursor_pointer" id="nav_user_admin">User Administration</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="cursor_pointer" id="nav_logout">Log Out</a></li>
                        </ul>
                    </li>
');
                        } else { // user has no rights
                            echo('<li class="dropdown"><a class="dropdown-toggle cursor_pointer" data-toggle="dropdown" id="nav_loggedin" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['first_name'].' <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a class="cursor_pointer" id="nav_details">Details</a></li>
                            <li><a class="cursor_pointer" id="nav_communications">Communications</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a class="cursor_pointer" id="nav_logout">Log Out</a></li>
                        </ul>
                    </li>
');
                        }
                    } else {
                        echo('<li><a class="cursor_pointer" id="nav_login">Login / Register</a></li>');
                    }?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    <?php include_once("includes/modals.php");?>
    <main class="main">
        <!-- MAIN CONTENT -->
                <div class="col-md-12">
                   <div class="row is-flex">
                        <div class="thread_pane">
                            <?php
include_once("includes/sessions.php");
if (!isset($_SESSION['user_id'])) {
    session_write_close();
    die('ERROR NAVIGATION TO THIS DOCUMENT IS PROHIBITED<br/><a href="http://www.gfaiers.com">Return to gfaiers.com</a>');
}
include_once("includes/db_connect.php");
if (!$connection) {
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
include_once("includes/functions.php");
$encryption_key = 'KJGHfdfIYY£E4534ffefI%HIE723872u3hui2398y6%$3hguu34';
$secret_iv = 'thisis===16bytes';
$enc_email = $_SESSION['user_id'];
$email = pkcs7_unpad(openssl_decrypt(
    $enc_email,
    'AES-256-CBC',
    $encryption_key,
    0,
    $secret_iv
));
$sql_find_session = "SELECT DISTINCT session FROM communication WHERE sender='$enc_email' OR recipient='$enc_email'";
$check = mysqli_query($connection, $sql_find_session) or die(mysqli_error($connection));
$check2 = mysqli_num_rows($check);
if ($check2 != 0) {
    while($row_find_session = mysqli_fetch_assoc($check)) {
        // found some comms to this user
        $sql_load_session = "SELECT * FROM communication WHERE session='".$row_find_session['session']."' ORDER BY date DESC LIMIT 1";
        $check_session = mysqli_query($connection, $sql_load_session) or die(mysqli_error($connection));
        while($row_load_session = mysqli_fetch_assoc($check_session)) {
            // this loads the details of each session message
            $datestamp = $row_load_session['date'];
            $sender = pkcs7_unpad(openssl_decrypt(
                $row_load_session['sender'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $secret_iv
            ));
            $recipient = pkcs7_unpad(openssl_decrypt(
                $row_load_session['recipient'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $secret_iv
            ));
            $sender_name = pkcs7_unpad(openssl_decrypt(
                $row_load_session['sender_name'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $row_load_session['session_iv']
            ));
            $recipient_name = pkcs7_unpad(openssl_decrypt(
                $row_load_session['recipient_name'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $row_load_session['session_iv']
            ));
            $option = pkcs7_unpad(openssl_decrypt(
                $row_load_session['option'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $row_load_session['session_iv']
            ));
            $message = pkcs7_unpad(openssl_decrypt(
                $row_load_session['details'],
                'AES-256-CBC',
                $encryption_key,
                0,
                $row_load_session['session_iv']
            ));
            if ($sender == $email) {
                $temp_preview = "You: " . $message;
                $thread_name = $recipient_name;
            } else {
                $first_name = substr($sender_name, 0, strpos($sender_name, ' '));
                $temp_preview = $first_name . ": " . $message;
                $thread_name = $sender_name;
            }
            if (strlen($temp_preview) > 35) {
                $preview = substr($temp_preview, 0, 35)."...";
            } else {
                $preview = $temp_preview;
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
                                <table>
                                    <tr>
                                        <th class="thread_image">
                                            <img src="'.$img_path.'" class="actual_image">
                                        </th>
                                        <th class="thread_preview">
                                            <small class="thread_sender">'.$thread_name.'</small><br/>
                                            <small class="thread_preview_text">'.$preview.'</small>
                                            <input class="session_id" type="hidden" value="'.$row_find_session['session'].'"/>
                                            <input class="user_email" type="hidden" value="'.$email.'"/>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            ';
        }
    }
} else {
    echo("No communication found");
}?></div>
                        <div class="messages_pane">
                            <div class="info_panel" id="info_panel_shadow">
                                <div class="info_panel_name"></div>
                                <button class="info_panel_btn btn_custom" type="button">
                                    <span class="glyphicon glyphicon-arrow-left"></span>
                                </button>
                            </div>
                            <div class="messages_area">
                                <p>Please click a messages thread to read messages.</p>
                            </div>
                            <form class="submit_message">
                                <textarea class="submit_message_text" type="text" placeholder="Type a message..."></textarea>
                                <input class="submit_session_id" type="hidden">
                                <input class="submit_message_button btn_custom" type="button" value="Send">
                            </form>
                        </div>
                    </div>
                </div>
            <div class="up_arrow"><span class="glyphicon glyphicon-arrow-up"></span></div>
    </main>
    <footer>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script> <!-- required for bootstrap -->
    <script src="/js/zxcvbn.js"></script> <!-- zxcvbn password checker -->
    <script src="/js/javascript_functions.js"></script> <!-- Javascript functions -->
    <script src="/js/jquery_functions.js"></script> <!-- jQuery functions -->
    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
    <?php include_once("includes/cookie_cutter.php");?>
</body>
</html>