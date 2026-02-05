<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products - MyShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: Arial; background: #f4f6f8; margin:0; padding:0; }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:#007bff; color:white; padding:15px 30px; }
        .navbar a { color:white; margin-left:15px; text-decoration:none; font-weight:bold; }
        .section-title { text-align:center; margin:40px 0 20px; color:#333; }
        .products { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; max-width:1200px; margin:auto; padding:0 20px; }
        .card { background:white; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); width:250px; text-align:center; padding:15px; transition: transform 0.2s; }
        .card:hover { transform: translateY(-5px); }
        .card img { width:100%; border-radius:10px; cursor:pointer; }
        .card h3 { margin:10px 0; color:#333; cursor:pointer; }
        .card p { font-size:16px; color:#007bff; font-weight:bold; }
        .btn { display:inline-block; padding:10px 20px; margin-top:10px; background:#007bff; color:white; text-decoration:none; border-radius:5px; font-weight:bold; }
        .btn:hover { background:#0056b3; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>MyShop</h2>
    <div>
        <a href="index.php">Home</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">Cart</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ALL PRODUCTS ===== -->
<h2 class="section-title">All Products</h2>

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
            <a href="auth/login.php" class="btn">Login to Buy</a>
        <?php endif; ?>
    </div>
<?php
    endwhile;
else:
    echo "<p style='text-align:center; width:100%;'>No products found.</p>";
endif;
?>
</div>

</body>
</html>