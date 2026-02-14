<?php
session_start();

// Admin login check
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

include '../../config/db.php';

// Fetch orders with user info
$res = mysqli_query($conn, "
    SELECT 
        o.id,
        o.user_id,
        o.total,
        o.payment_status,
        o.created_at,
        u.name AS user_name,
        u.email AS user_email
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    ORDER BY o.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PawMart Admin - Pet Orders</title>

<style>
    body {
        margin: 0;
        font-family: 'Nunito', Arial, sans-serif;
        background: #f8f6f2;
        color: #203036;
    }

    .admin-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 220px;
        background: linear-gradient(160deg, #1f6f5f, #1a5b4f);
        color: #fff;
        padding: 20px;
    }

    .sidebar h2 {
        margin-top: 0;
        font-size: 22px;
    }

    .sidebar a {
        display: block;
        color: #fff;
        text-decoration: none;
        margin: 12px 0;
        font-weight: bold;
    }

    .sidebar a:hover {
        color: #ffe2c7;
    }

    .main {
        flex: 1;
        padding: 30px;
    }

    h1 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
    }

    .table-box {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #eee;
    }

    th {
        background: #1f6f5f;
        color: #fff;
    }

    tr:hover {
        background: #f1f3f5;
    }

    .badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        color: #fff;
        font-weight: bold;
        display: inline-block;
    }

    .paid {
        background: #28a745;
    }

    .cod {
        background: #ff7a2f;
    }

    .pending {
        background: #ffc107;
        color: #000;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #666;
    }
</style>
</head>

<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>PawMart Admin</h2>
        <a href="../index.php">Dashboard</a>
        <a href="../products/list.php">Pet Products</a>
        <a href="../users/list.php">Pet Parents</a>
        <a href="../orders/list.php">Pet Orders</a>
        <a href="list.php">Pet Orders</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h1>Pet Orders</h1>

        <div class="table-box">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Pet Parent</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>

                <?php if (mysqli_num_rows($res) > 0): ?>
                    <?php while ($p = mysqli_fetch_assoc($res)): ?>

                        <?php
                        // Payment status logic
                        if ($p['payment_status'] === 'O') {
                            $status_text  = 'Cash on Delivery';
                            $status_class = 'cod';

                        } elseif (strtoupper($p['payment_status']) === 'PAID') {
                            $status_text  = 'PAID';
                            $status_class = 'paid';

                        } else {
                            $status_text  = 'PENDING';
                            $status_class = 'pending';
                        }
                        ?>

                        <tr>
                            <td>#<?= htmlspecialchars($p['id']) ?></td>

                            <td>
                                <?= htmlspecialchars(
                                    $p['user_name'] 
                                    ?? $p['user_email'] 
                                    ?? 'User ID: '.$p['user_id']
                                ) ?>
                            </td>

                            <td>₹<?= number_format($p['total'], 2) ?></td>

                            <td>
                                <span class="badge <?= $status_class ?>">
                                    <?= $status_text ?>
                                </span>
                            </td>

                            <td>
                                <?= date('d M Y, h:i A', strtotime($p['created_at'])) ?>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No pet orders found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

</div>

</body>
</html>
