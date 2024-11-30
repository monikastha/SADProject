<?php
$conn = mysqli_connect('localhost', 'root', '', 'online_portfolio', '3307');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
