<?php
include_once("../includes/functions.php");
include_once("../includes/db_connect.php");

// Check connection
if (!$connection) {
    session_write_close();
    die('B<div class="alert alert-danger" role="alert"><h3>Connection failed</h3>' . mysqli_connect_error() . '</div>');
}
// need to get the author name still
//FOR WRITING TO updates
$author = "Geoff";
$time = date("Y-m-d H:i:s");
$title = $_POST['title_post'];
$content = $_POST['content_post'];
$sql = "INSERT INTO updates (author, time, title, content) VALUES ('".$author."', '".$time."', '".$title."', '".$content."')";
if (mysqli_query($connection, $sql)) {
    echo 'A';
} else {
    echo 'B<div class="alert alert-danger" role="alert"><h3>Error</h3>'.mysqli_error($connection).'</div>';
}
session_write_close();
mysqli_close($connection);