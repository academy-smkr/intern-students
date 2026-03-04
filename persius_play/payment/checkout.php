<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Cart is empty');
}

// 2️⃣ Decide payment status
if ($method === 'COD') {
     $payment_status = 'Bank Transfer Pending';
} else {
     $payment_status = 'Card Payment Confirmed';
}


// 3️⃣ Insert order
mysqli_query($conn, "
     INSERT INTO orders (user_id, total, payment_status)
     VALUES ($uid, $total, '$payment_status')
");
$order_id = mysqli_insert_id($conn);

// 4️⃣ Insert each cart item into order_items
$cart_items = mysqli_query($conn, "
     SELECT c.product_id, c.qty, p.price
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");
while ($item = mysqli_fetch_assoc($cart_items)) {
    $pid = $item['product_id'];
    $qty = $item['qty'];
    $price = $item['price'];
    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, qty, price) VALUES ($order_id, $pid, $qty, $price)");
}

// 5️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Subscription Confirmed - GameCloud</title>

<style>
body {
     font-family: Arial, sans-serif;
     background: #f4f6f8;
    margin: 0;
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: #ffffff;
     padding: 15px 30px;
     color: #333;
     border-bottom:1px solid #e9ecef;
}

.navbar a {
     color: #6c757d;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.icon {
     font-size: 60px;
     color: #6c757d;
}

.success-container h1 {
     color: #6c757d;
     margin-bottom: 10px;
}

.success-container h3 {
     color: #6c757d;
     margin-bottom: 20px;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: #6c757d;
}

.btn-success {
     background: #6c757d;
}
</style>
</head>

<body>

<div class="navbar">
     <h2>GameCloud</h2>
     <div>
         <a href="../index.php">Home</a>
         <a href="../games.php">Games</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Subscription Confirmed!</h1>

     <h3>
         Monthly Cost: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $payment_status ?></b>
     </p>

     <a href="../index.php" class="btn btn-primary">Browse More Games</a><br>
     <a href="../my_subscriptions.php" class="btn btn-success">View My Library</a>
</div>

</body>
</html>