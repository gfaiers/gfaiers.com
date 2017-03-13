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
    <meta property="og:image" content="http://www.gfaiers.com/media/images/logo.png" />
    <meta property="title" content="gfaiers.com" />
    <meta property="description" content="Are you self employed and looking for a web presence?  Have you got a great idea for a new mobile app but don't know where to start?  Are you needing help with anything tech related?  Click this link for a great place to start." />
    <title>gfaiers.com</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/mytheme.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>!window.jQuery && document.write('<script src="/js/jquery-3.1.1.js"><\/script>')</script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.2/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.2/cookieconsent.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16"/>
    <link rel="manifest" href="media/images/icon/manifest.json"/>
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
                <img class="nav_brand" src="media/images/logo.png" alt="gfaiers.com">
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="cursor_pointer" id="nav_downloads">Applications</a></li>
                    <li><a class="cursor_pointer" id="nav_services">Services</a></li>
                    <li><a class="cursor_pointer" id="nav_about">About</a></li>
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
        </div>
    </nav>
    
    <main class="main">
       <?php include_once("includes/modals.php"); ?>
        <!-- MAIN CONTENT -->
        <div class="jumbotron">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <h1>Introduction</h1>
                        <h2>I am a software and web developer from York, England</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="note" name="note"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    include_once("includes/db_connect.php");
                    // Check connection
                    if (!$connection) {
                        mysqli_close($connection);
                        die('<div class="alert alert-danger" role="alert"><h1>Connection failed</h1>' . mysqli_connect_error() . '</div>');
                    }
                    // FOR READING FROM updates
                    $sql = "SELECT * FROM updates ORDER BY id DESC LIMIT 1";
                    $check = mysqli_query($connection, $sql) or die(mysqli_error($connection));
                    $check2 = mysqli_num_rows($check);
                    if ($check2 != 0) {
                        while($row = mysqli_fetch_assoc($check)) {
                            $author = $row['author'];
                            $time = $row['time'];
                            $title = $row['title'];
                            $content = $row['content'];
                        }
                        echo '<h2>'.$title.'</h2>';
                        echo 'Posted: <span class="glyphicon glyphicon-calendar"></span> '.$time.' by '.$author;
                        echo '<p>'.$content.'</p>';
                    } else {
                        // the number of rows is 0, so there is no update done before
                        echo('<div class="alert alert-danger" role="alert"><h1>Error</h1>No update</div>');
                    }
                    ?>
                </div>
            </div>
            <div class="up_arrow"><span class="glyphicon glyphicon-arrow-up"></span></div>
            <div class="content_row"></div>
            <div class="row">
                <div class="col-md-12">
                    <div id="downloads" class="anchor"></div>
                    <h1>Applications</h1>
                    <h2>Windows Apps and Documents</h2>
                    <div class="btn_holder" id="windows">
                    <button class="btn_custom btn_custom_text" id="app_rota">Quarterly Rota</button><button class="btn_custom btn_custom_text" id="app_daily_focus">Daily Focus</button></div>
                    <!-- app info sheets, controlled by jquery above -->
                    <div id="info_blank">
                        <p>To view information and imagery about the above applications, and have an option to download them simply click the button.</p>
                    </div>
                    <div id="info_rota" class="hidden_element">
                        <h3 class="app_details">Quarterly Rota Document</h3>
                        <div class="col-md-10">
                            <p class="app_details">This application is used to manage the in store rotas, and to be used in conjunction with the time keeping system Kronos. This application gives stores an easy to read, and quick to edit document. It also provides stores with a run down of what they've used through the month, and tracks against the stores payroll budget.</p>
                        </div>
                        <div class="col-md-2">
                            <img class="download_icon" src="media/images/Microsoft_Excel_2013_logo.svg.png" alt="Excel"><br/>
                            <p>Excel with VBA</p>
                            <a href="#" class="app_details">Download Here</a>
                        </div>
                    </div>
                    <div id="info_daily_focus" class="hidden_element">
                        <h3 class="app_details">Daily Focus Document</h3>
                        <div class="col-md-10">
                            <p class="app_details">This application is made to be used with the Quarterly Rota document, It's used to manage the day to day running of the stores. It was created in 2014 and had constant updates through to 2017, when it was built to a stage that no future updates are required. The application updates it's self automatically at the end of the year to start a new year.</p>
                        </div>
                        <div class="col-md-2">
                            <img class="download_icon" src="media/images/Microsoft_Excel_2013_logo.svg.png" alt="Excel"><br/>
                            <p>Excel with VBA</p>
                            <a href="#" class="app_details">Download Here</a>
                        </div>
                    </div>
                    <!-- image scroller windows, controlled by jquery above -->
                    <div id="app_windows_scroller" class="col-md-12 hidden_element">
                        <p id="app_windows_image_text">Text about image</p>
                        <div class="col-md-12">
                            <a class="cursor_pointer" id="app_windows_image_link">
                                <img id="app_windows_image" class="app_image" alt="App image">
                            </a>
                            <button class="btn_custom btn_left" id="app_windows_left"><span class="glyphicon glyphicon-arrow-left"></span></button>
                            <button class="btn_custom btn_right" id="app_windows_right"><span class="glyphicon glyphicon-arrow-right"></span></button>
                        </div>
                    </div>
                    <!-- Creates the bootstrap modal where the image will appear -->
                    <div class="modal fade" id="modal_windows_image" tabindex="-1" role="dialog" aria-labelledby="modal_windows_label" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="modal_windows_label">Image preview</h4>
                          </div>
                          <div class="modal-body">
                            <img src="" id="modal_windows_image_preview" class="modal_image" data-dismiss="modal" alt="Clicked app image">
                          </div>
                        </div>
                      </div>
                    </div>
                    <h2>Android Apps and Documents</h2>
                    <div class="btn_holder" id="android">
                        <button class="btn_custom btn_custom_text" id="app_hangman">Hangman</button><button class="btn_custom btn_custom_text" id="app_reactions">Reactions</button><button class="btn_custom btn_custom_text" id="app_crocs_reactions">Crocs Reactions</button></div>
                    <div id="info_android_blank">
                        <p>To view information and imagery about the above applications, and have an option to download them simply click the button.</p>
                    </div>
                    <div id="info_hangman" class="hidden_element">
                        <h3 class="app_details">Hangman</h3>
                        <div class="col-md-10">
                            <p class="app_details">Game features include:</p>
                            <ul>
                                <li>Introduce your own custom words lists or use predefined words lists.</li>
                                <li>Choose your own difficulty, choosing how long the words are, and how many lives you have.</li>
                                <li>Set new best times for completing words on the predefined words lists.</li>
                                <li>Watch your device play the game on it's own on the game's home screen.</li>
                                <li>Predefined words lists include, animals, dictionary, famous people, films, food and places.</li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <img class="download_icon" src="media/images/hangman.png" alt="App icon"><br/>
                            <a href="https://play.google.com/store/apps/details?id=com.gfaiers.hangman" target="_blank">View on Play Store</a><br/>
                            <a href="content/hangman.apk" class="app_details">Direct Link</a>
                        </div>
                    </div>
                    <div id="info_reactions" class="hidden_element">
                        <h3 class="app_details">Reactions</h3>
                        <div class="col-md-10">
                            <p class="app_details">React as fast as you can to make sure you're getting the highest score. Touch each square as they change, get them as quickly as possible you're awarded the points that are displayed on the square at the time... but be careful! If you hit the wrong square then you'll lose the points that you would have gained!</p>
                        </div>
                        <div class="col-md-2">
                            <img class="download_icon" src="media/images/reactions.png" alt="App icon"><br/>
                            <a href="https://play.google.com/store/apps/details?id=com.gfaiers.reactions" target="_blank">View on Play Store</a><br/>
                            <a href="content/reactions.apk" class="app_details">Direct Link</a>
                        </div>
                    </div>
                    <div id="info_crocs_reactions" class="hidden_element">
                        <h3 class="app_details">Crocs Reactions</h3>
                        <div class="col-md-10">
                            <p class="app_details">React as fast as you can to make sure you're getting the highest score. Touch each clog as they change, get them as quickly as possible, you're awarded points depending on how light the shoe is... but be careful! If you hit the wrong square then you'll lose the points that you would have gained!  This application will be on the Play Store soon.</p>
                        </div>
                        <div class="col-md-2">
                            <img class="download_icon" src="media/images/crocsreactions.png" alt="App icon"><br/>
                            <a href="#" class="app_details">Direct Link</a>
                        </div>
                    </div>
                    <!-- image scroller android, controlled by jquery above -->
                    <div id="app_android_scroller" class="col-md-12 hidden_element">
                        <p id="app_android_image_text">Text about image</p>
                        <div class="col-md-12">
                            <a class="cursor_pointer" id="app_android_image_link">
                                <img id="app_android_image" class="app_image" alt="App image">
                            </a>
                            <button class="btn_custom btn_left" id="app_android_left"><span class="glyphicon glyphicon-arrow-left"></span></button>
                            <button class="btn_custom btn_right" id="app_android_right"><span class="glyphicon glyphicon-arrow-right"></span></button>
                        </div>
                    </div>
                    <!-- Creates the bootstrap modal where the image will appear -->
                    <div class="modal fade" id="modal_android_image" tabindex="-1" role="dialog" aria-labelledby="modal_android_label" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="modal_android_label">Image preview</h4>
                          </div>
                          <div class="modal-body">
                            <img src="" id="modal_android_image_preview" class="modal_image" data-dismiss="modal" alt="Clicked app image">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="content_row"></div>
            <div class="row">
                <div class="col-md-12">
                    <div id="services" class="anchor"></div>
                    <h1>Services</h1>
                    <p>I am available for hire as a freelance software/web developer, and general tech guy for help with all things from PC's, phones, TV's etc.  Please fill out the form below to begin.</p>
                    <div id="success_div"></div>
                    <form name="form_email" id="form_email">
                        <div class="col-md-6">
                            <?php
                            include_once("includes/user_reader.php");
                            if ($_SESSION['first_name']) {
                                echo(FIRST_NAME . ' please contact me by filling in the section below and selecting an option.  Anything you post on here will be saved in the communications section of the site where you\'ll be able to review anything we\'ve communicated.');
                                echo('<input type="hidden" id="first_name_input" value="'.FIRST_NAME.'"/>');
                                echo('<div id="first_name_field"></div>');
                                echo('<input type="hidden" id="surname_input" value="'.SURNAME.'"/>');
                                echo('<div id="surname_field"></div>');
                                echo('<input type="hidden" id="email_address_input" value="'.EMAIL.'"/>');
                                echo('<div id="email_address_field"></div>');
                            } else {
                                echo('<b>Your details:</b><br/>');
                                echo('First Name:*<input id="first_name_input" type="text" name="first_name_field" maxlength="100" class="text_field" placeholder="Example" onchange="validate(\'first_name_field\', this.value)" required/>');
                                echo('<div id="first_name_field"></div>');
                                echo('Surname:*<input id="surname_input" type="text" name="surname_field" maxlength="100" class="text_field" placeholder="Example" onchange="validate(\'surname_field\', this.value)" required/>');
                                echo('<div id="surname_field"></div>');
                                echo('Email Address:*<input id="email_address_input" type="text" name="email_address_field" maxlength="100" class="text_field" placeholder="someone@example.com" onchange="validate(\'email_address_field\', this.value)" required/>');
                                echo('<div id="email_address_field"></div>');
                            }?>
                        </div>
                        <div class="col-md-6">
                            <p class="padding_top_2px">What do you want me for?*</p>
                            <div class="checkbox">
                                <input type="radio" name="contact_option" value="Software" required> Software developer<br/>
                            </div>
                            <div class="checkbox">
                                <input type="radio" name="contact_option" value="Website" required> Web developer<br/>
                            </div>
                            <div class="checkbox">
                                <input type="radio" name="contact_option" value="Tech Support" required> Tech guy<br/>
                            </div>
                            <div class="checkbox">
                                <input type="radio" name="contact_option" value="Contact" required> Contact me<br/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p>Brief description of what you're wanting:*</p>
                            <textarea class="text_area" id="details_input" type="text" name="details_field" required onchange="validate('details_field', this.value)" placeholder="Give as much detail as possible, minimum length 10, maximum 5000."></textarea>
                            <div id="details_field"></div>
                            <div class="g-recaptcha" data-sitekey="6LdLUAsUAAAAAK4yeTqjk1-WXJRQj1KTOf5CJICO"></div>
                            <div id="grecaptcha_error"></div>
                            <input class="btn_custom" onclick="checkForm()" type="button" value="Submit"/>
                            <div id="validating_div"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="content_row"></div>
            <div class="row">
                <div class="col-md-12">
                    <div id="about" class="anchor"></div>
                    <h1>About</h1>
                    <img class="about_image" src="media/images/gfaiers.jpg" alt="This is me!">
                    <table class="details_table">
                        <tr>
                            <td class="details_table_titles">Tel:</td><td class="details_table_details"><a href="tel:+447795102820">07795 102820</a></td>
                        </tr>
                        <tr>
                            <td>E:</td><td><a href="mailto:geoff@gfaiers.com?subject=Clicked%20gfaiers.com">geoff@gfaiers.com</a></td>
                        </tr>
                        <tr>
                            <td>Loc:</td><td><a href="https://www.google.co.uk/maps/place/York/@53.9585914,-1.1156107,13z/data=!3m1!4b1!4m5!3m4!1s0x4878c340e19865f1:0x4774ab898a54e4d1!8m2!3d53.9599651!4d-1.0872979" target="_blank">York, England</a></td>
                        </tr>
                     
                    </table>
                    <p>I've worked in retail since November 2006, now with over 10 years service to the customers of York.  I'm wanting to find some work in the IT industry, preferably Android or web development.  If you like what you've seen on my site here, then please don't hesitate to contact me on the form above.  I'll do my best to reply to all questions as quickly as possible.</p>
                    <table class="networking_table">
                        <th class="networking_table_header">
                            <a class="about_network" href="http://www.facebook.com/gfaiers"><img class="about_network_images" src="media/images/fb.png" alt="Facebook"></a>
                        </th>
                        <th class="networking_table_header">
                            <a class="about_network" href="http://twitter.com/gfaiers"><img class="about_network_images" src="media/images/twitter.png" alt="Twitter"></a>
                        </th>
                        <th class="networking_table_header">
                            <a class="about_network" href="http://uk.linkedin.com/in/gfaiers"><img class="about_network_images" src="media/images/linkedin.png" alt="LinkedIn"></a>
                        </th>
                        <th class="networking_table_header">
                            <a class="about_network" href="https://github.com/gfaiers"><img class="about_network_images" src="media/images/github.png" alt="GitHub"></a>
                        </th>
                        <th class="networking_table_header">
                            <a class="about_network" href="https://www.sololearn.com/Profile/2522476"><img class="about_network_images" src="media/images/sololearn.png" alt="SoloLearn"></a>
                        </th>
                        <th class="networking_table_header">
                            <a class="about_network" href="http://stackoverflow.com/users/6271175/geoff"><img class="about_network_images" src="media/images/stackoverflow.png" alt="StackOverflow"></a>
                        </th>
                    </table>
                </div>
            </div>
            <div class="content_row"></div>
        </div>
    </main>
    <footer>
        <small>Some icons used with <a href="http://getbootstrap.com/" target="_blank">Bootstrap</a> by courtesy of <a href="http://glyphicons.com/" target="_blank">Glyphicons</a>. </small><br/>
    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script> <!-- required for bootstrap -->
    <script src="js/zxcvbn.js"></script> <!-- zxcvbn password checker -->
    <script src="js/javascript_functions.js"></script> <!-- Javascript functions -->
    <script src="js/jquery_functions.js"></script> <!-- jQuery functions -->
    <script src='https://www.google.com/recaptcha/api.js'></script> <!-- Google reCAPTCHA -->
    <?php include_once("includes/cookie_cutter.php");?>
</body>
</html>