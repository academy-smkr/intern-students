<?php
session_start();
include 'config/db.php';

// Check if ID is provided in URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<p style='text-align:center; margin-top:50px;'>No game selected. <a href='games.php'>Go back to games</a></p>";
    exit();
}

// Fetch product from database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

if (!$p) {
    echo "<p style='text-align:center; margin-top:50px;'>Game not found! <a href='games.php'>Go back to games</a></p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['name'] ?? 'Game') ?> - GameCloud</title>
    <link rel="stylesheet" href="assets/css/style.css?v=2.0">
    <style>
        body { font-family: 'Arial', 'Courier New', monospace; background: #0a0e27; margin:0; padding:0; }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:#050810; color:#e0e0e0; padding:15px 30px; border-bottom:3px solid #b300ff; box-shadow:0 0 20px rgba(179, 0, 255, 0.5); }
        .navbar a { color:#00ffff; margin-left:15px; text-decoration:none; font-weight:bold; text-shadow:0 0 10px #00ffff; }
        .navbar a:hover { color:#ff00ff; text-shadow:0 0 15px #ff00ff; }
        .product-container { display:flex; flex-wrap:wrap; max-width:900px; margin:40px auto; background:linear-gradient(135deg, rgba(179, 0, 255, 0.1) 0%, rgba(0, 255, 255, 0.1) 100%); border-radius:10px; box-shadow:0 0 30px rgba(179, 0, 255, 0.3); padding:30px; border:2px solid #b300ff; }
        .product-image { flex:1; padding-right:30px; }
        .product-image img { width:100%; border-radius:10px; border:2px solid #b300ff; }
        .product-details { flex:1; min-width:250px; }
        .product-details h2 { margin-top:0; color:#ff00ff; text-shadow:0 0 10px #b300ff; }
        .product-details p { font-size:16px; line-height:1.6; color:#e0e0e0; }
        .price { font-size:22px; font-weight:bold; margin:20px 0; color:#ff00ff; text-shadow:0 0 10px #b300ff; }
        .btn { display:inline-block; padding:10px 20px; margin-right:10px; margin-top:10px; background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%); color:white; text-decoration:none; border-radius:5px; font-weight:bold; border:1px solid #ff00ff; box-shadow:0 0 15px rgba(179, 0, 255, 0.5); }
        .btn:hover { background:linear-gradient(135deg, #ff006e 0%, #b300ff 100%); box-shadow:0 0 25px rgba(255, 0, 110, 0.7); }
        .description { margin-top:20px; font-size:15px; color:#e0e0e0; line-height:1.8; }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <img src="assets/images/persius%20logo.png" alt="GameCloud Logo" class="logo">
    <div>
        <a href="index.php">Home</a>
        <a href="games.php">All Games</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">My Library</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== GAME DETAILS ===== -->
<div class="product-container">
    <div class="product-image">
        <?php
            $imgFile = $p['image'] ?? '';
            $imgPath = 'assets/images/' . ($imgFile && file_exists('assets/images/'.$imgFile) ? $imgFile : 'default_poster.svg');
        ?>
        <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($p['name'] ?? 'Game') ?>">
    </div>
    <div class="product-details">
        <h2><?= htmlspecialchars($p['name'] ?? 'Game') ?></h2>
        <div class="price">₹<?= number_format($p['price'] ?? 0, 2) ?>/month</div>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $p['id'] ?>" class="btn">Subscribe Now</a>
            <a href="cart/wishlist.php?id=<?= $p['id'] ?>" class="btn">Add to Favorites</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Play</a>
        <?php endif; ?>

        <div class="description">
            <?= nl2br(htmlspecialchars($p['description'] ?? 'No description available.')) ?>

            <p><strong>Game Features:</strong></p>
            <ul>
                <li>4K Ultra HD streaming quality</li>
                <li>Instant play with zero downloads required</li>
                <li>Cross-platform play support</li>
                <li>Cloud save synchronization</li>
                <li>Access to exclusive game titles</li>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
