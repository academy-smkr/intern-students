<?php include "../db.php"; include "../header.php"; ?>
<?php

if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
}
?>

<h2>Admin Dashboard</h2>
<a href="../logout.php">Logout</a>

<hr>

<h3>Add Food</h3>
<form method="post">
Food Name:<br>
<input type="text" name="food"><br><br>
Price:<br>
<input type="number" name="price"><br><br>
<button name="add">Add</button>
</form>

<?php
if(isset($_POST['add'])){
    mysqli_query($conn,
    "INSERT INTO food_items(food_name,price)
     VALUES('$_POST[food]','$_POST[price]')");
    echo "Food added";
}
?>

<hr>

<h3>All Users</h3>
<?php
$r=mysqli_query($conn,"SELECT * FROM users WHERE role='user'");
while($u=mysqli_fetch_assoc($r)){
    echo $u['name']." - ".$u['email']."<br>";
}
?>

<hr>
<a href="orders.php">View Orders</a>