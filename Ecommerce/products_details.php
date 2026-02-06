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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($p['name'] ?? 'Product') ?> - MyShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>MyShop</h2>
    <div class="navbar-left">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" id="searchInput" placeholder="Search products...">
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>
    <div class="navbar-right">
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
    <div class="product-slider">
        <img src="assets/images/<?= htmlspecialchars($p['image'] ?? 'default.png') ?>" 
             alt="<?= htmlspecialchars($p['name'] ?? 'Product') ?>">
    </div>
    <div class="product-info">
        <h1><?= htmlspecialchars($p['name'] ?? 'Product') ?></h1>
        <h2>₹<?= number_format($p['price'] ?? 0, 2) ?></h2>

        <p class="description">
            <?= nl2br(htmlspecialchars($p['description'] ?? 'No description available.')) ?>
        </p>

        <div style="margin: 25px 0;">
            <strong>Product Features:</strong>
            <ul style="line-height: 2;">
                <li>High quality and durable material</li>
                <li>Available in multiple colors and sizes</li>
                <li>Easy to use and maintain</li>
                <li>1-year manufacturer warranty included</li>
                <li>Free shipping on orders above ₹1000</li>
            </ul>
        </div>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $p['id'] ?>" class="btn">Add to Cart</a>
            <a href="cart/wishlist.php?id=<?= $p['id'] ?>" class="outline">Add to Wishlist</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Buy</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== SEARCH SCRIPT ===== -->
<script>
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

searchInput.addEventListener('input', function() {
    const query = this.value.trim();
    
    if (query.length < 2) {
        searchResults.classList.remove('active');
        return;
    }
    
    fetch('search.php?q=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            searchResults.innerHTML = data;
            if (data.trim()) {
                searchResults.classList.add('active');
            } else {
                searchResults.classList.remove('active');
            }
        });
});

document.addEventListener('click', function(event) {
    if (!event.target.closest('.search-container')) {
        searchResults.classList.remove('active');
    }
});

document.addEventListener('click', function(event) {
    if (event.target.closest('.search-result-item')) {
        const productId = event.target.closest('.search-result-item').dataset.productId;
        if (productId) {
            window.location.href = 'products_details.php?id=' + productId;
        }
    }
});
</script>

</body>
</html>