<?php
session_start();
include "../config/db.php";

/* ================= AUTH CHECK ================= */
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

/* ================= ADMIN INFO ================= */
$admin_id   = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

/* ================= DASHBOARD COUNTS ================= */

// Total items
$totalItems = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM items")
)['total'];

// Lost items
$lostItems = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM items WHERE status='lost'")
)['total'];

// Found items
$foundItems = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM items WHERE status='found'")
)['total'];

// Pending claims ONLY
$pendingClaims = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM claims WHERE status='pending'")
)['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">

<!-- HEADER -->
<div class="header">
    <h1>CampusFind – Admin Panel</h1>
    <a href="logout.php" class="btn">Logout</a>
</div>

<!-- HERO -->
<section class="dash-hero">
    <h1>Welcome, <?php echo htmlspecialchars($admin_name); ?> 👋</h1>
    <p>Manage campus lost & found items</p>
</section>

<div class="container">

<!-- STATS -->
<div class="dash-stats">

    <div class="stat-card blue">
        <h2><?php echo $totalItems; ?></h2>
        <p>Total Items</p>
    </div>

    <div class="stat-card red">
        <h2><?php echo $lostItems; ?></h2>
        <p>Lost Items</p>
    </div>

    <div class="stat-card green">
        <h2><?php echo $foundItems; ?></h2>
        <p>Found Items</p>
    </div>

    <div class="stat-card gray">
        <h2><?php echo $pendingClaims; ?></h2>
        <p>Pending Claims</p>
    </div>

</div>

<!-- ACTIONS -->
<div class="dash-actions">

    <a href="items.php" class="action-card">
        <h3>📦 All Items</h3>
        <p>View every lost & found item</p>
    </a>

    <a href="lost-items.php" class="action-card">
        <h3>❌ Lost Items</h3>
        <p>Items reported as lost</p>
    </a>

    <a href="found-items.php" class="action-card">
        <h3>✅ Found Items</h3>
        <p>Items reported as found</p>
    </a>

    <a href="claims.php" class="action-card">
        <h3>📝 Claims</h3>
        <p>Approve or reject claims</p>
    </a>

    <a href="users.php" class="action-card">
        <h3>👥 Users</h3>
        <p>View / manage users</p>
    </a>

</div>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind | Admin Panel
</div>

</div>
</body>
</html>
