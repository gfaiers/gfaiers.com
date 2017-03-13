<?php
if ($_POST['title_post'] == '') {
    header("HTTP/1.1 403 Forbidden");
    echo "<h1>403 Forbidden</h1>";
    echo "Navigation to this page is not allowed.";
    exit;
}
include_once("../includes/db_connect.php");
// Check connection
if (!$connection) {
    mysqli_close($connection);
    die('<div class="alert alert-danger" role="alert"><h1>Connection failed</h1>' . mysqli_connect_error() . '</div>');
}
// FOR READING FROM updates
$sql = "DELETE FROM updates WHERE title='".$_POST['title_post']."' AND author='".$_POST['author_post']."'";
if (mysqli_query($connection, $sql)) {
    echo 'A';
} else {
    echo 'B<div class="alert alert-danger" role="alert"><h3>Error</h3>Error deleting entry.</div>';
}
mysqli_close($connection);