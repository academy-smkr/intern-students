<?php include "../db.php"; include "../header.php"; ?>
<?php

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
?>

<h2>Food Menu</h2>
<a href="cart.php">Cart</a> | <a href="orders.php">My Orders</a>

<hr>

<?php
$r=mysqli_query($conn,"SELECT * FROM food_items");
while($f=mysqli_fetch_assoc($r)){
?>
<form method="post" action="cart.php">
<?php echo $f['food_name']." - ".$f['price']; ?>
<input type="hidden" name="food_id" value="<?php echo $f['id']; ?>">
<input type="number" name="qty" value="1">
<button name="add">Add</button>
</form>
<?php } ?>