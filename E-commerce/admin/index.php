<?php
session_start();
include '../config/db.php';
include 'includes/header.php';

$p = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM products"))[0];
$u = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users"))[0];
$o = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM orders"))[0];
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main">
        <h1>Dashboard</h1>

        <div class="cards">
            <div class="card">
                <h3>Products</h3>
                <h1><?= $p ?></h1>
            </div>
            <div class="card">
                <h3>Users</h3>
                <h1><?= $u ?></h1>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <h1><?= $o ?></h1>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
