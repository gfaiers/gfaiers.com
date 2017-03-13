<?php
include_once 'db_connect.php';
// Check connection
if (!$connection) {
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
$sql = "DELETE FROM auth_tokens WHERE expires < '".date('Y-m-d H:i:s', time())."'";
if (!mysqli_query($connection, $sql)) {
    echo('Error ' . mysqli_error($connection));
}