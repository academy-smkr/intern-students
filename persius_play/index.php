<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PersiusPlay - Cloud Gaming Platform</title>
    <link rel="stylesheet" href="assets/css/style.css?v=3.0">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <img src="assets/images/persius_logo.png" alt="PersiusPlay Logo" class="logo">
    <div>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="my_subscriptions.php">My Library</a>
            <a href="cart/cart.php">Cart</a>
            <a href="auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<!-- ===== CAROUSEL ===== -->
<div class="carousel">
    <div class="slides">
        <img src="assets/images/banner1.jpg" alt="Banner 1">
    </div>
    <div class="slides">
        <img src="assets/images/banner2.jpg" alt="Banner 2">
    </div>
    <div class="slides">
        <img src="assets/images/banner3.jpg" alt="Banner 3">
    </div>
</div>

<!-- ===== GAMES ===== -->
<h2 class="section-title">Featured Games</h2>

<div class="products">
<?php
$res = mysqli_query($conn, "SELECT * FROM products GROUP BY name");
while($row = mysqli_fetch_assoc($res)):
?>
    <div class="card">
        <?php
            $imgFile = $row['image'] ?? '';
            $imgPath = 'assets/images/' . ($imgFile && file_exists('assets/images/'.$imgFile) ? $imgFile : 'default_poster.svg');
        ?>
        <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="width:100%;aspect-ratio:2/3;height:auto;object-fit:cover;display:block;">
        <div class="card-title-wrap">
            <h3><?= htmlspecialchars($row['name']) ?></h3>
        </div>
        <div class="card-price-wrap">
            <p>₹<?= number_format($row['price'], 2) ?>/month</p>
        </div>

        <div class="card-btn-wrap">
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $row['id'] ?>" class="btn">Subscribe</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Play</a>
        <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
</div>

<!-- ===== REVIEWS ===== -->
<h2 class="section-title">Player Reviews</h2>

<div class="testimonials">
    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"Incredible game library with zero latency. Best cloud gaming service!"</p>
        <strong>- Rahul</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★☆</div>
        <p>"Smooth streaming and instant play without downloads. Highly recommend!"</p>
        <strong>- Priya</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"The best cloud gaming platform I've ever used. Amazing performance!"</p>
        <strong>- Aman</strong>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div>
        <h3>PersiusPlay</h3>
        <p>Premium cloud gaming platform for ultimate entertainment.</p>
    </div>

    <div>
        <h3>Quick Links</h3>
        <a href="index.php">Home</a>
        <a href="cart/cart.php">My Library</a>
        <a href="#">Contact</a>
    </div>

    <div>
        <h3>Contact</h3>
        <p>Email: support@persiusplay.com</p>
        <p>Phone: +91 98765 43210</p>
    </div>
</footer>

<!-- ===== CAROUSEL SCRIPT ===== -->
<script>
let slideIndex = 0;
showSlides();

function showSlides(){
    let slides = document.getElementsByClassName("slides");
    for(let i = 0; i < slides.length; i++){
        slides[i].style.display = "none";
    }
    slideIndex++;
    if(slideIndex > slides.length){ slideIndex = 1; }
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3000);
}
</script>

</body>
</html>
