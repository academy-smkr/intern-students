<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../../config/db.php';
include '../includes/header.php';

$res = mysqli_query($conn, "
    SELECT id, user_id, total, payment_status, created_at 
    FROM orders 
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - Payments</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: #f4f6f8;
    }

    .admin-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .main {
        flex: 1;
        padding: 30px;
    }

    h1 {
        margin-bottom: 20px;
        font-size: 28px;
        color: #333;
    }

    .table-box {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
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
        background: #343a40;
        color: #fff;
    }

    tr:hover {
        background: #f1f3f5;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #fff;
        font-weight: bold;
    }

    .paid {
        background: #6c757d;
    }

    .cod {
        background: #6c757d; /* grey for COD */
    }

    .pending {
        background: #e9ecef;
        color: #495057;
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

    <?php include '../includes/sidebar.php'; ?>

    <div class="main">
        <h1>Payments</h1>

        <div class="table-box">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>

                <?php if (mysqli_num_rows($res) > 0): ?>
                    <?php while ($p = mysqli_fetch_assoc($res)): ?>

                        <?php
                        // Map payment status
                        if ($p['payment_status'] === 'O') {
                            $status_text = 'Cash on Delivery';
                            $status_class = 'cod';
                        } elseif (strtolower($p['payment_status']) === 'paid') {
                            $status_text = 'PAID';
                            $status_class = 'paid';
                        } else {
                            $status_text = strtoupper($p['payment_status']);
                            $status_class = 'pending';
                        }
                        ?>

                        <tr>
                            <td>#<?= htmlspecialchars($p['id']) ?></td>
                            <td><?= htmlspecialchars($p['user_id']) ?></td>
                            <td>₹<?= number_format($p['total'], 2) ?></td>
                            <td>
                                <span class="badge <?= $status_class ?>">
                                    <?= $status_text ?>
                                </span>
                            </td>
                            <td><?= date('d M Y, h:i A', strtotime($p['created_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-data">No payments found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

</body>
</html>
