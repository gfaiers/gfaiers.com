<?php
include_once("includes/sessions.php");
$value = $_GET['query'];
$formfield = $_GET['field'];
$len = 0;
// USER HAS NAVIGATED TO www.gfaiers.com/validation.php
if ($formfield == "") {
    echo 'ERROR NAVIGATION TO THIS DOCUMENT IS PROHIBITED<br/><a href="http://www.gfaiers.com">Return to gfaiers.com</a>';
}

// Check the Services section #######################################################################################################
// first name
if ($formfield == "first_name_field") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}

// surname
if ($formfield == "surname_field") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}

// email address
if ($formfield == "email_address_field") {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
        echo '<div class="alert alert-danger" role="alert">Invalid email.</div>';
    }
}

// details section
if ($formfield == "details_field") {
    if(strlen($value) < 10) {
        echo '<div class="alert alert-danger" role="alert">Please give more detail.</div>';
    }
    if(strlen($value) > 5000) {
        echo '<div class="alert alert-danger" role="alert">You\'ve entered too much text.</div>';
    }
}

// google captcha
if ($formfield == "grecaptcha_error") {
        $captcha = $value;
        $privatekey = "6LdLUAsUAAAAAMYF5ho04DItmWavjsvJgvnvSiyF";
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $privatekey,
            'response' => $captcha,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $curlConfig = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $data
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlConfig);
        $response = curl_exec($ch);
        curl_close($ch);
    

    $jsonResponse = json_decode($response);

    if ($jsonResponse->success === false) {
        echo '<div class="alert alert-danger" role="alert">User varification failed. Please retry.</div>';
    }
}

// Check the LOGIN modal ############################################################################################################
// email
if ($formfield == "modal_login_email_error") {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
        echo '<div class="alert alert-danger" role="alert">Invalid email.</div>';
    }
}

// Check the REGISTER modal #########################################################################################################
// first name
if ($formfield == "modal_register_first_name_error") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}

// surname
if ($formfield == "modal_register_surname_error") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}

// email
if ($formfield == "modal_register_email_error") {
    if (strlen($value) < 5) {
        echo '<div class="alert alert-danger" role="alert">Email too short.</div>';
    }
}

// email
if ($formfield == "modal_register_email_error") {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
        echo '<div class="alert alert-danger" role="alert">Invalid email.</div>';
    }
}


// Check the FORGOT modal ###########################################################################################################
// email
if ($formfield == "modal_forgot_email_error") {
    if (strlen($value) < 5) {
        echo '<div class="alert alert-danger" role="alert">Email too short.</div>';
    }
}

// email
if ($formfield == "modal_forgot_email_error") {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
        echo '<div class="alert alert-danger" role="alert">Invalid email address.</div>';
    }
}

// Check the UPDATE modal ###########################################################################################################
// title
if ($formfield == "modal_post_update_title_error") {
    if (strlen($value) < 4) {
        echo '<div class="alert alert-danger" role="alert">Title too short.</div>';
    }
}

// content
if ($formfield == "modal_post_update_content_error") {
    if (strlen($value) < 10) {
        echo '<div class="alert alert-danger" role="alert">Please give more detail.</div>';
    }
    if (strlen($value) > 2000) {
        echo '<div class="alert alert-danger" role="alert">You\'ve entered too much text.</div>';
    }
}

// Check the DETAILS modal ##########################################################################################################
// first name
if ($formfield == "modal_details_first_name_error") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}
// surname
if ($formfield == "modal_details_surname_error") {
    if (strlen($value) < 2) {
        echo '<div class="alert alert-danger" role="alert">Must be 1+ letters.</div>';
    }
}
//email
if ($formfield == "modal_details_email_error") {
    if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $value)) {
        echo '<div class="alert alert-danger" role="alert">Invalid email address.</div>';
    }
}
//contact number
if ($formfield == "modal_details_contact_number_error") {
    if ($value !== "") {
        if (!preg_match("/^[0-9]/", $value)) {
            echo'<div class="alert alert-danger" role="alert">Invalid contact number.</div>';
        } elseif (strlen($value) < 9) {
            echo '<div class="alert alert-danger" role="alert">Contact number too short.</div>';
        }
    }
}
//address line 1
if ($formfield == "modal_details_address_line_1_error") {
    if ($value !== "") {
        if (strlen($value) < 2) {
            echo '<div class="alert alert-danger" role="alert">Invalid address line 1.</div>';
        }
    }
}
//addresss line 2
if ($formfield == "modal_details_address_line_2_error") {
    if ($value !== "") {
        if (strlen($value) < 2) {
            echo '<div class="alert alert-danger" role="alert">Invalid address line 2.</div>';
        }
    }
}
//town
if ($formfield == "modal_details_town_error") {
    if ($value !== "") {
        if (strlen($value) < 2) {
            echo '<div class="alert alert-danger" role="alert">Invalid town name.</div>';
        }
    }
}
//county
if ($formfield == "modal_details_county_error") {
    if ($value !== "") {
        if (strlen($value) < 4) {
            echo '<div class="alert alert-danger" role="alert">Invalid county name.</div>';
        }
    }
}
//postcode
if ($formfield == "modal_details_postcode_error") {
    if ($value !== "") {
        if (!preg_match('#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#', $value)) {
            echo '<div class="alert alert-danger" role="alert">Invalid postcode.</div>';
        }
    }
}
session_write_close();