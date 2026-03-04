<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

$uid = $_SESSION['user'];
$total = 0;

// Fetch total from cart
$q = mysqli_query($conn, "
    SELECT p.price, c.qty 
    FROM cart c 
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$uid
");

while($r = mysqli_fetch_assoc($q)){
    $total += $r['price'] * $r['qty'];
}

// Insert order into orders table
mysqli_query($conn, "INSERT INTO orders(user_id, total, payment_status) VALUES($uid, $total, 'PAID')");

// Clear the cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id=$uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success - MyShop</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
        margin: 0;
        padding: 0;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
        color: #333;
        padding: 15px 30px;
        border-bottom:1px solid #e9ecef;
    }
    .navbar a {
        color: #6c757d;
        margin-left: 15px;
        text-decoration: none;
        font-weight: bold;
    }

    .success-container {
        max-width: 500px;
        margin: 80px auto;
        background: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        text-align: center;
    }

    .success-container h1 {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .success-container h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    .success-container h3 {
        font-size: 22px;
        color: #6c757d;
        margin-bottom: 30px;
    }

    .success-container p {
        color: #555;
        line-height: 1.6;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background: #6c757d;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn:hover {
        background: #495057;
    }

    .icon-check {
        font-size: 60px;
        color: #6c757d;
        margin-bottom: 20px;
    }

    @media(max-width: 600px){
        .success-container { margin: 50px 20px; padding: 30px; }
        .success-container h1 { font-size: 40px; }
        .success-container h2 { font-size: 24px; }
        .success-container h3 { font-size: 20px; }
    }
</style>
</head>
<body>

<div class="navbar">
    <h2>MyShop</h2>
    <div>
        <a href="../index.php">Home</a>
        <a href="../product.php">Products</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="success-container">
    <div class="icon-check">✔️</div>
    <h1>Payment Successful!</h1>
    <h2>Thank you for your order.</h2>
    <h3>Bill Amount: ₹<?= number_format($total, 2) ?></h3>
    <p>Your order has been placed successfully. You will receive a confirmation email shortly.</p>
    <a href="../index.php" class="btn">Continue Shopping</a>
    <a href="../subscriptions.php" class="btn" style="background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%); margin-left:10px;">View Subscriptions</a> 
</div>

</body>
</html>
