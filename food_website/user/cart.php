<?php include "../db.php"; include "../header.php"; ?>
<?php

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

if(isset($_POST['add'])){
    mysqli_query($conn,
    "INSERT INTO cart(user_id,food_id,quantity)
     VALUES('$_SESSION[user_id]','$_POST[food_id]','$_POST[qty]')");
}
?>

<h2>Cart</h2>

<form method="post">
Payment:
<select name="payment">
<option>COD</option>
<option>UPI</option>
<option>Card</option>
</select>
<button name="order">Place Order</button>
</form>

<?php
if(isset($_POST['order'])){
    $total=0;
    $q=mysqli_query($conn,
    "SELECT food_items.price,cart.quantity
     FROM cart
     JOIN food_items ON cart.food_id=food_items.id
     WHERE cart.user_id='$_SESSION[user_id]'");

    while($c=mysqli_fetch_assoc($q)){
        $total += $c['price']*$c['quantity'];
    }

    mysqli_query($conn,
    "INSERT INTO orders(user_id,total_price,payment_method)
     VALUES('$_SESSION[user_id]','$total','$_POST[payment]')");

    mysqli_query($conn,"DELETE FROM cart WHERE user_id='$_SESSION[user_id]'");
    echo "Order placed";
}
?>