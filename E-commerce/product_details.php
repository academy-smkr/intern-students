<?php
session_start();
include 'config/db.php';

// Check if ID is provided in URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<p style='text-align:center; margin-top:50px;'>No product selected. <a href='product.php'>Go back to products</a></p>";
    exit();
}

// Fetch product from database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

if (!$p) {
    echo "<p style='text-align:center; margin-top:50px;'>Product not found! <a href='product.php'>Go back to products</a></p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['name'] ?? 'Product') ?> - MyShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f8; margin:0; padding:0; }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:#007bff; color:white; padding:15px 30px; }
        .navbar a { color:white; margin-left:15px; text-decoration:none; font-weight:bold; }
        .product-container { display:flex; flex-wrap:wrap; max-width:900px; margin:40px auto; background:white; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1); padding:30px; }
        .product-image { flex:1; padding-right:30px; }
        .product-image img { width:100%; border-radius:10px; }
        .product-details { flex:1; min-width:250px; }
        .product-details h2 { margin-top:0; color:#333; }
        .product-details p { font-size:16px; line-height:1.6; color:#555; }
        .price { font-size:22px; font-weight:bold; margin:20px 0; color:#007bff; }
        .btn { display:inline-block; padding:10px 20px; margin-right:10px; margin-top:10px; background:#007bff; color:white; text-decoration:none; border-radius:5px; font-weight:bold; }
        .btn:hover { background:#0056b3; }
        .description { margin-top:20px; font-size:15px; color:#666; line-height:1.8; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>MyShop</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">All Products</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">Cart</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== PRODUCT DETAILS ===== -->
<div class="product-container">
    <div class="product-image">
        <img src="assets/images/<?= htmlspecialchars($p['image'] ?? 'default.png') ?>" 
             alt="<?= htmlspecialchars($p['name'] ?? 'Product') ?>">
    </div>
    <div class="product-details">
        <h2><?= htmlspecialchars($p['name'] ?? 'Product') ?></h2>
        <div class="price">₹<?= number_format($p['price'] ?? 0, 2) ?></div>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $p['id'] ?>" class="btn">Add to Cart</a>
            <a href="cart/wishlist.php?id=<?= $p['id'] ?>" class="btn">Wishlist</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Buy</a>
        <?php endif; ?>

        <div class="description">
            <?= nl2br(htmlspecialchars($p['description'] ?? 'No description available.')) ?>

            <p><strong>Product Features:</strong></p>
            <ul>
                <li>High quality and durable material.</li>
                <li>Available in multiple colors and sizes.</li>
                <li>Easy to use and maintain.</li>
                <li>1-year manufacturer warranty included.</li>
                <li>Free shipping for orders above ₹1000.</li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
