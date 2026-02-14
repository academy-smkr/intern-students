<?php
session_start();

/* -------------------------------
   Admin login check
-------------------------------- */
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}

/* -------------------------------
   Database connection
-------------------------------- */
include '../../config/db.php';

/* -------------------------------
   Fetch users
-------------------------------- */
$res = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pet Parents List</title>

    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background: #f8f6f2;
            margin: 0;
            color: #203036;
        }

        /* Layout */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
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
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background: #444;
        }

        /* Main content */
        .main {
            flex: 1;
            padding: 20px;
        }

        /* Table */
        .nice-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-top: 20px;
        }

        .nice-table th,
        .nice-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        .nice-table th {
            background: #007bff;
            color: #fff;
        }

        /* Badges */
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            color: #fff;
            font-size: 12px;
        }

        .badge.active {
            background: #28a745;
        }

        .badge.inactive {
            background: #dc3545;
        }

        /* Action buttons */
        .action-btn {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: #fff;
            margin: 0 3px;
            font-size: 13px;
        }

        .action-btn.edit {
            background: #17a2b8;
        }

        .action-btn.delete {
            background: #dc3545;
        }

        .action-btn:hover {
            opacity: 0.85;
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
        <a href="list.php">Pet Parents</a>
        <a href="../orders/list.php">Pet Orders</a>
        <a href="../payments/list.php">Pet Payments</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h1>Pet Parents</h1>

        <table class="nice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (mysqli_num_rows($res) > 0): ?>
                <?php $i = 1; while ($u = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td><?= $i++ ?></td>

                        <td><?= htmlspecialchars($u['name']) ?></td>

                        <td><?= htmlspecialchars($u['email']) ?></td>

                        <td>
                            <?php
                                $status = $u['status'] ?? 'Active';
                                $badgeClass = ($status === 'Active') ? 'active' : 'inactive';
                            ?>
                            <span class="badge <?= $badgeClass ?>">
                                <?= $status ?>
                            </span>
                        </td>

                        <td>
                            <a href="edit.php?id=<?= $u['id'] ?>" class="action-btn edit">
                                Edit
                            </a>

                            <a href="delete.php?id=<?= $u['id'] ?>"
                               class="action-btn delete"
                               onclick="return confirm('Are you sure you want to delete this pet parent?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No pet parents found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
