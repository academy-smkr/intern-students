<?php
session_start();
include 'config/db.php';

// Check if ID is provided in URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<p style='text-align:center; margin-top:50px;'>No pet item selected. <a href='products.php'>Go back to pet supplies</a></p>";
    exit();
}

// Fetch product from database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

if (!$p) {
    echo "<p style='text-align:center; margin-top:50px;'>Pet item not found! <a href='products.php'>Go back to pet supplies</a></p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['name'] ?? 'Pet Item') ?> - PawMart Pet Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
        body { font-family: 'Nunito', Arial, sans-serif; background: var(--bg); margin:0; padding:0; color:var(--ink); }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:linear-gradient(120deg, var(--brand), var(--brand-dark)); color:white; padding:15px 30px; }
        .navbar a { color:white; margin-left:15px; text-decoration:none; font-weight:bold; }
        .product-container { display:flex; flex-wrap:wrap; max-width:900px; margin:40px auto; background:white; border-radius:10px; box-shadow:0 10px 22px rgba(0,0,0,0.08); padding:30px; }
        .product-image { flex:1; padding-right:30px; }
        .product-image img { width:100%; border-radius:10px; }
        .product-details { flex:1; min-width:250px; }
        .product-details h2 { margin-top:0; color:var(--ink); }
        .product-details p { font-size:16px; line-height:1.6; color:#47545a; }
        .price { font-size:22px; font-weight:bold; margin:20px 0; color:var(--brand); }
        .btn { display:inline-block; padding:10px 20px; margin-right:10px; margin-top:10px; background:var(--accent); color:white; text-decoration:none; border-radius:5px; font-weight:bold; }
        .btn:hover { background:var(--accent-dark); }
        .description { margin-top:20px; font-size:15px; color:#5b6a70; line-height:1.8; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>PawMart</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="products.php">Pet Supplies</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">Pet Cart</a>
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
        <img src="assets/images/<?= htmlspecialchars($p['image'] ?? 'pet-placeholder.svg') ?>" 
             alt="<?= htmlspecialchars($p['name'] ?? 'Pet Item') ?>">
    </div>
    <div class="product-details">
        <h2><?= htmlspecialchars($p['name'] ?? 'Pet Item') ?></h2>
        <div class="price">₹<?= number_format($p['price'] ?? 0, 2) ?></div>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $p['id'] ?>" class="btn">Add to Cart</a>
            <a href="cart/wishlist.php?id=<?= $p['id'] ?>" class="btn">Add to Wishlist</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Shop</a>
        <?php endif; ?>

        <div class="description">
            <?= nl2br(htmlspecialchars($p['description'] ?? 'No description available.')) ?>

            <p><strong>Pet-Friendly Features:</strong></p>
            <ul>
                <li>Safe, durable materials for everyday use.</li>
                <li>Comfortable fit for cats and dogs.</li>
                <li>Easy to clean and maintain.</li>
                <li>Designed for active pets and calm companions.</li>
                <li>Free delivery for orders above ₹1000.</li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
