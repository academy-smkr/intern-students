<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../../config/db.php';
include '../includes/header.php';

// Fetch users from the database
$res = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Users List</title>
    <style>
        .action-btn.edit {
            background: #6c757d;
        }
        .action-btn.delete {
            background: #adb5bd;
            color: #495057;
        }
        .action-btn:hover {
            opacity: 0.85;
        }
    </style>

<body>

<div class="admin-wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Admin Panel</h2>

        <a href="../index.php">Dashboard</a>
        <a href="../games/list.php">Games</a>
        <a href="list.php">Users</a>
        <a href="../subscriptions/list.php">Subscriptions</a>
        <a href="../payments/list.php">Payments</a>
        <a href="../logout.php">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <h1>Users</h1>

        <table class="nice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
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
                                    <span class="actions">
                                        <a href="edit.php?id=<?= $u['id'] ?>">Edit</a>
                                        <a href="delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
