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
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order
mysqli_query($conn, "
     INSERT INTO orders (user_id, total, payment_status)
     VALUES ($uid, $total, '$payment_status')
");
$order_id = mysqli_insert_id($conn);

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
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
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
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
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
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
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>
