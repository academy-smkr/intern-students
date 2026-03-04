<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user'];

// Get all purchased games for this user
$games = mysqli_query($conn, "SELECT DISTINCT p.* FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN products p ON oi.product_id = p.id WHERE o.user_id = $user_id ORDER BY o.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Subscribed Games - PersiusPlay</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3.0">
    <style>
        .subs-container { max-width: 1100px; margin: 60px auto; background: linear-gradient(135deg, rgba(179,0,255,0.10) 0%, rgba(0,255,255,0.10) 100%); border-radius: 10px; box-shadow: 0 0 30px #b300ff33; border: 2px solid #b300ff; padding: 32px; }
        .subs-title { color: #ff00ff; text-align: center; margin-bottom: 32px; text-shadow: 0 0 16px #b300ff; font-size: 2em; }
        .subs-list { display: flex; flex-wrap: wrap; gap: 32px; justify-content: center; }
        .subs-card { background: #181c3a; border: 2px solid #b300ff; border-radius: 8px; width: 220px; text-align: center; box-shadow: 0 0 16px #b300ff22; padding: 18px 12px; }
        .subs-card img {
            width: 100%;
            aspect-ratio: 2 / 3;
            height: auto;
            object-fit: cover;
            border-radius: 6px;
            border: 1.5px solid #ff00ff;
            margin-bottom: 12px;
            display: block;
        }
        .subs-card h3 { color: #00ffff; margin: 10px 0 6px 0; font-size: 1.2em; }
        .subs-card p { color: #ff00ff; font-weight: bold; margin-bottom: 0; }
        .subs-play-btn {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #00f5ff 0%, #b300ff 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            font-size: 1em;
            box-shadow: 0 0 10px #b300ff55;
        }
        .subs-home-btn {
            display: inline-block;
            margin-bottom: 24px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #b300ff 0%, #00f5ff 100%);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            text-decoration: none;
            font-size: 1em;
            box-shadow: 0 0 10px #b300ff55;
            transition: 0.2s;
        }
        .subs-home-btn:hover {
            background: linear-gradient(135deg, #00f5ff 0%, #b300ff 100%);
            color: #fff;
            box-shadow: 0 0 20px #00f5ff99;
            transform: scale(1.05);
            transition: 0.2s;
        }
        .subs-play-btn:hover {
            background: linear-gradient(135deg, #b300ff 0%, #00f5ff 100%);
            color: #fff;
            box-shadow: 0 0 20px #00f5ff99;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
<div class="subs-container">
    <a href="index.php" class="subs-home-btn">&larr; Back to Home</a>
    <div class="subs-title">My Subscribed Games</div>
    <div class="subs-list">
        <?php if ($games && mysqli_num_rows($games) > 0): ?>
            <?php while($g = mysqli_fetch_assoc($games)): ?>
                <div class="subs-card">
                    <?php
                        $img = 'assets/images/' . ($g['image'] && file_exists('assets/images/'.$g['image']) ? $g['image'] : 'default_poster.svg');
                    ?>
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($g['name']) ?>">
                    <h3><?= htmlspecialchars($g['name']) ?></h3>
                    <p>₹<?= number_format($g['price'], 2) ?>/month</p>
                    <a href="#" class="subs-play-btn">Play</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="width:100%;text-align:center;">You have not subscribed to any games yet.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
