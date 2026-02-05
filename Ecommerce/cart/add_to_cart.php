<?php
session_start();
include '../config/db.php';
$uid = $_SESSION['user'];
$pid = intval($_GET['id']);

mysqli_query($conn,"INSERT INTO cart(user_id,product_id,qty) VALUES($uid,$pid,1)");
header("Location: cart.php");