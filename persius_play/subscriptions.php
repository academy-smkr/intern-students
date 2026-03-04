<?php
session_start();
include('config/db.php'); 

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit();
}

$uid = $_SESSION['user'];

// Fetch all orders for the user
$orders_query = mysqli_query($conn, "
    SELECT * FROM orders
    WHERE user_id = $uid
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Subscriptions - GameCloud</title>
<link rel="stylesheet" href="assets/css/style.css?v=2.0">

<style>
    body {
        font-family: 'Arial', 'Courier New', monospace;
        background: #0a0e27;
        margin: 0;
        padding: 0;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #050810;
        color: #e0e0e0;
        padding: 15px 30px;
        border-bottom: 3px solid #b300ff;
        box-shadow: 0 0 20px rgba(179, 0, 255, 0.5);
    }

    .logo {
        height: 50px;
        width: auto;
        filter: brightness(1.1);
    }

    .navbar a {
        color: #00ffff;
        margin-left: 15px;
        text-decoration: none;
        font-weight: bold;
        text-shadow: 0 0 10px #00ffff;
    }

    .navbar a:hover {
        color: #ff00ff;
        text-shadow: 0 0 15px #ff00ff;
    }

    .orders-container {
        max-width: 900px;
        margin: 50px auto;
        background: #0f1420;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 0 30px rgba(179, 0, 255, 0.3);
        border: 2px solid #b300ff;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #ff00ff;
        text-shadow: 0 0 20px #b300ff;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #b300ff;
        vertical-align: top;
        color: #e0e0e0;
    }

    th {
        background: linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
        color: white;
        font-weight: bold;
        text-shadow: 0 0 10px rgba(179, 0, 255, 0.8);
    }

    tr:hover {
        background-color: rgba(179, 0, 255, 0.1);
    }

    .status-paid {
        color: #00ffff;
        font-weight: bold;
        text-shadow: 0 0 10px #00ffff;
    }

    .status-pending {
        color: #ff00ff;
        font-weight: bold;
        text-shadow: 0 0 10px #ff00ff;
    }

    .status-cod {
        color: #ff00ff;
        font-weight: bold;
        text-shadow: 0 0 10px #ff00ff;
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        background: linear-gradient(135deg, #b300ff 0%, #ff00ff 100%);
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        border: 1px solid #b300ff;
        box-shadow: 0 0 10px rgba(179, 0, 255, 0.5);
        transition: all 0.3s;
    }

    .btn:hover {
        background: linear-gradient(135deg, #ff00ff 0%, #ff006e 100%);
        box-shadow: 0 0 20px rgba(255, 0, 255, 0.8);
        transform: translateY(-2px);
    }

    @media(max-width: 600px){
        table, th, td { font-size: 14px; }
    }
</style>
</head>

<body>

<div class="navbar">
    <img src="assets/images/persius%20logo.png" alt="GameCloud Logo" class="logo" style="height:50px; width:auto;">
    <div>
        <a href="index.php">Home</a>
        <a href="games.php">Games</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<div class="orders-container">
    <h2>My Orders</h2>

<?php if (mysqli_num_rows($orders_query) > 0): ?>
<table>
    <tr>
        <th>Order ID</th>
        <th>Products</th>
        <th>Total Amount</th>
        <th>Payment Status</th>
        <th>Order Date</th>
    </tr>

<?php while ($order = mysqli_fetch_assoc($orders_query)): ?>

<?php
$order_id = $order['id'];
$products_query = mysqli_query($conn, "
    SELECT p.name, c.qty
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = $order_id
");
?>

<tr>
    <td>#<?= $order['id'] ?></td>

    <td>
        <?php while ($prod = mysqli_fetch_assoc($products_query)): ?>
            <?= htmlspecialchars($prod['name']) ?> × <?= $prod['qty'] ?><br>
        <?php endwhile; ?>
    </td>

    <td>
        <?= $order['total'] >= 0 ? '₹' . number_format($order['total'], 2) : '-' ?>
    </td>

    <td>
        <?php
        // ADMIN-MATCHED PAYMENT LOGIC
        if ($order['total'] == 0 || $order['payment_status'] === 'O') {
            echo '<span class="status-cod">Cash on Delivery</span>';
        } elseif (strtolower($order['payment_status']) === 'paid') {
            echo '<span class="status-paid">Paid</span>';
        } else {
            echo '<span class="status-pending">Pending</span>';
        }
        ?>
    </td>

    <td><?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></td>
</tr>

<?php endwhile; ?>
</table>

<?php else: ?>
    <p style="text-align:center;color:#555;">
        You have not placed any orders yet.
        <br><br>
        <a href="games.php" class="btn">Shop Now</a>
    </p>
<?php endif; ?>

</div>
</body>
</html>
