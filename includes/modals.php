<?php
include_once 'sessions.php';
if (!isset($_SESSION['rights'])) { // user not logged in
?>
    <!-- LOGIN MODAL -->
    <div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal_h3">User Login</h3>
                    <form name="modal_form_login" id="modal_form_login">
                        <div id="modal_login_message"></div>
                        <input class="modal_display_text login_on_enter" id="modal_login_email" type="text" placeholder="Email" onchange="validate('modal_login_email_error', this.value)"><br/>
                        <div id="modal_login_email_error"></div>
                        <input class="modal_display_text login_on_enter" id="modal_login_password" type="password" placeholder="Password"><br/>
                        <div id="modal_login_password_error"></div>
                        <input class="modal_remember_me login_on_enter" name="modal_login_remember_me" id="modal_remember_me" type="checkbox"> Remember me
                        <input type="hidden" id="modal_login_contact_option">
                        <input type="hidden" id="modal_login_contact_details">
                        <input class="btn_custom modal_display_button" type="button" value="Login" onclick="checkLogin()">
                    </form>
                    <small><a class="cursor_pointer" id="login_register">Register</a> - <a class="cursor_pointer" id="login_forgot">Forgot Password</a></small>
                </div>
            </div>
        </div>
    </div>
    <!-- REGISTER MODAL -->
    <div class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal_h3">Register</h3>
                    <form name="modal_form_register" id="modal_form_register">
                        <div id="modal_register_message"></div>
                        <input class="modal_display_text register_on_enter" id="modal_register_first_name" type="text" placeholder="First Name" onchange="validate('modal_register_first_name_error', this.value)"><br/>
                        <div id="modal_register_first_name_error"></div>
                        <input class="modal_display_text register_on_enter" id="modal_register_surname" type="text" placeholder="Surname" onchange="validate('modal_register_surname_error', this.value)"><br/>
                        <div id="modal_register_surname_error"></div>
                        <input class="modal_display_text register_on_enter" id="modal_register_email" type="text" placeholder="Email" onchange="validate('modal_register_email_error', this.value)"><br/>
                        <div id="modal_register_email_error"></div>
                        <input class="modal_display_text register_on_enter" id="modal_register_password" type="password" placeholder="Password" onchange="checkPasswordReg(this.value)" onkeypress="this.onchange();" oninput="this.onchange();"><br/>
                        <table class="password_strength">
                            <th id="modal_register_strength_0"></th>
                            <th id="modal_register_strength_1"></th>
                            <th id="modal_register_strength_2"></th>
                            <th id="modal_register_strength_3"></th>
                            <th id="modal_register_strength_4"></th>
                            <th id="modal_register_strength_5"></th>
                            <th id="modal_register_strength_6"></th>
                            <th id="modal_register_strength_7"></th>
                            <th id="modal_register_strength_8"></th>
                            <th id="modal_register_strength_9"></th>
                        </table>
                        <div id="modal_register_password_error"></div>
                        <input class="modal_display_text register_on_enter" id="modal_register_password_2" type="password" placeholder="Repeat Password" onchange="validateMatchReg()" onkeypress="this.onchange();" oninput="this.onchange();"><br/>
                        <div id="modal_register_password_2_error"></div>
                        <input type="hidden" id="modal_register_contact_option">
                        <input type="hidden" id="modal_register_contact_details">
                        <input class="btn_custom modal_display_button" type="button" value="Register" onclick="checkRegister()">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- FORGOT PASSWORD MODAL -->
    <div class="modal fade" id="modal_forgot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 id="modal_forgot_title" class="modal_h3">Forgot Password</h3>
                    <h3 id="modal_reset_title" class="modal_h3 hidden_element">Reset Password</h3>
                    <form name="modal_form_forgot" id="modal_form_forgot">
                        <div id="modal_forgot_message"></div>
                        <div id="modal_forgot_email_div">
                            <input class="modal_display_text" id="modal_forgot_email" type="text" placeholder="Email" onchange="validate('modal_forgot_email_error', this.value)"><br/>
                            <div id="modal_forgot_email_error"></div>
                        </div>
                        <div id="modal_forgot_reset_password" class="hidden_element">
                            <p>You've been emailed a temporary 5-digit code, please input it here to reset your password.</p>
                            <input class="modal_display_text" id="modal_forgot_code" type="text" placeholder="Emailed code">
                            <div id="modal_forgot_code_error"></div>
                            <input class="modal_display_text" id="modal_forgot_password" type="password" placeholder="New Password" onchange="checkPasswordForgot(this.value)" onkeypress="this.onchange();" oninput="this.onchange();"><br/>
                            <table class="password_strength">
                                <th id="modal_forgot_strength_0"></th>
                                <th id="modal_forgot_strength_1"></th>
                                <th id="modal_forgot_strength_2"></th>
                                <th id="modal_forgot_strength_3"></th>
                                <th id="modal_forgot_strength_4"></th>
                                <th id="modal_forgot_strength_5"></th>
                                <th id="modal_forgot_strength_6"></th>
                                <th id="modal_forgot_strength_7"></th>
                                <th id="modal_forgot_strength_8"></th>
                                <th id="modal_forgot_strength_9"></th>
                            </table>
                            <div id="modal_forgot_password_error"></div>
                            <input class="modal_display_text" id="modal_forgot_password_2" type="password" placeholder="Repeat Password" onchange="validateMatchForgot()" onkeypress="this.onchange();" oninput="this.onchange();"><br/>
                            <div id="modal_forgot_password_2_error"></div>
                        </div>
                        <input id="modal_forgot_button" class="btn_custom modal_display_button" type="button" value="Email Me" onclick="checkForgot()">
                        <input id="modal_reset_button" class="btn_custom modal_display_button hidden_element" type="button" value="Reset Password" onclick="checkResetPassword()">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
<?php } else { ?>
    
    <!-- DETAILS MODAL -->
    <div class="modal fade" id="modal_details" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal_h3">Details</h3>
                    <form name="modal_form_details" id="modal_form_details">
                        <div id="modal_details_message"></div>
                        <?php
                        include_once("includes/user_reader.php");
                        echo('<input class="modal_display_text" id="modal_details_first_name" type="text" onchange="validate(\'modal_details_first_name_error\', this.value)" placeholder="First Name" value="'.FIRST_NAME.'">');
                        echo('<div id="modal_details_first_name_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_surname" type="text" onchange="validate(\'modal_details_surname_error\', this.value)" placeholder="Surname" value="'.SURNAME.'">');
                        echo('<div id="modal_details_surname_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_email" type="text" onchange="validate(\'modal_details_email_error\', this.value)" placeholder="Email" value="'.EMAIL.'">');
                        echo('<div id="modal_details_email_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_contact_number" type="text" onchange="validate(\'modal_details_contact_number_error\', this.value)" onkeyup="this.value = this.value.replace(/[^\d]+/g, \'\');" placeholder="Contact Number" value="'.CONTACT_NUMBER.'">');
                        echo('<div id="modal_details_contact_number_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_address_line_1" type="text" onchange="validate(\'modal_details_address_line_1_error\', this.value)" placeholder="Address Line 1" value="'.ADDRESS_LINE_1.'">');
                        echo('<div id="modal_details_address_line_1_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_address_line_2" type="text" onchange="validate(\'modal_details_address_line_2_error\', this.value)" placeholder="Address Line 2" value="'.ADDRESS_LINE_2.'">');
                        echo('<div id="modal_details_address_line_2_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_town" type="text" onchange="validate(\'modal_details_town_error\', this.value)" placeholder="Town" value="'.TOWN.'">');
                        echo('<div id="modal_details_town_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_county" type="text" onchange="validate(\'modal_details_county_error\', this.value)" placeholder="County" value="'.COUNTY.'">');
                        echo('<div id="modal_details_county_error"></div>');
                        echo('<input class="modal_display_text" id="modal_details_postcode" type="text" onchange="validate(\'modal_details_postcode_error\', this.value)" placeholder="Postcode" value="'.POSTCODE.'">');
                        echo('<div id="modal_details_postcode_error"></div>');?>
                        <input class="btn_custom modal_display_button" type="button" value="Save" onclick="checkDetails()">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }
if ($_SESSION['rights'] == 1) { ?>
    <!-- POST UPDATE MODAL -->
    <div class="modal fade" id="modal_post_update" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal_h3">Update Post</h3>
                    <form name="modal_form_post_update" id="modal_form_post_update">
                        <div id="modal_post_update_message"></div>
                        <input class="modal_display_text" id="modal_post_update_title" type="text" placeholder="Title" onchange="validate('modal_post_update_title_error', this.value)"><br/>
                        <div id="modal_post_update_title_error"></div>
                        <textarea class="text_area" placeholder="Update content, mininum 10 characters, maximum 1000 characters." id="modal_post_update_content" onchange="validate('modal_post_update_content_error', this.value)" required></textarea>
                        <div id="modal_post_update_content_error"></div>
                        <input class="btn_custom modal_display_button" type="button" value="Post Update" onclick="checkPostUpdate()">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- POST DELETE MODAL -->
    <div class="modal fade" id="modal_post_delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal_display">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal_h3">Delete Post</h3>
                    <form name="modal_form_post_delete" id="modal_form_post_delete">
                        <div id="modal_post_delete_message"></div>
                        <?php
                        include_once("includes/db_connect.php");
                        // Check connection
                        if (!$connection) {
                            die('<div class="alert alert-danger" role="alert"><h1>Connection failed</h1>' . mysqli_connect_error() . '</div>');
                        }
                        // FOR READING FROM updates
                        $sql = "SELECT time, title, content FROM updates WHERE author='".$_SESSION['first_name']."' ORDER BY time DESC";
                        $check = mysqli_query($connection, $sql) or die(mysqli_error($connection));
                        $check2 = mysqli_num_rows($check);
                        if ($check2 != 0) {
                            echo 'Please select which update you wish to delete';
                            echo '<input type="hidden" id="modal_post_delete_author" value="'.$_SESSION['first_name'].'">';
                            echo '<select id="modal_post_delete_title" class="drop_down">';
                            while($row = mysqli_fetch_assoc($check)) {
                                $time = $row['time'];
                                $title = $row['title'];
                                $conent = $row['content'];
                                echo '<option value="'.$title.'">'.$title.'</option>';
                            }
                            echo '</select>';
                            echo '<input class="btn_custom modal_display_button" type="button" value="Delete Update" onclick="deletePost()">';
                        } else {
                            // the number of rows is 0, so there is no update done before by this author
                            echo 'No updates to delete.';
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php }
if (isset($_SESSION['rights'])) { // user is logged in with any rights?>
<?php } ?>