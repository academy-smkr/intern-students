<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$lost = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='lost'")
)['total'];

$found = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) as total FROM items WHERE status='found'")
)['total'];

$claimed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM claims WHERE status='approved' OR status='pending' ")
)['total'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="page-wrapper">
<!-- HEADER -->
<div class="header">
    <div style="display:flex;align-items:center;gap:15px;">
        <div class="logo">
        <img src="../assets/images/college-logo.png">
        </div>
        <h1>CampusFind</h1>
    </div>
    <div>
        <span style="margin-right:15px;">Hi, <?php echo $_SESSION['user_name']; ?></span>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<!-- DASHBOARD HERO -->
<section class="dash-hero">
    <h1>Welcome back 👋</h1>
    <p>Manage your lost & found items in one place</p>
</section>

<div class="container">

    <!-- STATS -->
    <div class="dash-stats">
        <div class="stat-card red">
            <h2><?php echo $lost; ?></h2>
            <p>Lost Items</p>
        </div>
        <div class="stat-card green">
            <h2><?php echo $found; ?></h2>
            <p>Found Items</p>
        </div>
        <div class="stat-card gray">
            <h2><?php echo $claimed; ?></h2>
            <p>Claims Made</p>
        </div>
    </div>

    <!-- ACTIONS -->
    <div class="dash-actions">
        <a href="add-item.php" class="action-card">
            <h3>➕ Add Item</h3>
            <p>Report a lost or found item</p>
        </a>

        <a href="lost-items.php" class="action-card">
            <h3>🔍 Lost Items</h3>
            <p>View and claim lost items</p>
        </a>

        <a href="found-items.php" class="action-card">
            <h3>📦 Found Items</h3>
            <p>Browse items found on campus</p>
        </a>

        <a href="my-items.php" class="action-card">
            <h3>📋 My Items</h3>
            <p>View items you have posted</p>
        </a>
    </div>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind | By Kaushiki ;)
</div>
</div>
</body>
</html>
