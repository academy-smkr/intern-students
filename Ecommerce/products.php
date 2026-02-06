<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products - MyShop</title>
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
        <a href="products_details.php?id=<?= $row['id'] ?>">
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
    echo "<p style='text-align:center; width:100%; padding: 40px;'>No products found.</p>";
endif;
?>
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