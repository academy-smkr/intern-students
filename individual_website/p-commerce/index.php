<?php
session_start();
include 'config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PawMart Pet Shop</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- ===== NAVBAR ===== -->
<div class="navbar">
    <h2>PawMart</h2>
    <div>
        <?php if(isset($_SESSION['user'])): ?>
            <a href="cart/cart.php">Pet Cart</a>
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
        <img src="assets/images/pixabay/paw-banner-dog-food.jpg" alt="Dog food and bowls">
    </div>
    <div class="slides">
        <img src="assets/images/pixabay/paw-banner-dog-bed.jpg" alt="Cozy dog bed">
    </div>
    <div class="slides">
        <img src="assets/images/pixabay/paw-banner-grooming.jpg" alt="Pet grooming essentials">
    </div>
</div>

<!-- ===== PRODUCTS ===== -->
<h2 class="section-title">Pet Essentials</h2>

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
            <a href="auth/login.php" class="btn">Login to Shop</a>
        <?php endif; ?>
    </div>
<?php endwhile; ?>
</div>

<!-- ===== TESTIMONIALS ===== -->
<h2 class="section-title">What Pet Parents Say</h2>

<div class="testimonials">
    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"Great quality treats and fast delivery."</p>
        <strong>- Rahul & Bruno</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★☆</div>
        <p>"Easy checkout and helpful support."</p>
        <strong>- Priya & Momo</strong>
    </div>

    <div class="test-card">
        <div class="stars">★★★★★</div>
        <p>"Best pet shopping experience ever."</p>
        <strong>- Aman & Coco</strong>
    </div>
</div>

<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div>
        <h3>PawMart</h3>
        <p>Your trusted pet supplies destination.</p>
    </div>

    <div>
        <h3>Quick Links</h3>
        <a href="index.php">Home</a>
        <a href="cart/cart.php">Pet Cart</a>
        <a href="#">Contact</a>
    </div>

    <div>
        <h3>Contact</h3>
        <p>Email: support@pawmart.com</p>
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
