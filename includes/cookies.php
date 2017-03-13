<?php
include_once("sessions.php");
// check if the cookie is set, if it is, then continue
if(isset($_COOKIE[$cookie_name])) {
    // unencrypt the cookie
    include_once('functions.php');
    include_once("security.php");
    
    $cookie = pkcs7_unpad(openssl_decrypt(
        $_COOKIE[$cookie_name],
        'AES-256-CBC',
        $cookie_key,
        0,
        $cookie_iv
    ));
    //$cookie = $_COOKIE[$cookie_name];
    $session = substr($cookie, 0, 32);
    $cookie_orig_auth = substr($cookie, 32, 32);
    $cookie_email = substr($cookie, 64, strlen($cookie));
    $email = pkcs7_unpad(openssl_decrypt(
        $cookie_email,
        'AES-256-CBC',
        $cookie_key,
        0,
        $cookie_iv
    ));
    include_once("db_connect.php");
    // Check connection
    if (!$connection) {
        die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
    }
    // here it needs to load the database, check the tokens vs 
    $enc_email = openssl_encrypt(
        pkcs7_pad($email, 16),  // padded data
        'AES-256-CBC',          // cipher and mode
        $encryption_key,        // secret key
        0,                      // options (not used)
        $secret_iv              // initialisation vector (for set value)
    );
    // this needs to check if the cookie is connecting from the right IP address before letting into the database (then it won't be able to be stolen) 
    //in the database store the auth as a hash, then in here store the auth as plain number.  That way for the hacker to use the file they'll have nothing that's got encrypted values from the database, and it'll have to have the matching IP address, and a value that matches in the database.  It also needs to check that the cookie isn't expired in the database (it never should be though, as the cookie will expire it's self at the same point)
    $sql_auth_tokens = "SELECT * FROM auth_tokens WHERE session='".$session."' AND userid = '".$enc_email."'";
    $check = mysqli_query($connection, $sql_auth_tokens) or die('COOKIE ERROR '.mysqli_error($connection));
    $check2 = mysqli_num_rows($check);
    if ($check2 != 0) {
        while($row_auth_tokens = mysqli_fetch_assoc($check)) {
            // records found that match the IP and the EMAIL
            $auth_db = $row_auth_tokens["auth"];
            $expiration = $row_auth_tokens['expires'];
            if (date('Y-m-d H:s:s', time()) > $expiration) {
                unset($_COOKIE[$cookie_name]);
                setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
                session_write_close();
                header("Location: https://www.gfaiers.com");
                // echo("The cookie in the database has expired");
                // this needs to delete the record in the table
                //die();
            } else {
                if (password_verify($cookie_orig_auth, $auth_db)) { // varify the auth in the cookie is correct
                    $sql_users_read = "SELECT * FROM users WHERE id = '".$enc_email."'";
                    $check = mysqli_query($connection, $sql_users_read) or die('B<div class="alert alert-danger" role="alert">'. mysqli_error($connection) .'</div>');
                    $check2 = mysqli_num_rows($check);
                    if ($check != 0) {
                        // output data of each row
                        // this should only run through once, as only one email will be found
                        while($row_users = mysqli_fetch_assoc($check)) {
                            $enc_iv = $row_users['iv'];
                            $iv = pkcs7_unpad(openssl_decrypt(
                                $enc_iv,
                                'AES-256-CBC',
                                $encryption_key,
                                0,
                                $secret_iv
                            ));
                            $enc_first_name = $row_users['first_name'];
                            $first_name = pkcs7_unpad(openssl_decrypt(
                                $enc_first_name,
                                'AES-256-CBC',
                                $encryption_key,
                                0,
                                $iv
                            ));
                            $rights = $row_users['rights'];
                            $_SESSION['first_name'] = $first_name;
                            $_SESSION['user_id'] = $enc_email;
                            $_SESSION['rights'] = $rights;
                            //make a new auth code and UPDATE it to the table, also create a new cookie with this auth
                            $new_auth = bin2hex(openssl_random_pseudo_bytes(16)); // new auth token (new one generated each login for the individual login session)
                            $auth_hash = password_hash($new_auth, PASSWORD_BCRYPT, ['cost' => 10]);
                            $cookie_temp = $session.$new_auth.$cookie_email;
                            $cookie_value = openssl_encrypt(
                                pkcs7_pad($cookie_temp, 16),  // padded data
                                'AES-256-CBC',          // cipher and mode
                                $cookie_key,        // secret key
                                0,                      // options (not used)
                                $cookie_iv              // initialisation vector (for set value)
                            );
                            $expire = time() + (86400 * 28);
                            $expiration = date('Y-m-d H:i:s', $expire); // 86400 = 1 day * 28 = 4 weeks
                            $sql_update_cookie = "UPDATE auth_tokens SET auth='".$auth_hash."', expires='".$expiration."' WHERE session='".$session."'";
                            if (!mysqli_query($connection, $sql_update_cookie)) {
                                echo('Error ' . mysqli_error($connection));
                            }
                            // cookie name, value, expiration time, directory ("/" is for whole site) , true is for httponly (javascript can't access cookie)
                            setcookie($cookie_name, $cookie_value, $expire, '/', NULL, NULL, true);
                            session_write_close();
                            // echo("User logged in. Cookie session $session---Cookie auth: $new_auth---Cookie email: $cookie_email---Cookie expiration: $expiration");
                        }
                    } else {
                        unset($_COOKIE[$cookie_name]);
                        setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
                        session_write_close();
                        header("Location: https://www.gfaiers.com");
                        // echo("The cookie is for a valid user, it's got a valid auth, but the user isn't found in the users table. Session: $session---original auth: $cookie_orig_auth---auth_db: $auth_db---user: $enc_email");
                        //die();
                    }
                } else {
                    unset($_COOKIE[$cookie_name]);
                    setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
                    session_write_close();
                    header("Location: https://www.gfaiers.com");
                    // echo("Invalid cookie, the auth code is incorrect. Session: $session---original auth: $cookie_orig_auth---auth_db: $auth_db---user: $enc_email");
                    //die();
                }
            }
        }
    } else {
        unset($_COOKIE[$cookie_name]);
        setcookie($cookie_name, '', 1, '/', NULL, NULL, true);
        session_write_close();
        header("Location: https://www.gfaiers.com");
        // echo("Invalid cookie, not found in database. Session: $session---original auth: $cookie_orig_auth---auth_db: $auth_db---user: $enc_email");
        //die();
    }
}