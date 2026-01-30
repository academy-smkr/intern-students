
<?php
include "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<h2>Welcome, <?php echo $_SESSION['user_name']; ?> </h2>
<p>You are logged in.</p>

<a href="logout.php">Logout</a>
