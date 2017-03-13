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
    <link href="https://yui-s.yahooapis.com/2.9.0/build/reset/reset-min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/messages.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery-3.1.1.js"></script>
    <script>!window.jQuery && document.write('<script src="/js/jquery-3.1.1.js"><\/script>')</script>
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
    <?php include_once("includes/modals.php");?>
    <main class="main">
        <!-- MAIN CONTENT -->
        <div class="thread_pane">
            <!-- Static navbar -->
            <nav class="navbar navbar-default navbar-static-top">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img id="comms_" class="nav_brand" src="/media/images/icon/android-chrome-192x192.png" alt="gfaiers.com">
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <?php
                        if (isset($_SESSION['first_name'])) {
                            if ($_SESSION['rights'] == 1) { // user has admin rights
                                echo('<li class="dropdown"><a class="dropdown-toggle cursor_pointer" data-toggle="dropdown" id="nav_loggedin" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['first_name'].' <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a class="cursor_pointer" id="nav_details">Details</a></li>
                                <li><a class="cursor_pointer" id="nav_messages">Messages</a></li>
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
                                <li><a class="cursor_pointer" id="nav_messages">Messages</a></li>
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
            </nav>
            <div id="threads" class="threads">
                <?php include_once("includes/threads.php"); ?>
            </div>
        </div>
        <div class="line"></div>
        <div class="messages_pane">
            <div class="info_panel" id="info_panel_shadow">
                <div class="info_panel_name"></div>
                <button class="info_panel_btn" type="button">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                </button>
            </div>
            <div class="messages_area">
                <div class="centered_text">Please click a messages thread to read messages.</div>
            </div>
            <form class="submit_message">
                <textarea class="submit_message_text" type="text" placeholder="Type a message..."></textarea>
                <input class="submit_thread_id" type="hidden">
                <input class="submit_user_email" type="hidden">
                <?php 
                if (isset($_SESSION['user_id'])) {
                    include_once("includes/functions.php");
                    $encryption_key = 'KJGHfdfIYY£E4534ffefI%HIE723872u3hui2398y6%$3hguu34';
                    $secret_iv = 'thisis===16bytes';
                    $email = pkcs7_unpad(openssl_decrypt(
                        $_SESSION['user_id'],
                        'AES-256-CBC',
                        $encryption_key,
                        0,
                        $secret_iv
                    ));
                    echo('<input class="user_email" type="hidden" value="'.$email.'">
');
                }
                ?>
                <div id="submit_like" class="emoticon like">
                    <span class="glyphicon glyphicon-thumbs-up large"></span>
                </div>
                <div id="submit_dislike" class="emoticon dislike">
                    <span class="glyphicon glyphicon-thumbs-down large"></span>
                </div>
                <input class="submit_message_button" type="button" value="Send">
            </form>
        </div>
    </main>
    <footer>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script> <!-- required for bootstrap -->
    <script src="/js/zxcvbn.js"></script> <!-- zxcvbn password checker -->
    <script src="/js/tinysort.js"></script> <!-- TinySort http://tinysort.sjeiti.com/ -->
    <script src="/js/javascript_functions.js"></script> <!-- Javascript functions -->
    <script src="/js/jquery_functions.js"></script> <!-- jQuery functions -->
    <script src="/js/jquery_messages.js"></script> <!-- jQuery functions for messages.php -->
    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
    <?php include_once("includes/cookie_cutter.php");?>
</body>
</html>