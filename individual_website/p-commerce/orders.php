<?php
session_start();
include('config/db.php'); 

if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
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
<title>My Pet Orders - PawMart Pet Shop</title>

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

    .orders-container {
        max-width: 900px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }

    th {
        background-color: var(--brand);
        color: white;
        font-weight: bold;
    }

    .status-paid {
        color: #2e7d32;
        font-weight: bold;
    }

    .status-pending {
        color: #ffb300;
        font-weight: bold;
    }

    .status-cod {
        color: var(--accent);
        font-weight: bold;
    }

    .btn {
        display: inline-block;
        padding: 8px 15px;
        background: var(--accent);
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px;
    }

    .btn:hover {
        background: var(--accent-dark);
    }

    @media(max-width: 600px){
        table, th, td { font-size: 14px; }
    }
</style>
</head>

<body>

<div class="navbar">
    <h2>PawMart</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Pet Supplies</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<div class="orders-container">
    <h2>My Pet Orders</h2>

<?php if (mysqli_num_rows($orders_query) > 0): ?>
<table>
    <tr>
        <th>Order ID</th>
        <th>Pet Items</th>
        <th>Total Amount</th>
        <th>Payment Status</th>
        <th>Order Date</th>
    </tr>

<?php while ($order = mysqli_fetch_assoc($orders_query)): ?>

<?php
$order_id = $order['id'];
$products_query = mysqli_query($conn, "
    SELECT product_name, qty
    FROM order_items
    WHERE order_id = $order_id
");
?>

<tr>
    <td>#<?= $order['id'] ?></td>

    <td>
        <?php if (mysqli_num_rows($products_query) > 0): ?>
            <?php while ($prod = mysqli_fetch_assoc($products_query)): ?>
                <?= htmlspecialchars($prod['product_name']) ?> × <?= $prod['qty'] ?><br>
            <?php endwhile; ?>
        <?php else: ?>
            <em>Items not available</em>
        <?php endif; ?>
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
        <a href="products.php" class="btn">Shop Pet Supplies</a>
    </p>
<?php endif; ?>

</div>
</body>
</html>
