/*jslint plusplus: true, browser: true */
/*global $, jQuery, checkLogin, checkRegister, checkPassword, grecaptcha*/
$(document).ready(function () {
    "use strict";
    $('#comms_nav_downloads').on('click', function () {
        window.location.replace("https://www.gfaiers.com/");
        $('html, body').animate({
            scrollTop: $("#downloads").offset().top
        }, 250);
    });
    $('#comms_nav_services').on('click', function () {
        window.location.replace("https://www.gfaiers.com/");
        $('html, body').animate({
            scrollTop: $("#services").offset().top
        }, 250);
    });
    $('#comms_nav_about').on('click', function () {
        window.location.replace("https://www.gfaiers.com/");
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
        var thread_id = $(this).find(".thread_id").val(),
            user_email = $(this).find(".user_email").val(),
            contact_name = $(this).find(".thread_sender").text(),
            from_or_to,
            details,
            timestamp,
            status;
        $.ajax({
            type: 'POST',
            url: '../php/loadMessages.php',
            dataType: "json",
            data: {thread_id_post: thread_id, user_email_post: user_email},
            success: function (response) {
                // this needs to load in the messages that are loaded from loadCommunications.php
                $('.messages_area').empty();
                $.each(response, function () {
                    $.each(this, function (index, value) {
                        // read the message and details into variables
                        if (index === "sender_id") {
                            if (value === user_email) {
                                from_or_to = "from";
                            } else {
                                from_or_to = "to";
                            }
                        }
                        if (index === "content") {
                            details = value;
                        }
                        if (index === "status") {
                            status = value;
                        }
                        if (index === "timestamp") {
                            timestamp = value;
                        }
                    });
                    // add the variables into the messages area
                    $('.messages_area').append(
                        '<div class="' + from_or_to + '_holder"><div class="' + from_or_to + '"><small>' + timestamp + '</small><p>' + details + '</p></div></div>'
                    );
                });
                $('.messages_area').scrollTop($('.messages_area')[0].scrollHeight);
                $('.submit_user_email').val(user_email);
                $('.submit_thread_id').val(thread_id);
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
            thread_id = $('.submit_thread_id').val(),
            message = $('.submit_message_text').val(),
            timestamp = new Date().toISOString().slice(0, 19).replace('T', ' '),
            result,
            response;
        if (message !== "") {
            // the message to send is not nothing, proceed
            $.ajax({
                type: 'POST',
                url: '../php/sendMessage.php',
                data: {user_email_post: user_email, thread_id_post: thread_id, message_post: message, timestamp_post: timestamp},
                success: function (full_response) {
                    result = full_response.substring(0, 1);
                    response = full_response.substring(1, full_response.length);
                    if (result === "A") {
                        $('.messages_area').append(
                            '<div class="from_holder"><div class="from"><small>' + timestamp + '</small><p>' + message + '</p></div></div>'
                        );
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
    function addmsg(type, content, timestamp) {
        /* Simple helper to add a div.
        type is the name of a CSS class (old/new/error).
        msg is the contents of the div */
        $('.messages_area').append(
            '<div class="' + type + '_holder"><div class="' + type + '"><small>' + timestamp + '</small><p>' + content + '</p></div></div>'
        );
        $('.messages_area').scrollTop($('.messages_area')[0].scrollHeight);
    }

    function waitForMsg() {
        /* This requests the url "msgsrv.php"
        When it complete (or errors)*/
        var user_email = $('.user_email').val(),
            thread_id = $('.submit_thread_id').val(),
            type,
            content,
            timestamp;
        console.log("ID: " + thread_id + " EM: " + user_email);
        // this needs to query if a thread has been selected, only run if one has
        if (thread_id !== "") {
            $.ajax({
                type: "POST",
                url: "../php/messageReceiver.php",
                data: {thread_id_post: thread_id, user_email_post: user_email},
                dataType: "json",
                async: true, /* If set to non-async, browser shows page as "Loading.."*/
                cache: false,
                timeout: 50000, /* Timeout in ms */
                success: function (response) { /* called when request to messageReceiver.php completes */
                    $.each(response, function () {
                        $.each(this, function (index, value) {
                            // read the message and details into variables
                            if (index === "sender_id") {
                                if (value === user_email) {
                                    type = "from";
                                } else {
                                    type = "to";
                                }
                            }
                            if (index === "content") {
                                content = value;
                            }
                            if (index === "timestamp") {
                                timestamp = value;
                            }
                        });
                        console.log(type);
                        if (type !== "") {
                            addmsg(type, content, timestamp); /* Add response to a .msg div (with the "new" class)*/
                        }
                    });
                    setTimeout(
                        waitForMsg, /* Request next message */
                        1000 /* ..after 1 seconds */
                    );
                },
                error: function (XMLHttpRequest, textStatus, errorThrown, response) {
                    console.log("error", textStatus + " (" + errorThrown + ") " + response);
                    setTimeout(waitForMsg, 15000);
                }
            });
        } else {
            setTimeout(
                waitForMsg, /* Request a message */
                1000 /* ..after 1 seconds */
            );
        }
    }
    
    function updateThreads() {
        // this has to load through the different threads and update 
        // each one that has any waiting messages
        // then update the notification number on the thread (next to the name)
    }

    waitForMsg(); /* Start the inital request */
    updateThreads(); /* Start the request for thread updates */
});