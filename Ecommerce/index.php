<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyShop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>MyShop</h2>
    <div>
        <?php if(isset($_SESSION['user'])): ?>
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

<!-- ===== PRODUCTS ===== -->
<h2 class="section-title">Our Products</h2>

<div class="products">
<?php
$res = mysqli_query($conn, "SELECT * FROM products");
while($row = mysqli_fetch_assoc($res)):
?>
    <div class="card">
        <img src="assets/images/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>₹<?= number_format($row['price'], 2) ?></p>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/add_to_cart.php?id=<?= $row['id'] ?>" class="btn">Add to Cart</a>
        <?php else: ?>
            <a href="auth/login.php" class="btn">Login to Buy</a>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>

<!-- ===== TESTIMONIALS ===== -->
<h2 class="section-title">What Our Customers Say</h2>

<div class="testimonials">
    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"Amazing quality and fast delivery."</p>
        <strong>- Rahul</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★☆</div>
        <p>"Easy checkout and good support."</p>
        <strong>- Priya</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"Best shopping experience ever."</p>
        <strong>- Aman</strong>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div>
        <h3>MyShop</h3>
        <p>Your trusted online shopping destination.</p>
    </div>

    <div>
        <h3>Quick Links</h3>
        <a href="index.php">Home</a>
        <a href="cart/cart.php">Cart</a>
        <a href="#">Contact</a>
    </div>

    <div>
        <h3>Contact</h3>
        <p>Email: support@myshop.com</p>
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