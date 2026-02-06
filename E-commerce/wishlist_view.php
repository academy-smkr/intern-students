<?php
session_start();
include 'config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user'];

// Fetch wishlist items
$stmt = $conn->prepare("
    SELECT p.id, p.name, p.price, p.image
    FROM wishlist w
    JOIN products p ON w.product_id = p.id
    WHERE w.user_id=?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Wishlist - MyShop</title>
<link rel="stylesheet" href="assets/css/style.css">
<style>
body { font-family: Arial; background:#f4f6f8; margin:0; padding:0; }
.navbar { display:flex; justify-content:space-between; align-items:center; background:#007bff; color:white; padding:15px 30px; }
.navbar a { color:white; margin-left:15px; text-decoration:none; font-weight:bold; }
.wishlist-container { max-width:900px; margin:40px auto; background:white; border-radius:10px; padding:20px; box-shadow:0 0 15px rgba(0,0,0,0.1);}
.wishlist-item { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #ddd; padding:15px 0; }
.wishlist-item img { width:80px; border-radius:8px; }
.wishlist-item h3 { margin:0; }
.wishlist-item .price { color:#007bff; font-weight:bold; }
.btn { padding:6px 12px; background:#007bff; color:white; border-radius:5px; text-decoration:none; }
.btn:hover { background:#0056b3; }
</style>
</head>
<body>
<div class="navbar">
    <h2>MyShop</h2>
    <div>
        <a href="index.php">Home</a>
        <a href="product.php">Products</a>
        <a href="cart/cart.php">Cart</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<div class="wishlist-container">
    <h2>Your Wishlist</h2>
    <?php if($result->num_rows > 0): ?>
        <?php while($item = $result->fetch_assoc()): ?>
            <div class="wishlist-item">
                <img src="assets/images/<?= htmlspecialchars($item['image'] ?? 'default.png') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <div class="price">₹<?= number_format($item['price'], 2) ?></div>
                <div>
                    <a href="cart/add_to_cart.php?id=<?= $item['id'] ?>" class="btn">Add to Cart</a>
                    <a href="cart/wishlist_remove.php?id=<?= $item['id'] ?>" class="btn" style="background:#dc3545;">Remove</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products in wishlist. <a href="productS.php">Browse products</a></p>
    <?php endif; ?>
</div>
</body>
</html>
