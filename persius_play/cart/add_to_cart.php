<?php
session_start();
include '../config/db.php';

$uid = $_SESSION['user'];
$pid = intval($_GET['id']);

// Check if the game is already in the cart
$check = mysqli_query($conn, "SELECT id, qty FROM cart WHERE user_id=$uid AND product_id=$pid");
if ($row = mysqli_fetch_assoc($check)) {
	// If exists, increment qty
	$cart_id = $row['id'];
	$new_qty = $row['qty'] + 1;
	mysqli_query($conn, "UPDATE cart SET qty=$new_qty WHERE id=$cart_id");
} else {
	// If not, insert new row
	mysqli_query($conn, "INSERT INTO cart(user_id,product_id,qty) VALUES($uid,$pid,1)");
}
header("Location: cart.php");
