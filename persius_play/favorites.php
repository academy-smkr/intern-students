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
<title>My Favorites - GameCloud</title>
<link rel="stylesheet" href="assets/css/style.css?v=2.0">
<style>
body { font-family: 'Arial', 'Courier New', monospace; background:#0a0e27; margin:0; padding:0; }
.navbar { display:flex; justify-content:space-between; align-items:center; background:#050810; color:#e0e0e0; padding:15px 30px; border-bottom:3px solid #b300ff; box-shadow:0 0 20px rgba(179, 0, 255, 0.5); }
.navbar h2 { color:#ff00ff; text-shadow:0 0 10px #b300ff; }
.navbar a { color:#00ffff; margin-left:15px; text-decoration:none; font-weight:bold; text-shadow:0 0 10px #00ffff; }
.navbar a:hover { color:#ff00ff; text-shadow:0 0 15px #ff00ff; }
.wishlist-container { max-width:900px; margin:40px auto; background:linear-gradient(135deg, rgba(179, 0, 255, 0.1) 0%, rgba(0, 255, 255, 0.1) 100%); border-radius:10px; padding:20px; box-shadow:0 0 30px rgba(179, 0, 255, 0.3); border:2px solid #b300ff; }
.wishlist-container h2 { color:#ff00ff; text-shadow:0 0 10px #b300ff; text-transform:uppercase; }
.wishlist-item { display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(179, 0, 255, 0.3); padding:15px 0; }
    .wishlist-item img { width:80px; border-radius:0 !important; border:1px solid #b300ff; }
.wishlist-item h3 { margin:0; color:#00ffff; text-shadow:0 0 10px #00ffff; }
.wishlist-item .price { color:#ff00ff; font-weight:bold; text-shadow:0 0 10px #b300ff; }
.btn { padding:6px 12px; background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%); color:white; border-radius:5px; text-decoration:none; border:1px solid #ff00ff; box-shadow:0 0 10px rgba(179, 0, 255, 0.4); }
.btn:hover { background:linear-gradient(135deg, #ff006e 0%, #b300ff 100%); box-shadow:0 0 15px rgba(255, 0, 110, 0.6); }
</style>
</head>
<body>
<div class="navbar">
    <img src="assets/images/persius%20logo.png" alt="GameCloud Logo" class="logo" style="height:50px; width:auto;">
    <div>
        <a href="index.php">Home</a>
        <a href="games.php">Games</a>
        <a href="cart/cart.php">My Library</a>
        <a href="auth/logout.php">Logout</a>
    </div>
</div>

<div class="wishlist-container">
    <h2>Favorite Games</h2>
    <?php if($result->num_rows > 0): ?>
        <?php while($item = $result->fetch_assoc()): ?>
            <div class="wishlist-item" style="background:linear-gradient(135deg, #1a1a40 0%, #00f5ff 100%); border:2px solid #00f5ff; box-shadow:0 0 20px #00f5ff33;">
                <?php
                    $imgFile = $item['image'] ?? '';
                    $imgPath = 'assets/images/' . ($imgFile && file_exists('assets/images/'.$imgFile) ? $imgFile : 'default_poster.svg');
                ?>
                <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="border-radius:0 !important; width:80px; border:1px solid #b300ff;">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <div class="price">₹<?= number_format($item['price'], 2) ?>/month</div>
                <div>
                    <a href="cart/add_to_cart.php?id=<?= $item['id'] ?>" class="btn">Subscribe</a>
                    <a href="cart/wishlist_remove.php?id=<?= $item['id'] ?>" class="btn" style="background:linear-gradient(135deg, #ff006e 0%, #7a00b3 100%);">Remove from Favorites</a> 
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No games in favorites. <a href="games.php">Browse games</a></p>
    <?php endif; ?>
</div>
</body>
</html>
