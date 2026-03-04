
<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Games - GameCloud</title>
    <link rel="stylesheet" href="assets/css/style.css?v=2.0">
    <style>
        body { font-family: 'Arial', 'Courier New', monospace; background: #0a0e27; margin:0; padding:0; }
        .navbar { display:flex; justify-content:space-between; align-items:center; background:#050810; color:#e0e0e0; padding:15px 30px; border-bottom:3px solid #b300ff; box-shadow:0 0 20px rgba(179, 0, 255, 0.5); }
        .navbar h2 { color:#ff00ff; text-shadow:0 0 10px #b300ff; font-size:24px; letter-spacing:2px; }
        .navbar a { color:#00ffff; margin-left:15px; text-decoration:none; font-weight:bold; text-shadow:0 0 10px #00ffff; }
        .navbar a:hover { color:#ff00ff; text-shadow:0 0 15px #ff00ff; }
        .section-title { text-align:center; margin:40px 0 20px; color:#ff00ff; text-shadow:0 0 20px #b300ff; letter-spacing:2px; text-transform:uppercase; }
        .products { display:flex; flex-wrap:wrap; justify-content:center; gap:20px; max-width:1200px; margin:auto; padding:0 20px; }
        .card { background:linear-gradient(135deg, rgba(179, 0, 255, 0.1) 0%, rgba(0, 255, 255, 0.1) 100%); border-radius:0 !important; box-shadow:0 0 20px rgba(179, 0, 255, 0.4); width:250px; text-align:center; padding:15px; transition: transform 0.2s; border:2px solid #b300ff; }
        .card:hover { transform: translateY(-5px); border-color:#ff006e; box-shadow:0 0 30px rgba(255, 0, 110, 0.6); }
        .card img {
            width: 100%;
            aspect-ratio: 2 / 3;
            height: auto;
            border-radius: 0 !important;
            cursor: pointer;
            border: 1px solid #b300ff;
            object-fit: cover;
            display: block;
        }
        .card h3 { margin:10px 0; color:#00ffff; cursor:pointer; text-shadow:0 0 10px #00ffff; }
        .card p { font-size:16px; color:#ff00ff; font-weight:bold; text-shadow:0 0 10px #b300ff; }
        .btn { display:inline-block; padding:10px 20px; margin-top:10px; background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%); color:white; text-decoration:none; border-radius:5px; font-weight:bold; border:1px solid #ff00ff; box-shadow:0 0 15px rgba(179, 0, 255, 0.5); }
        .btn:hover { background:linear-gradient(135deg, #ff006e 0%, #b300ff 100%); box-shadow:0 0 25px rgba(255, 0, 110, 0.7); }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <img src="assets/images/persius%20logo.png" alt="GameCloud Logo" class="logo">
    <div>
        <a href="index.php">Home</a>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">My Library</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== ALL GAMES ===== -->
<h2 class="section-title">All Games</h2>

<div class="products">
<?php
$res = mysqli_query($conn, "SELECT * FROM products");
if(mysqli_num_rows($res) > 0):
    while($row = mysqli_fetch_assoc($res)):
?>
    <div class="card">
        <a href="game_details.php?id=<?= $row['id'] ?>">
            <?php
                $imgFile = $row['image'] ?? '';
                $imgPath = 'assets/images/' . ($imgFile && file_exists('assets/images/'.$imgFile) ? $imgFile : 'default_poster.svg');
            ?>
            <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($row['name']) ?>">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
        </a>
        <p>₹<?= number_format($row['price'], 2) ?>/month</p>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $row['id'] ?>" class="btn">Subscribe</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Play</a>
        <?php endif; ?>
    </div>
<?php
    endwhile;
else:
    echo "<p style='text-align:center; width:100%;'>No games found.</p>";
endif;
?>
</div>

</body>
</html>
