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
<title>Cart</title>
<style>
body{
    font-family: 'Arial', 'Courier New', monospace;
    background:#0a0e27;
    margin:0;
    color:#e0e0e0;
}

/* HEADER */
.header{
    background:#050810;
    padding:15px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 0 20px rgba(179, 0, 255, 0.5);
    border-bottom:3px solid #b300ff;
}
.header h3{
    color:#ff00ff;
    text-shadow:0 0 10px #b300ff;
}
.header a{
    margin-left:15px;
    text-decoration:none;
    color:#00ffff;
    text-shadow:0 0 10px #00ffff;
}
.header a:hover{
    color:#ff00ff;
    text-shadow:0 0 15px #ff00ff;
}
/* CART */
.cart-container{
    max-width:900px;
    margin:50px auto;
    background:linear-gradient(135deg, rgba(179, 0, 255, 0.1) 0%, rgba(0, 255, 255, 0.1) 100%);
    padding:25px;
    border-radius:10px;
    border:2px solid #b300ff;
    box-shadow:0 0 30px rgba(179, 0, 255, 0.3);
}
.cart-container h2{
    color:#ff00ff;
    text-shadow:0 0 10px #b300ff;
    text-transform:uppercase;
}

table{
    width:100%;
    border-collapse:collapse;
}
th, td{
    padding:12px;
    text-align:center;
    color:#e0e0e0;
    border-bottom:1px solid rgba(179, 0, 255, 0.3);
}
th{
    background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
    color:#fff;
    text-shadow:0 0 5px #b300ff;
}

.product-img{
    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:6px;
    border:1px solid #b300ff;
}

.qty-box{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
}
.qty-box a{
    padding:5px 12px;
    background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
    color:#fff;
    text-decoration:none;
    border-radius:4px;
    font-size:18px;
    border:1px solid #ff00ff;
    box-shadow:0 0 10px rgba(179, 0, 255, 0.4);
}

.total{
    text-align:right;
    font-size:20px;
    margin-top:20px;
    color:#ff00ff;
    text-shadow:0 0 10px #b300ff;
}

.checkout-btn{
    display:block;
    width:220px;
    margin:30px auto 0;
    text-align:center;
    padding:12px;
    background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
    color:#fff;
    text-decoration:none;
    border-radius:5px;
    border:1px solid #ff00ff;
    box-shadow:0 0 15px rgba(179, 0, 255, 0.5);
    font-weight:bold;
}
.checkout-btn:hover{
    background:linear-gradient(135deg, #ff006e 0%, #b300ff 100%);
    box-shadow:0 0 25px rgba(255, 0, 110, 0.7);
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
    color:#e0e0e0;
}
.empty-cart a{
    display:inline-block;
    margin-top:15px;
    padding:12px 25px;
    background:linear-gradient(135deg, #b300ff 0%, #ff006e 100%);
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    border:1px solid #ff00ff;
    box-shadow:0 0 15px rgba(179, 0, 255, 0.5);
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h3>Cart</h3>
    <div>
        <a href="../index.php">Home</a>
        <a href="../games.php">Games</a>
        <a href="cart.php">Cart</a>
    </div>
</div>

<div class="cart-container">
<h2>Cart</h2>

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
    $defaultImg = "../assets/images/default_poster.svg";

    echo "<table>
        <tr>
            <th>Image</th>
            <th>Game</th>
            <th>Monthly Cost</th>
            <th>Months</th>
            <th>Subtotal</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {

        $sub = $row['price'] * $row['qty'];
        $total += $sub;

        if (!empty($row['image'])) {
            $img = "../assets/images/" . $row['image'];
            $imgPath = realpath(__DIR__ . "/../assets/images/" . $row['image']);
            if (!$imgPath || !file_exists($imgPath)) {
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
    echo "<div class='total'><b>Total Monthly: ₹ $total</b></div>";
    ?>
    <form action="../payment/checkout.php" method="POST" style="text-align:center; margin-top:30px;">

    <h3>Select Subscription Method</h3>

    <label>
        <input type="radio" name="method" value="COD" required>
        Bank Transfer
    </label>
    <br><br>

    <label>
        <input type="radio" name="method" value="ONLINE">
        Card Payment
    </label>
    <br><br>

    <button type="submit" class="checkout-btn">
        Confirm Subscription
    </button>

</form>
<?php

} else {

    // EMPTY LIBRARY UI
    echo "
    <div class='empty-cart'>
        <div class='icon'>🎮</div>
        <h3>Your cart is empty</h3>
        <p>Add games to your cart to start subscribing</p>
        <a href='../games.php'>Browse Games</a>
    </div>";
}
?>

</div>
</body>
</html>
