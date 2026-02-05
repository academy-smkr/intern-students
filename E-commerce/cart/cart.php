<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$uid = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>
<style>
body{
    font-family: Arial;
    background:#f4f6f8;
    margin:0;
}

/* HEADER */
.header{
    background:#fff;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}
.header a{
    margin-left:15px;
    text-decoration:none;
    color:#007bff;
    font-weight:bold;
}

/* CART */
.cart-container{
    max-width:900px;
    margin:50px auto;
    background:#fff;
    padding:25px;
    border-radius:10px;
}

table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:12px;
    text-align:center;
}
th{
    background:#007bff;
    color:#fff;
}

.product-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:6px;
}

.qty-box{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
}
.qty-box a{
    padding:5px 12px;
    background:#007bff;
    color:#fff;
    text-decoration:none;
    border-radius:4px;
    font-size:18px;
}

.total{
    text-align:right;
    font-size:20px;
    margin-top:20px;
}

.checkout-btn{
    display:block;
    width:220px;
    margin:30px auto 0;
    text-align:center;
    padding:12px;
    background:#28a745;
    color:#fff;
    text-decoration:none;
    border-radius:5px;
}

/* EMPTY CART */
.empty-cart{
    text-align:center;
    padding:50px 20px;
}
.empty-cart .icon{
    font-size:60px;
    margin-bottom:15px;
}
.empty-cart p{
    color:#666;
}
.empty-cart a{
    display:inline-block;
    margin-top:15px;
    padding:12px 25px;
    background:#007bff;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h3>E-Commerce</h3>
    <div>
        <a href="../index.php">Home</a>
        <a href="../products.php">Products</a>
        <a href="cart.php">Cart</a>
    </div>
</div>

<div class="cart-container">
<h2>Your Cart</h2>

<?php
$sql = "
    SELECT 
        c.id AS cart_id,
        p.name,
        p.price,
        p.image,
        c.qty
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $total = 0;
    $defaultImg = "../assets/images/no-image.png";

    echo "<table>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {

        $sub = $row['price'] * $row['qty'];
        $total += $sub;

        if (!empty($row['image'])) {
            $img = "../assets/images/" . $row['image'];
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . $img)) {
                $img = $defaultImg;
            }
        } else {
            $img = $defaultImg;
        }

        echo "<tr>
            <td><img src='$img' class='product-img'></td>
            <td>{$row['name']}</td>
            <td>₹{$row['price']}</td>
            <td>
                <div class='qty-box'>
                    <a href='update.php?id={$row['cart_id']}&type=dec'>−</a>
                    <span>{$row['qty']}</span>
                    <a href='update.php?id={$row['cart_id']}&type=inc'>+</a>
                </div>
            </td>
            <td>₹$sub</td>
        </tr>";
    }

    echo "</table>";
    echo "<div class='total'><b>Total: ₹ $total</b></div>";
    ?>
    <form action="../payment/checkout.php" method="POST" style="text-align:center; margin-top:30px;">

    <h3>Select Payment Method</h3>

    <label>
        <input type="radio" name="method" value="COD" required>
        Cash on Delivery
    </label>
    <br><br>

    <label>
        <input type="radio" name="method" value="ONLINE">
        Online Payment
    </label>
    <br><br>

    <button type="submit" class="checkout-btn">
        Place Order
    </button>

</form>
<?php

} else {

    // EMPTY CART UI
    echo "
    <div class='empty-cart'>
        <div class='icon'>🛒</div>
        <h3>Your cart is empty</h3>
        <p>Add some products to continue shopping</p>
        <a href='../products.php'>Browse Products</a>
    </div>";
}
?>

</div>
</body>
</html>
