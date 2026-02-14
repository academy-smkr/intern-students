<?php

$conn = mysqli_connect("localhost","root","","campusfind");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
