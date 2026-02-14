<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Pet Supplies - PawMart</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
        body { font-family: 'Nunito', Arial, sans-serif; background: var(--bg); margin:0; padding:0; color:var(--ink); }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:linear-gradient(120deg, var(--brand), var(--brand-dark)); color:white; padding:15px 30px; }
        .navbar a { color:white; margin-left:15px; text-decoration:none; font-weight:bold; }
        .section-title { text-align:center; margin:40px 0 20px; color:var(--ink); }
        .products { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; max-width:1200px; margin:auto; padding:0 20px; }
        .card { background:white; border-radius:10px; box-shadow:0 10px 20px rgba(0,0,0,0.08); width:250px; text-align:center; padding:15px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .card img { width:100%; border-radius:10px; cursor:pointer; }
        .card h3 { margin:10px 0; color:var(--ink); cursor:pointer; }
        .card p { font-size:16px; color:var(--brand); font-weight:bold; }
        .btn { display:inline-block; padding:10px 20px; margin-top:10px; background:var(--accent); color:white; text-decoration:none; border-radius:5px; font-weight:bold; }
        .btn:hover { background:var(--accent-dark); }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>PawMart</h2>
    <div>
        <a href="index.php">Home</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">Pet Cart</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ALL PRODUCTS ===== -->
<h2 class="section-title">All Pet Supplies</h2>

<div class="products">
<?php
$res = mysqli_query($conn, "SELECT * FROM products");
if(mysqli_num_rows($res) > 0):
    while($row = mysqli_fetch_assoc($res)):
?>
    <div class="card">
        <a href="product_details.php?id=<?= $row['id'] ?>">
            <img src="assets/images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
        </a>
        <p>₹<?= number_format($row['price'], 2) ?></p>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $row['id'] ?>" class="btn">Add to Cart</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Shop</a>
        <?php endif; ?>
    </div>
<?php
    endwhile;
else:
    echo "<p style='text-align:center; width:100%;'>No pet supplies found.</p>";
endif;
?>
</div>

</body>
</html>
