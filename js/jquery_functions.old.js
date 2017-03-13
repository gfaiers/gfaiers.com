/*jslint plusplus: true, browser: true */
/*global $, jQuery, checkLogin, checkRegister, checkPassword, grecaptcha*/
$(document).ready(function () {
    "use strict";
    var imagePath = new Array(4),
        imageString = new Array(4),
        imageNumber = 0,
        imageAndroidPath = new Array(4),
        imageAndroidString = new Array(4),
        imageAndroidNumber = 0,
        showModalRegister = false,
        showModalForgot = false,
        showModalLogin = false;

// app viewers ######################################################################################################################
    // windows
    $("#app_rota").click(function () {
        imagePath[0] = "media/images/rota/1.png";
        imagePath[1] = "media/images/rota/2.png";
        imagePath[2] = "media/images/rota/3.png";
        imagePath[3] = "media/images/rota/4.png";
        imageString[0] = "Blank week rota, 13 of these are available per document. Each with space for 12 colleagues.  Usage of the Kronos section is optional.";
        imageString[1] = "Coded week rota, colour codes are detailed on the key at the bottom, typed in the start time box for each shift.";
        imageString[2] = "Budget calculator, calcuates hours used per calendar month, for this to be 100% effective the previous rota document has to be saved in the same location (detailed on Admin sheet)";
        imageString[3] = "The area you select which store you're trading from (to update each rota sheet), select the location of the previous rota documents, and can make the new rota by clicking the button";
        imageNumber = 0;
        $("#info_blank").hide();
        $("#info_daily_focus").hide();
        $("#info_oola").hide();
        $("#info_offline_audit").hide();
        $("#info_rota").fadeIn(250);
        $("#app_windows_scroller").fadeIn(250);
        $("#app_windows_image").attr("src", imagePath[imageNumber]);
        $("#app_windows_image_text").text(imageString[imageNumber]);
        $('html, body').animate({
            scrollTop: $("#windows").offset().top
        }, 250);
    });
    $("#app_daily_focus").click(function () {
        imagePath[0] = "media/images/daily_focus/1.png";
        imagePath[1] = "media/images/daily_focus/2.png";
        imagePath[2] = "media/images/daily_focus/3.png";
        imagePath[3] = "media/images/daily_focus/4.png";
        imageString[0] = "The top of the sheet has admin information for stores open hours, and set targets for the stores colleagues.  The lower part of the screen is the data entry section, at store close of trade fill in the information for the days sales.  The 2 buttons are used to update store targets (based off a quarterly targets document), and to print the Daily Focus sheet and splash sheet (image 2 and 3).";
        imageString[1] = "The daily focus sheet, this sheet is to be used by stores daily to help keep track of colleague performance.  Each colleague is assigned a target based on how many hours they're doing (taken from the Quarterly Rota document).  The management for the day sets a team brief for colleagues to follow at the top of the sheet.";
        imageString[2] = "A splash screen, gives a quick run down of the stores figures.  This is printed daily to make sure all colleagues are aware of their store performance.  The information based on this sheet is displayed by the 445 calendar (displays errors in this image as no figures in system).";
        imageString[3] = "A bonus calculator built into the system for stores to track how they're performing for the months pay bonus.  Tracked daily and for the full calendar month.";
        imageNumber = 0;
        $("#info_blank").hide();
        $("#info_rota").hide();
        $("#info_oola").hide();
        $("#info_offline_audit").hide();
        $("#info_daily_focus").fadeIn(250);
        $("#app_windows_scroller").fadeIn(250);
        $("#app_windows_image").attr("src", imagePath[imageNumber]);
        $("#app_windows_image_text").text(imageString[imageNumber]);
        $('html, body').animate({
            scrollTop: $("#windows").offset().top
        }, 250);
    });
    // android
    $("#app_hangman").click(function () {
        imageAndroidPath[0] = "media/images/hangman/1.webp";
        imageAndroidPath[1] = "media/images/hangman/2.webp";
        imageAndroidPath[2] = "media/images/hangman/3.webp";
        imageAndroidPath[3] = "media/images/hangman/4.webp";
        imageAndroidString[0] = "The welcome screen for Hangman.  Giving the options of New Game, Best Times, and Settings.";
        imageAndroidString[1] = "This shows the demo playing to it's self, successfully guessing the word, Hangman.";
        imageAndroidString[2] = "The game screen, with 1 life left.";
        imageAndroidString[3] = "The settings menu, in this menu you can change the word length (min and max), the number of lives (5-15), the word list that's used, and if you want you can input your own word list.";
        imageAndroidNumber = 0;
        $("#info_android_blank").hide();
        $("#info_reactions").hide();
        $("#info_crocs_reactions").hide();
        $("#info_hangman").fadeIn(250);
        $("#app_android_scroller").fadeIn(250);
        $("#app_android_image").attr("src", imageAndroidPath[imageAndroidNumber]);
        $("#app_android_image_text").text(imageAndroidString[imageAndroidNumber]);
        $('html, body').animate({
            scrollTop: $("#android").offset().top
        }, 250);
    });
    $("#app_reactions").click(function () {
        imageAndroidPath[0] = "media/images/reactions/1.webp";
        imageAndroidPath[1] = "media/images/reactions/2.webp";
        imageAndroidPath[2] = "media/images/reactions/3.webp";
        imageAndroidPath[3] = "media/images/reactions/4.webp";
        imageAndroidString[0] = "The game screen.  Game in play.";
        imageAndroidString[1] = "After the game has been completed, a new high score is displayed if you've beaten your previous best.";
        imageAndroidString[2] = "The High Scores screen, displaying the local high scores for 10 and 15 second games also has the option to view the Play Games high scores, and the Achievements that you've unlocked.";
        imageAndroidString[3] = "The app icon.";
        imageAndroidNumber = 0;
        $("#info_android_blank").hide();
        $("#info_hangman").hide();
        $("#info_crocs_reactions").hide();
        $("#info_reactions").fadeIn(250);
        $("#app_android_scroller").fadeIn(250);
        $("#app_android_image").attr("src", imageAndroidPath[imageAndroidNumber]);
        $("#app_android_image_text").text(imageAndroidString[imageAndroidNumber]);
        $('html, body').animate({
            scrollTop: $("#android").offset().top
        }, 250);
    });
    $("#app_crocs_reactions").click(function () {
        imageAndroidPath[0] = "media/images/crocsreactions/1.png";
        imageAndroidPath[1] = "media/images/crocsreactions/2.png";
        imageAndroidPath[2] = "media/images/crocsreactions/3.png";
        imageAndroidPath[3] = "media/images/crocsreactions/4.png";
        imageAndroidString[0] = "Welcome screen when game is loaded.  The image bar at the bottom is scrollable, displaying: How to play - displays basic how to play instructions in 3 separate windows, New Game - loads a game of set length, Website - loads the crocs website in the default browser, High Scores - displays the high scores on the Play Games leader board, Achievements  - displays the available and unlocked achievements.";
        imageAndroidString[1] = "After 10 games has been played, then every 10 after that till the player selects OK or NEVER, the player is prompted to rate the game on the Play Store.";
        imageAndroidString[2] = "The game screen, the brighter colored the clog that's touched the higher the points that will be awarded.  If the player mis-hits then they'll lose the points that they would have earnt.";
        imageAndroidString[3] = "The end game screen, displaying the score that the player has achieved.";
        imageAndroidNumber = 0;
        $("#info_android_blank").hide();
        $("#info_hangman").hide();
        $("#info_reactions").hide();
        $("#info_crocs_reactions").fadeIn(250);
        $("#app_android_scroller").fadeIn(250);
        $("#app_android_image").attr("src", imageAndroidPath[imageAndroidNumber]);
        $("#app_android_image_text").text(imageAndroidString[imageAndroidNumber]);
        $('html, body').animate({
            scrollTop: $("#android").offset().top
        }, 250);
    });

// image scrollers ##################################################################################################################
    $("#app_windows_left").click(function () {
        if (imageNumber === 0) {
            imageNumber = 3;
        } else {
            imageNumber--;
        }
        $("#app_windows_image").attr("src", imagePath[imageNumber]);
        $("#app_windows_image_text").text(imageString[imageNumber]);
    });
    $("#app_windows_right").click(function () {
        if (imageNumber === 3) {
            imageNumber = 0;
        } else {
            imageNumber++;
        }
        $("#app_windows_image").attr("src", imagePath[imageNumber]);
        $("#app_windows_image_text").text(imageString[imageNumber]);
    });
    $("#app_android_left").click(function () {
        if (imageAndroidNumber === 0) {
            imageAndroidNumber = 3;
        } else {
            imageAndroidNumber--;
        }
        $("#app_android_image").attr("src", imageAndroidPath[imageAndroidNumber]);
        $("#app_android_image_text").text(imageAndroidString[imageAndroidNumber]);
    });
    $("#app_android_right").click(function () {
        if (imageAndroidNumber === 0) {
            imageAndroidNumber = 3;
        } else {
            imageAndroidNumber--;
        }
        $("#app_android_image").attr("src", imageAndroidPath[imageAndroidNumber]);
        $("#app_android_image_text").text(imageAndroidString[imageAndroidNumber]);
    });

    // to make the modal appear from clicking an image
    $("#app_windows_image_link").on("click", function () {
        $('html, body').animate({
            scrollTop: $("#windows").offset().top
        }, 0);
        $("#modal_windows_image_preview").attr("src", $("#app_windows_image").attr("src"));
        $("#modal_windows_image").modal("show");
        $("#modal_windows_label").text(imageString[imageNumber]);
    });
    $("#app_android_image_link").on("click", function () {
        $('html, body').animate({
            scrollTop: $("#android").offset().top
        }, 0);
        $("#modal_android_image_preview").attr("src", $("#app_android_image").attr("src"));
        $("#modal_android_image").modal("show");
        $("#modal_android_label").text(imageAndroidString[imageAndroidNumber]);
    });
    
// the navbar #######################################################################################################################
    $('#nav_downloads').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $('html, body').animate({
            scrollTop: $("#downloads").offset().top
        }, 250);
    });
    $('#nav_services').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $('html, body').animate({
            scrollTop: $("#services").offset().top
        }, 250);
    });
    $('#nav_about').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $('html, body').animate({
            scrollTop: $("#about").offset().top
        }, 250);
    });
    $('#nav_login').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $("#modal_login").modal("show");
    });
    $('#nav_details').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $("#modal_details").modal("show");
    });
    $('#nav_communications').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        window.location.replace("https://www.gfaiers.com/communications/");
    });
    $('#nav_post_update').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $("#modal_post_update").modal("show");
    });
    $('#nav_post_delete').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $("#modal_post_delete").modal("show");
    });
    $('#nav_user_admin').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        alert("user_admin");
    });
    $('#nav_logout').on('click', function () {
        $('.navbar-collapse').collapse('hide');
        $.fn.log_out();
    });


// modals ###########################################################################################################################


    // the login modal
    $('#modal_login').on('shown.bs.modal', function () {
        $('#modal_login_email').focus();
    });
    $('#modal_login').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //clears previously entered information from the modal
        $('#modal_login_email_error').empty();
        $('#modal_login_password_error').empty();
        $('#modal_login_message').empty();
        if (showModalRegister) {
            $('#modal_register').modal('show');
            showModalRegister = false;
        }
        if (showModalForgot) {
            $('#modal_forgot').modal('show');
            showModalForgot = false;
        }
    });
    $("#login_register").click(function () {
        $('#modal_login').modal('hide');
        showModalRegister = true;
    });
    $("#login_forgot").click(function () {
        $('#modal_login').modal('hide');
        showModalForgot = true;
    });
    $('.login_on_enter').keydown(function (event) {
        // enter has keyCode = 13
        if (event.keyCode === 13) {
            checkLogin();
            return false;
        }
    });
    
    // the register modal
    $('#modal_register').on('shown.bs.modal', function () {
        $('#modal_register_first_name').focus();
    });

    $('#modal_register').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //clears previously entered information from the modal
        // clear all the fields that display user errors
        $('#modal_register_first_name_error').empty();
        $('#modal_register_surname_error').empty();
        $('#modal_register_email_error').empty();
        $('#modal_register_password_error').empty();
        $('#modal_register_password_2_error').empty();
        $('#modal_register_message').empty();
        if (showModalLogin === true) {
            $('#modal_login').modal('show');
            showModalLogin = false;
        }
        checkPassword(); // this is called to set the background color of the password checker to white again
    });
    $('.register_on_enter').keydown(function (event) {
        // enter has keyCode = 13
        if (event.keyCode === 13) {
            checkRegister();
            return false;
        }
    });
    // the forgot modal
    $('#modal_forgot').on('shown.bs.modal', function () {
        $('#modal_forgot_email').focus();
    });

    $('#modal_forgot').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //clears previously entered information from the modal
        $('#modal_forgot_message').empty();
        $('#modal_forgot_email_error').empty();
        $('#modal_forgot_password_error').empty();
        $('#modal_forgot_password_2_error').empty();
        $('#modal_forgot_title').show();
        $('#modal_reset_title').hide();
        $('#modal_forgot_email_div').show();
        $('#modal_forgot_reset_password').hide();
        $('#modal_forgot_button').show();
        $('#modal_reset_button').hide();
        $('#modal_forgot_email').focus();
        if (showModalLogin === true) {
            $('#modal_login').modal('show');
            showModalLogin = false;
        }
    });
    // the post update modal
    $('#modal_post_update').on('shown.bs.modal', function () {
        $('#modal_post_update_title').focus();
    });
    
    $('#modal_post_update').on('hidden.bs.modal', function () {
        $(this).find('form')[0].reset(); //clears previously entered information from the modal
        $('#modal_post_update_message').empty();
        $('#modal_post_update_title_error').empty();
        $('#modal_post_update_content_error').empty();
    });
    
// for the uparrow when the page is scrolled past 50 pixel (height of navbar)
    $('.up_arrow').on('click', function () {
        $('html, body').animate({
            scrollTop: $(".navbar").offset().top
        }, 250);
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.up_arrow').fadeIn(250);
        }
        if ($(this).scrollTop() < 50) {
            $('.up_arrow').fadeOut(250);
        }
    });

// ajax functions ###################################################################################################################
    // to send the email for the button SUBMIT
    $.fn.send_mail = function () {
        var first_name = $('#first_name_input').val(),
            surname = $('#surname_input').val(),
            email_address = $('#email_address_input').val(),
            contact_option = $('input[name=contact_option]:checked', '#form_email').val(),
            details = $('#details_input').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/mailHandler.php',
            data: {first_name_post: first_name, surname_post: surname, email_address_post: email_address, contact_option_post: contact_option, details_post: details},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // logged in user sending the post
                    $('#success_div').html(response);
                    $('html, body').animate({
                        scrollTop: $("#services").offset().top
                    }, 0);
                }
                if (result === "B") {
                    // new user sending the post
                    $('#modal_register').modal('show');
                    $('#modal_register_message').html(response);
                    $('#modal_register_first_name').val(first_name);
                    $('#modal_register_surname').val(surname);
                    $('#modal_register_email').val(email_address);
                    $('#modal_register_contact_option').val(contact_option);
                    $('#modal_register_contact_details').val(details);
                    // this needs to save the contact option and the details in a hidden field on the modal register form
                    // then when they choose to register, if those values have any content then add them to the table ready for them to be viewed once registered.
                }
                if (result === "C") {
                    // existing user, not logged in sending the post
                    $('#modal_login').modal('show');
                    $('#modal_login_message').html(response);
                    $('#modal_login_email').val(email_address);
                    $('#modal_login_contact_option').val(contact_option);
                    $('#modal_login_contact_details').val(details);
                    // this needs to save the contact option and the details in a hidden field on the modal register form
                    // then when they choose to register, if those values have any content then add them to the table ready for them to be viewed once registered.
                }
                $('#form_email')[0].reset();
                grecaptcha.reset();
            }
        });
    };

    // for LOGIN
    $.fn.login_user = function () {
        var email = $('#modal_login_email').val(),
            password = $('#modal_login_password').val(),
            rememberMe = $('input:checkbox:checked').val(),
            contact_option = $('#modal_login_contact_option').val(),
            contact_details = $('#modal_login_contact_details').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/login.php',
            data: {email_post: email, password_post: password, remember_me_post: rememberMe, contact_option_post: contact_option, contact_details_post: contact_details},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    location.reload();
                }
                if (result === "B") {
                    // NOT REGISTERED / DATABASE ERROR / ACCOUNT LOCKED OUT
                    $('#modal_login_message').html(response);
                }
                if (result === "C") {
                    // INCORRECT PASSWORD
                    $('#modal_login_password_error').html(response);
                    $('#modal_login_password').focus();
                }
            }
        });
    };
    
    // for REGISTER
    $.fn.register_user = function () {
        var first_name = $('#modal_register_first_name').val(),
            surname = $('#modal_register_surname').val(),
            email = $('#modal_register_email').val(),
            password = $('#modal_register_password').val(),
            contact_option = $('#modal_register_contact_option').val(),
            contact_details = $('#modal_register_contact_details').val(),
            result,
            response;
        alert("option: " + contact_option + "details: " + contact_details);
        $.ajax({
            type: 'POST',
            url: '../php/registration.php',
            data: {first_name_post: first_name, surname_post: surname, email_post: email, password_post: password, contact_option_post: contact_option, contact_details_post: contact_details},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    showModalLogin = true;
                    $('#modal_register').modal('hide');
                    $('#modal_login_message').html(response);
                }
                if (result === "B") {
                    // FAILED
                    $('#modal_register_message').html(response);
                }
            }
        });
    };
    
    // for FORGOT PASSWORD
    $.fn.forgot_password = function () {
        var email = $('#modal_forgot_email').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/forgot.php',
            data: {email_post: email},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    $('#modal_forgot_title').hide();
                    $('#modal_reset_title').show();
                    $('#modal_forgot_email_div').hide();
                    $('#modal_forgot_reset_password').show();
                    $('#modal_forgot_button').hide();
                    $('#modal_reset_button').show();
                    $('#modal_forgot_code').focus();
                }
                if (result === "B") {
                    // FAILED
                    $('#modal_forgot_message').html(response);
                }
            }
        });
    };
    
    // for RESET PASSWORD
    $.fn.reset_password = function () {
        var code = $('#modal_forgot_code').val(),
            email = $('#modal_forgot_email').val(),
            password = $('#modal_forgot_password').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/resetPassword.php',
            data: {code_post: code, email_post: email, password_post: password},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                showModalLogin = true;
                $('#modal_forgot').modal('hide');
                $('#modal_login_message').html(response);
            }
        });
    };
    // for LOGOUT
    $.fn.log_out = function () {
        $.ajax({
            type: 'POST',
            url: '../php/logout.php',
            success: function (response) {
                location.reload();
            }
        });
    };
    
    // for POST UPDATE
    $.fn.post_update = function () {
        var title = $('#modal_post_update_title').val(),
            content = $('#modal_post_update_content').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/updates.php',
            data: {title_post: title, content_post: content},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    location.reload();
                }
                if (result === "B") {
                    // FAILED
                    $('#modal_post_update_message').html(response);
                }
            }
        });
    };
    
    // for DELETE UPDATE
    $.fn.delete_update = function () {
        var title = $('#modal_post_delete_title').val(),
            author = $('#modal_post_delete_author').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/deleteUpdate.php',
            data: {title_post: title, author_post: author},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    // needs to repopulate the modal drop down instead of reload
                    location.reload();
                }
                if (result === "B") {
                    // FAILED
                    $('#modal_post_delete_message').html(response);
                }
            }
        });
    };
    
    // for SAVE NEW DETAILS
    $.fn.save_details = function () {
        var first_name = $('#modal_details_first_name').val(),
            surname = $('#modal_details_surname').val(),
            email = $('#modal_details_email').val(),
            contact_number = $('#modal_details_contact_number').val(),
            address_line_1 = $('#modal_details_address_line_1').val(),
            address_line_2 = $('#modal_details_address_line_2').val(),
            town = $('#modal_details_town').val(),
            county = $('#modal_details_county').val(),
            postcode = $('#modal_details_postcode').val(),
            result,
            response;
        $.ajax({
            type: 'POST',
            url: '../php/saveDetails.php',
            data: {first_name_post: first_name, surname_post: surname, email_post: email, contact_number_post: contact_number, address_line_1_post: address_line_1, address_line_2_post: address_line_2, town_post: town, county_post: county, postcode_post: postcode},
            success: function (full_response) {
                result = full_response.substring(0, 1);
                response = full_response.substring(1, full_response.length);
                if (result === "A") {
                    // SUCCESS
                    $('#modal_details_message').html(response);
                }
                if (result === "B") {
                    // FAILED
                    $('#modal_details_message').html(response);
                }
            }
        });
    };
    
// for communications.php ###################################################################################################################
    
    $('#comms_nav_downloads').on('click', function () {
        window.open("https://www.gfaiers.com/");
        $('html, body').animate({
            scrollTop: $("#downloads").offset().top
        }, 250);
    });
    $('#comms_nav_services').on('click', function () {
        window.open("https://www.gfaiers.com/");
        $('html, body').animate({
            scrollTop: $("#services").offset().top
        }, 250);
    });
    $('#comms_nav_about').on('click', function () {
        window.open("https://www.gfaiers.com/")
        $('html, body').animate({
            scrollTop: $("#about").offset().top
        }, 250);
    });
    
    $(window).on('resize', function () {
        if ($(document).width() <= 768) {
            // hide the thread pane
            // display the messages pane
            $('.thread_pane').hide();
            $('.messages_pane').show();
        } else {
            $('.thread_pane').show();
            $('.messages_pane').show();
        }
    });
    $(".info_panel_btn").click(function () {
        $('.thread_pane').show();
        $('.messages_pane').hide();
        $('.messages_area').empty();
    });
                               
    $(".thread_message").click(function () {
        if ($(document).width() <= 768) {
            // hide the thread pane
            // display the messages pane
            $('.thread_pane').hide();
            $('.messages_pane').show();
        }
        var session_id = $(this).find(".session_id").val(),
            user_email = $(this).find(".user_email").val(),
            contact_name = $(this).find(".thread_sender").text(),
            from_or_to,
            details,
            timestamp;
        $.ajax({
            type: 'POST',
            url: '../php/loadCommunications.php',
            dataType: "json",
            data: {session_id_post: session_id},
            success: function (response) {
                // this needs to load in the messages that are loaded from loadCommunications.php
                $('.messages_area').empty();
                $.each(response, function () {
                    $.each(this, function (index, value) {
                        // read the message and details into variables
                        if (index === "sender") {
                            if (value === user_email) {
                                from_or_to = "from";
                            } else {
                                from_or_to = "to";
                            }
                        }
                        if (index === "details") {
                            details = value;
                        }
                        if (index === "date") {
                            timestamp = value;
                        }
                    });
                    // add the variables into the messages area
                    $('.messages_area').append('<div class="' + from_or_to + '_holder"><div class="' + from_or_to + '"><small>' + timestamp + '</small><p>' + details + '</p></div></div>');
                });
                $('.messages_area').scrollTop($('.messages_area')[0].scrollHeight);
                $('.submit_session_id').val(session_id);
                $('.info_panel_name').text(contact_name);
                $('.submit_message_text').focus();
            },
            error: function (response) {
                console.log("Err: " + response.status);
            }
        });
    });
    
    $('.submit_message_button').click(function () {
        // this runs when the button is clicked to send the message.
        var user_email = $('.user_email').val(),
            session_id = $('.submit_session_id').val(),
            message = $('.submit_message_text').val(),
            timestamp = new Date().toISOString().slice(0, 19).replace('T', ' '),
            result,
            response;
        if (message !== "") {
            // the message to send is not nothing, proceed
            $.ajax({
                type: 'POST',
                url: '../php/sendMessage.php',
                data: {user_email_post: user_email, session_id_post: session_id, message_post: message, timestamp_post: timestamp},
                success: function (full_response) {
                    result = full_response.substring(0, 1);
                    response = full_response.substring(1, full_response.length);
                    if (result === "A") {
                        $('.messages_area').append('<div class="from_holder"><div class="from"><small>' + timestamp + '</small><p>' + message + '</p></div></div>');
                    }
                    if (result === "B") {
                        console.log("Err: " + response);
                    }
                    $('.messages_area').scrollTop($('.messages_area')[0].scrollHeight);
                    $('.submit_message_text').val('');
                    $('.submit_message_text').focus();
                },
                error: function (response) {
                    console.log("Err: " + response.status);
                }
            });
        } else {
            $('.submit_message_text').focus();
        }
    });
});