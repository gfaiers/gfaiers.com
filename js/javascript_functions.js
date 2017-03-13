/*jslint browser: true, devel: true, plusplus: true*/
/*global $, zxcvbn*/
var intPasswordScore = 0;

function validateMatchReg() {
    "use strict";
    var password1 = document.getElementById("modal_register_password"),
        password2 = document.getElementById("modal_register_password_2"),
        password1_val = password1.value,
        password2_val = password2.value;
    
    if (password1_val !== password2_val) {
        document.getElementById("modal_register_password_2_error").innerHTML = '<div class="alert alert-danger" role="alert">Passwords don\'t match.</div>';
    } else {
        document.getElementById("modal_register_password_2_error").innerHTML = '';
    }
}

function validateMatchForgot() {
    "use strict";
    var password1 = document.getElementById("modal_forgot_password"),
        password2 = document.getElementById("modal_forgot_password_2"),
        password1_val = password1.value,
        password2_val = password2.value;
    
    if (password1_val !== password2_val) {
        document.getElementById("modal_forgot_password_2_error").innerHTML = '<div class="alert alert-danger" role="alert">Passwords don\'t match.</div>';
    } else {
        document.getElementById("modal_forgot_password_2_error").innerHTML = '';
    }
}

// AJAX code to check input field values when onblur event triggerd.
function validate(field, query) {
    "use strict";
    var xmlhttp;
    if (window.XMLHttpRequest) { // for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // for IE6, IE5
        xmlhttp = new window.ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState !== 4 && xmlhttp.status === 200) {
            document.getElementById(field).innerHTML = "Validating..";
        } else if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById(field).innerHTML = xmlhttp.responseText;
        } else {
            document.getElementById(field).innerHTML = '<div class="alert alert-danger" role="alert">Error Occurred. <a href="index.php">Reload Or Try Again</a></div>';
        }
    };
    xmlhttp.open("GET", "/validation.php?field=" + field + "&query=" + query, false);
    xmlhttp.send();
}

function checkPasswordReg(password) {
    "use strict";
    var str_0 = document.getElementById("modal_register_strength_0"),
        str_1 = document.getElementById("modal_register_strength_1"),
        str_2 = document.getElementById("modal_register_strength_2"),
        str_3 = document.getElementById("modal_register_strength_3"),
        str_4 = document.getElementById("modal_register_strength_4"),
        str_5 = document.getElementById("modal_register_strength_5"),
        str_6 = document.getElementById("modal_register_strength_6"),
        str_7 = document.getElementById("modal_register_strength_7"),
        str_8 = document.getElementById("modal_register_strength_8"),
        str_9 = document.getElementById("modal_register_strength_9"),
        password_error = document.getElementById("modal_register_password_error"),
        passwordToCheck = "",
        ret;
    // make all invisible
    str_0.style.backgroundColor = '#ffffff';
    str_1.style.backgroundColor = '#ffffff';
    str_2.style.backgroundColor = '#ffffff';
    str_3.style.backgroundColor = '#ffffff';
    str_4.style.backgroundColor = '#ffffff';
    str_5.style.backgroundColor = '#ffffff';
    str_6.style.backgroundColor = '#ffffff';
    str_7.style.backgroundColor = '#ffffff';
    str_8.style.backgroundColor = '#ffffff';
    str_9.style.backgroundColor = '#ffffff';
    if (password !== '') {
        // if the password is longer than 50 characters, then ignore anything past point 50
        password_error.innerHTML = '';
        if (password.length >= 51) {
            passwordToCheck = password.slice(-50);
        } else {
            passwordToCheck = password;
        }
        // check the amount of the password that needs to be checked
        ret = zxcvbn(passwordToCheck);
        switch ((ret.score)) {
        case 0:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            break;
        case 1:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            break;
        case 2:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            break;
        case 3:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            str_6.style.backgroundColor = '#bfff00';
            str_7.style.backgroundColor = '#80ff00';
            break;
        case 4:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            str_6.style.backgroundColor = '#bfff00';
            str_7.style.backgroundColor = '#80ff00';
            str_8.style.backgroundColor = '#40ff00';
            str_9.style.backgroundColor = '#00ff00';
            break;
        }
        validateMatchReg();
        return (ret.score);
    }
    validateMatchReg();
}

function checkPasswordForgot(password) {
    "use strict";
    var str_0 = document.getElementById("modal_forgot_strength_0"),
        str_1 = document.getElementById("modal_forgot_strength_1"),
        str_2 = document.getElementById("modal_forgot_strength_2"),
        str_3 = document.getElementById("modal_forgot_strength_3"),
        str_4 = document.getElementById("modal_forgot_strength_4"),
        str_5 = document.getElementById("modal_forgot_strength_5"),
        str_6 = document.getElementById("modal_forgot_strength_6"),
        str_7 = document.getElementById("modal_forgot_strength_7"),
        str_8 = document.getElementById("modal_forgot_strength_8"),
        str_9 = document.getElementById("modal_forgot_strength_9"),
        password_error = document.getElementById("modal_register_password_error"),
        passwordToCheck = "",
        ret;
    // make all invisible
    str_0.style.backgroundColor = '#ffffff';
    str_1.style.backgroundColor = '#ffffff';
    str_2.style.backgroundColor = '#ffffff';
    str_3.style.backgroundColor = '#ffffff';
    str_4.style.backgroundColor = '#ffffff';
    str_5.style.backgroundColor = '#ffffff';
    str_6.style.backgroundColor = '#ffffff';
    str_7.style.backgroundColor = '#ffffff';
    str_8.style.backgroundColor = '#ffffff';
    str_9.style.backgroundColor = '#ffffff';
    if (password !== '') {
        // if the password is longer than 50 characters, then ignore anything past point 50
        password_error.innerHTML = '';
        if (password.length >= 51) {
            passwordToCheck = password.slice(-50);
        } else {
            passwordToCheck = password;
        }
        // check the amount of the password that needs to be checked
        ret = zxcvbn(passwordToCheck);
        switch ((ret.score)) {
        case 0:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            break;
        case 1:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            break;
        case 2:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            break;
        case 3:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            str_6.style.backgroundColor = '#bfff00';
            str_7.style.backgroundColor = '#80ff00';
            break;
        case 4:
            str_0.style.backgroundColor = '#ff0000';
            str_1.style.backgroundColor = '#ff4000';
            str_2.style.backgroundColor = '#ff8000';
            str_3.style.backgroundColor = '#ffaa00';
            str_4.style.backgroundColor = '#ffbf00';
            str_5.style.backgroundColor = '#ffff00';
            str_6.style.backgroundColor = '#bfff00';
            str_7.style.backgroundColor = '#80ff00';
            str_8.style.backgroundColor = '#40ff00';
            str_9.style.backgroundColor = '#00ff00';
            break;
        }
        validateMatchForgot();
        return (ret.score);
    }
    validateMatchForgot();
}

function checkForm() {
    "use strict";
    // Fetching values from all input fields and storing them in variables.
    var first_name_input = document.getElementById("first_name_input"),
        surname_input = document.getElementById("surname_input"),
        email_address_input = document.getElementById("email_address_input"),
        details_input = document.getElementById("details_input"),
        first_name_field = document.getElementById("first_name_field"),
        surname_field = document.getElementById("surname_field"),
        email_address_field = document.getElementById("email_address_field"),
        details_field = document.getElementById("details_field"),
        g_recaptcha_field = document.getElementById("g-recaptcha-response"),
        g_recaptcha_error = document.getElementById("grecaptcha_error"),
        first_name = first_name_input.value,
        surname = surname_input.value,
        email_address = email_address_input.value,
        details = details_input.value,
        g_recaptcha = g_recaptcha_field.value,
        boolComplete = true,
        boolComplete2 = true;
    //Check input Fields Should not be blanks.
    if (g_recaptcha === '') {
        boolComplete = false;
        g_recaptcha_error.innerHTML = '<div class="alert alert-danger" role="alert">Please click on the reCAPTCHA box123.</div>';
    }
    if (details === '') {
        boolComplete = false;
        details_field.innerHTML = '<div class="alert alert-danger" role="alert">Please provide some details.</div>';
        details_input.focus();
    }
    if (email_address === '') {
        boolComplete = false;
        email_address_field.innerHTML = '<div class="alert alert-danger" role="alert">Please enter an email address.</div>';
        email_address_input.focus();
    }
    if (surname === '') {
        boolComplete = false;
        surname_field.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your surname.</div>';
        surname_input.focus();
    }
    if (first_name === '') {
        boolComplete = false;
        first_name_field.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your first name.</div>';
        first_name_input.focus();
    }
    // All the fields are completed (or have some content in them)
    
    if (boolComplete === true) {
        // all the fields have been filled in, now check if the document contents is correct
        validate('details_field', details);
        if (details_field.innerHTML !== '') {
            boolComplete2 = false;
            details_input.focus();
        }
        validate('email_address_field', email_address);
        if (email_address_field.innerHTML !== '') {
            boolComplete2 = false;
            email_address_input.focus();
        }
        validate('surname_field', surname);
        if (surname_field.innerHTML !== '') {
            boolComplete2 = false;
            surname_input.focus();
        }
        validate('first_name_field', first_name);
        if (first_name_field.innerHTML !== '') {
            boolComplete2 = false;
            first_name_input.focus();
        }
        validate('grecaptcha_error', g_recaptcha);
        if (g_recaptcha_error.innerHTML !== '') {
            boolComplete2 = false;
        }
        if (boolComplete2 === true) {
            $.fn.send_mail();
        }
    }
}

// Check the Login form
function checkLogin() {
    "use strict";
    // get elements from forms
    var email_element = document.getElementById("modal_login_email"),
        password_element = document.getElementById("modal_login_password"),
        email_error = document.getElementById("modal_login_email_error"),
        password_error = document.getElementById("modal_login_password_error"),
        email = email_element.value,
        password = password_element.value,
        boolComplete = true,
        boolComplete2 = true;
    // check for empty fields, if they are empty warn user
    if (password === '') {
        boolComplete = false;
        password_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your password.</div>';
        password_element.focus();
    }
    if (email === '') {
        boolComplete = false;
        email_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email address.</div>';
        email_element.focus();
    }
    // check for correct values for the email
    if (boolComplete === true) {
        validate('modal_login_email_error', email);
        if (email_error.innerHTML !== '') {
            boolComplete2 = false;
            email_element.focus();
        }
        if (boolComplete2 === true) {
            $.fn.login_user();
        }
    }
}

// Check the Register form
function checkRegister() {
    "use strict";
    // get elements from forms
    var first_name_element = document.getElementById("modal_register_first_name"),
        surname_element = document.getElementById("modal_register_surname"),
        email_element = document.getElementById("modal_register_email"),
        password_element = document.getElementById("modal_register_password"),
        password_2_element = document.getElementById("modal_register_password_2"),
        first_name_error = document.getElementById("modal_register_first_name_error"),
        surname_error = document.getElementById("modal_register_surname_error"),
        email_error = document.getElementById("modal_register_email_error"),
        password_error = document.getElementById("modal_register_password_error"),
        password_2_error = document.getElementById("modal_register_password_2_error"),
        first_name = first_name_element.value,
        surname = surname_element.value,
        email = email_element.value,
        password = password_element.value,
        password_2 = password_2_element.value,
        boolComplete = true,
        boolComplete2 = true,
        intPassword;
    // check for empty fields, if they are empty warn user
    if (password_2 === '') {
        boolComplete = false;
        password_2_error.innerHTML = '<div class="alert alert-danger" role="alert">Please re-enter the password.</div>';
        password_2_element.focus();
    }
    if (password === '') {
        boolComplete = false;
        password_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter a password.</div>';
        password_element.focus();
    }
    if (email === '') {
        boolComplete = false;
        email_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email address.</div>';
        email_element.focus();
    }
    if (surname === '') {
        boolComplete = false;
        surname_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your surname.</div>';
        surname_element.focus();
    }
    if (first_name === '') {
        boolComplete = false;
        first_name_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your first name.</div>';
        first_name_element.focus();
    }
    // check for correct values
    if (boolComplete === true) {
        validateMatchReg();
        if (password_2_error.innerHTML !== '') {
            boolComplete2 = false;
            password_2_element.focus();
        }
        intPassword = checkPasswordReg(password);
        if (intPassword <= 2) {
            boolComplete2 = false;
            password_element.focus();
        }
        validate('modal_register_email_error', email);
        if (email_error.innerHTML !== '') {
            boolComplete2 = false;
            first_name_element.focus();
        }
        validate('modal_register_surname_error', surname);
        if (surname_error.innerHTML !== '') {
            boolComplete2 = false;
            surname_element.focus();
        }
        validate('modal_register_first_name_error', first_name);
        if (first_name_error.innerHTML !== '') {
            boolComplete2 = false;
            first_name_element.focus();
        }
        if (boolComplete2 === true) {
            $.fn.register_user();
        }
    }
}

// Check the Forgot Password form
function checkForgot() {
    "use strict";
    // get elements from forms
    var email_element = document.getElementById("modal_forgot_email"),
        email_error = document.getElementById("modal_forgot_email_error"),
        email = email_element.value,
        boolComplete = true,
        boolComplete2 = true;
    // check for empty fields, if they are empty warn user
    if (email === '') {
        boolComplete = false;
        email_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email address.</div>';
        email_element.focus();
    }
    // check for correct values for the email
    if (boolComplete === true) {
        validate('modal_forgot_email_error', email);
        if (email_error.innerHTML !== '') {
            boolComplete2 = false;
            email_element.focus();
        }
        if (boolComplete2 === true) {
            $.fn.forgot_password();
        }
    }
}

// Check the Forgot Password form
function checkResetPassword() {
    "use strict";
    // get elements from forms
    var code_element = document.getElementById("modal_forgot_code"),
        password_element = document.getElementById("modal_forgot_password"),
        password_2_element = document.getElementById("modal_forgot_password_2"),
        code_error = document.getElementById("modal_forgot_code_error"),
        password_error = document.getElementById("modal_forgot_password_error"),
        password_2_error = document.getElementById("modal_forgot_password_2_error"),
        code = code_element.value,
        password = password_element.value,
        password_2 = password_2_element.value,
        boolComplete = true,
        boolComplete2 = true,
        intPassword;
    // check for empty fields, if they are empty warn user
    if (password_2 === '') {
        boolComplete = false;
        password_2_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email address.</div>';
        password_2_element.focus();
    }
    if (password === '') {
        boolComplete = false;
        password_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email address.</div>';
        password_element.focus();
    }
    if (code === '') {
        boolComplete = false;
        code_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter the code.</div>';
        code_element.focus();
    }
    // check for correct values for the email
    if (boolComplete === true) {
        validateMatchForgot();
        if (password_2_error.innerHTML !== '') {
            boolComplete2 = false;
            password_2_element.focus();
        }
        intPassword = checkPasswordForgot(password);
        if (intPassword <= 2) {
            boolComplete2 = false;
            password_element.focus();
        }
        if (code <= 10000) {
            boolComplete2 = false;
            code_error = '<div class="alert alert-danger" role="alert">The code is too small.</div>';
            code_element.focus();
        }
        if (code > 99999) {
            boolComplete2 = false;
            code_error = '<div class="alert alert-danger" role="alert">The code is too big.</div>';
            code_element.focus();
        }
        if (boolComplete2 === true) {
            $.fn.reset_password();
        }
    }
}

// Check the Forgot Password form
function checkPostUpdate() {
    "use strict";
    // get elements from forms
    var title_element = document.getElementById("modal_post_update_title"),
        content_element = document.getElementById("modal_post_update_content"),
        title_error = document.getElementById("modal_post_update_title_error"),
        content_error = document.getElementById("modal_post_update_content_error"),
        title = title_element.value,
        content = content_element.value,
        boolComplete = true,
        boolComplete2 = true;
    // check for empty fields, if they are empty warn user
    if (content === '') {
        boolComplete = false;
        content_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter the content.</div>';
        content_element.focus();
    }
    if (title === '') {
        boolComplete = false;
        title_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter a title.</div>';
        title_element.focus();
    }
    // check for correct values for the email
    if (boolComplete === true) {
        validate('modal_post_update_content_error', content);
        if (content_error.innerHTML !== '') {
            boolComplete2 = false;
            content_element.focus();
        }
        validate('modal_post_update_title_error', title);
        if (title_error.innerHTML !== '') {
            boolComplete2 = false;
            title_element.focus();
        }
    }
}

function deletePost() {
    "use strict";
    $.fn.delete_update();
}

function checkDetails() {
    "use strict";
    var first_name_element = document.getElementById("modal_details_first_name"),
        surname_element = document.getElementById("modal_details_surname"),
        email_element = document.getElementById("modal_details_email"),
        contact_number_element = document.getElementById("modal_details_contact_number"),
        address_line_1_element = document.getElementById("modal_details_address_line_1"),
        address_line_2_element = document.getElementById("modal_details_address_line_2"),
        town_element = document.getElementById("modal_details_town"),
        county_element = document.getElementById("modal_details_county"),
        postcode_element = document.getElementById("modal_details_postcode"),
        first_name_error = document.getElementById("modal_details_first_name_error"),
        surname_error = document.getElementById("modal_details_surname_error"),
        email_error = document.getElementById("modal_details_email_error"),
        contact_number_error = document.getElementById("modal_details_contact_number_error"),
        address_line_1_error = document.getElementById("modal_details_address_line_1_error"),
        address_line_2_error = document.getElementById("modal_details_address_line_2_error"),
        town_error = document.getElementById("modal_details_town_error"),
        county_error = document.getElementById("modal_details_county_error"),
        postcode_error = document.getElementById("modal_details_postcode_error"),
        first_name = first_name_element.value,
        surname = surname_element.value,
        email = email_element.value,
        contact_number = contact_number_element.value,
        address_line_1 = address_line_1_element.value,
        address_line_2 = address_line_2_element.value,
        town = town_element.value,
        county = county_element.value,
        postcode = postcode_element.value,
        boolComplete = true,
        boolComplete2 = true;
    // check for the required fields first
    if (email === '') {
        boolComplete = false;
        email_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your email.</div>';
        email_element.focus();
    }
    if (surname === '') {
        boolComplete = false;
        surname_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your surname.</div>';
        surname_element.focus();
    }
    if (first_name === '') {
        boolComplete = false;
        first_name_error.innerHTML = '<div class="alert alert-danger" role="alert">Please enter your first name.</div>';
        first_name_element.focus();
    }
    if (boolComplete === true) {
        validate("modal_details_postcode_error", postcode);
        if (postcode_error.innerHTML !== '') {
            boolComplete2 = false;
            postcode_element.focus();
        }
        validate("modal_details_county_error", county);
        if (county_error.innerHTML !== '') {
            boolComplete2 = false;
            county_element.focus();
        }
        validate("modal_details_town_error", town);
        if (town_error.innerHTML !== '') {
            boolComplete2 = false;
            town_element.focus();
        }
        validate("modal_details_address_line_2_error", address_line_2);
        if (address_line_2_error.innerHTML !== '') {
            boolComplete2 = false;
            address_line_2_element.focus();
        }
        validate("modal_details_address_line_1_error", address_line_1);
        if (address_line_1_error.innerHTML !== '') {
            boolComplete2 = false;
            address_line_1_element.focus();
        }
        validate("modal_details_contact_number_error", contact_number);
        if (contact_number_error.innerHTML !== '') {
            boolComplete2 = false;
            contact_number_element.focus();
        }
        validate("modal_details_email_error", email);
        if (email_error.innerHTML !== '') {
            boolComplete2 = false;
            email_element.focus();
        }
        validate("modal_details_surname_error", surname);
        if (surname_error.innerHTML !== '') {
            boolComplete2 = false;
            surname_element.focus();
        }
        validate("modal_details_first_name_error", first_name);
        if (first_name_error.innerHTML !== '') {
            boolComplete2 = false;
            first_name_element.focus();
        }
        if (boolComplete2 === true) {
            $.fn.save_details();
        }
    }
}