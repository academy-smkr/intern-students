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
$order_id = mysqli_insert_id($conn);

// Snapshot order items
mysqli_query($conn, "
    INSERT INTO order_items (order_id, product_id, product_name, price, qty)
    SELECT $order_id, p.id, p.name, p.price, c.qty
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id=$uid
");

// Clear the cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id=$uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Success - PawMart Pet Shop</title>
<style>
    :root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
    body {
        font-family: 'Nunito', Arial, sans-serif;
        background: var(--bg);
        margin: 0;
        padding: 0;
        color: var(--ink);
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(120deg, var(--brand), var(--brand-dark));
        color: white;
        padding: 15px 30px;
    }
    .navbar a {
        color: white;
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
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
        text-align: center;
    }

    .success-container h1 {
        font-size: 48px;
        color: #2e7d32;
        margin-bottom: 10px;
    }

    .success-container h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    .success-container h3 {
        font-size: 22px;
        color: var(--brand);
        margin-bottom: 30px;
    }

    .success-container p {
        color: #555;
        line-height: 1.6;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background: var(--brand);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
    }
    .btn:hover {
        background: var(--brand-dark);
    }

    .icon-check {
        font-size: 60px;
        color: #2e7d32;
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
    <h2>PawMart</h2>
    <div>
        <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="success-container">
    <div class="icon-check">✔️</div>
    <h1>Payment Successful!</h1>
    <h2>Thank you for your pet order.</h2>
    <h3>Bill Amount: ₹<?= number_format($total, 2) ?></h3>
    <p>Your pet order has been placed successfully. You will receive a confirmation email shortly.</p>
    <a href="../index.php" class="btn">Continue Pet Shopping</a>
    <a href="../orders.php" class="btn" style="background:#28a745; margin-left:10px;">View Pet Orders</a>
</div>

</body>
</html>
