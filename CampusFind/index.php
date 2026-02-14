<!DOCTYPE html>
<html>
<head>
    <title>CampusFind | Lost & Found Portal</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="page-wrapper">

<!-- HEADER -->
<div class="header">
    <div style="display:flex;align-items:center;gap:15px;">
        <div class="logo">
            <img src="assets/images/college-logo.png">
        </div>
        <h1>CampusFind</h1>
    </div>
    <div>
        <a href="user/login.php" class="btn">User Login</a>
        <a href="user/register.php" class="btn">User Register</a>
    </div>
</div>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Lost Something on Campus?</h1>
        <p>
            CampusFind helps students and staff report, track,  
            and recover lost & found items inside the college.
        </p>
        <div class="hero-buttons">
            <a href="user/register.php" class="btn big">Get Started</a>
            <a href="user/login.php" class="btn outline">Report Item</a>
        </div>
    </div>
</section>

<!-- FEATURES -->
<div class="container">
    <div class="features">
        <div class="feature-card">
            <h3>🔍 Report Lost Items</h3>
            <p>Easily report items you’ve lost with full details and images.</p>
        </div>

        <div class="feature-card">
            <h3>📦 Post Found Items</h3>
            <p>Found something? Post it so the rightful owner can find it.</p>
        </div>

        <div class="feature-card">
            <h3>🛡️ Admin Verification</h3>
            <p>All claims are verified by admin to avoid false ownership.</p>
        </div>
    </div>
</div>

<!-- STATS -->
<section class="stats">
    <div class="stat">
        <h2>10+</h2>
        <p>Items Recovered</p>
    </div>
    <div class="stat">
        <h2>10+</h2>
        <p>Students Helped</p>
    </div>
    <div class="stat">
        <h2>24/7</h2>
        <p>Campus Access</p>
    </div>
</section>

<!-- FOOTER -->
<div class="footer">
    © <?php echo date("Y"); ?> CampusFind | College Lost & Found System
</div>

</div>
</body>
</html>
