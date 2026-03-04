
<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';

$p = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM products WHERE 1"))[0];
$u = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM users"))[0];
$o = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM orders"))[0];
$revenue = mysqli_fetch_row(mysqli_query($conn,"SELECT IFNULL(SUM(total),0) FROM orders WHERE payment_status='Card Payment Confirmed'"))[0];
$games_sold = mysqli_fetch_row(mysqli_query($conn,"SELECT IFNULL(SUM(oi.qty),0) FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.payment_status='Card Payment Confirmed'"))[0];
?>

<div class="admin-wrapper">
    <?php include 'includes/sidebar.php'; ?>

    <div class="main">
        <h1>Dashboard</h1>

        <div class="cards">
            <div class="card">
                <h3>Games</h3>
                <h1><?= $p ?></h1>
            </div>
            <div class="card">
                <h3>Players</h3>
                <h1><?= $u ?></h1>
            </div>
            <div class="card">
                 <h3>Orders</h3>
                <h1><?= $o ?></h1>
            </div>
            <div class="card">
                <h3>Total Revenue</h3>
                <h1>₹<?= number_format($revenue,2) ?></h1>
            </div>
            <div class="card">
                <h3>Games Sold</h3>
                <h1><?= $games_sold ?></h1>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
