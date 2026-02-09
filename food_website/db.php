<?php
session_start();
$conn = mysqli_connect("localhost","root","","food_db");
if(!$conn){
    die("Database connection failed");
}
?>