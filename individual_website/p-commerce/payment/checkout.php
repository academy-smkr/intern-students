<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

$full_name = trim($_POST['full_name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$address_line1 = trim($_POST['address_line1'] ?? '');
$address_line2 = trim($_POST['address_line2'] ?? '');
$city = trim($_POST['city'] ?? '');
$state = trim($_POST['state'] ?? '');
$pincode = trim($_POST['pincode'] ?? '');

if (
     $full_name === '' || $phone === '' || $address_line1 === '' ||
     $city === '' || $state === '' || $pincode === ''
) {
     die('Please fill in the delivery address');
}

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['full_name'] ?? '');
$phone = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['phone'] ?? '');
$address_line1 = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['address_line1'] ?? '');
$address_line2 = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['address_line2'] ?? '');
$city = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['city'] ?? '');
$state = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['state'] ?? '');
$pincode = trim(<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
     header("Location: ../auth/login.php");
     exit();
}

if (!isset($_POST['method'])) {
     die('Payment method not selected');
}

$uid = $_SESSION['user'];
$method = $_POST['method'];
$total = 0;

// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>

POST['pincode'] ?? '');

if (
     $full_name === '' || $phone === '' || $address_line1 === '' ||
     $city === '' || $state === '' || $pincode === ''
) {
     die('Please fill in the delivery address');
}
// 1️⃣ Calculate total from cart
$cart = mysqli_query($conn, "
     SELECT p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

while ($row = mysqli_fetch_assoc($cart)) {
     $total += $row['price'] * $row['qty'];
}

// Safety check
if ($total <= 0) {
     die('Pet cart is empty');
}

// 2️⃣ Decide payment status (DB-friendly codes)
if ($method === 'COD') {
     $payment_status = 'O'; // COD
} else {
     $payment_status = 'PAID';
}
$display_status = $payment_status === 'O' ? 'Cash on Delivery' : 'Paid';

// 3️⃣ Insert order (with address)
$stmt = $conn->prepare("
     INSERT INTO orders
     (user_id, total, payment_status, full_name, phone, address_line1, address_line2, city, state, pincode)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
     "idssssssss",
     $uid,
     $total,
     $payment_status,
     $full_name,
     $phone,
     $address_line1,
     $address_line2,
     $city,
     $state,
     $pincode
);
$stmt->execute();
$order_id = $stmt->insert_id;

// 3.1️⃣ Snapshot order items
mysqli_query($conn, "
     INSERT INTO order_items (order_id, product_id, product_name, price, qty)
     SELECT $order_id, p.id, p.name, p.price, c.qty
     FROM cart c
     JOIN products p ON c.product_id = p.id
     WHERE c.user_id = $uid
");

// 4️⃣ Clear cart
mysqli_query($conn, "DELETE FROM cart WHERE user_id = $uid");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Pet Order Success - PawMart Pet Shop</title>

<style>
:root { --brand:#1f6f5f; --brand-dark:#1a5b4f; --accent:#ff7a2f; --accent-dark:#e36a25; --bg:#f8f6f2; --ink:#203036; }
body {
     font-family: 'Nunito', Arial, sans-serif;
     background: var(--bg);
    margin: 0;
    color: var(--ink);
}

.navbar {
     display: flex;
     justify-content: space-between;
     align-items: center;
     background: linear-gradient(120deg, var(--brand), var(--brand-dark));
     padding: 15px 30px;
     color: white;
}

.navbar a {
     color: white;
     text-decoration: none;
     margin-left: 15px;
     font-weight: bold;
}

.success-container {
     max-width: 500px;
     margin: 80px auto;
     background: white;
     padding: 40px;
     border-radius: 12px;
     text-align: center;
     box-shadow: 0 12px 24px rgba(0,0,0,0.08);
}

.icon {
     font-size: 60px;
     color: #28a745;
}

.success-container h1 {
     color: #2e7d32;
     margin-bottom: 10px;
}

.success-container h3 {
     color: var(--brand);
     margin-bottom: 20px;
}

.qr-box {
     margin: 20px auto 0;
     padding: 16px;
     border: 1px dashed #cfd8dc;
     border-radius: 12px;
     background: #fafafa;
}
.qr-box h4 {
     margin: 0 0 10px;
     color: var(--brand-dark);
}
.qr-img {
     width: 220px;
     height: 220px;
     object-fit: contain;
     border-radius: 10px;
     background: #fff;
     box-shadow: 0 8px 16px rgba(0,0,0,0.06);
}
.upi-id {
     margin-top: 8px;
     font-weight: 600;
     color: #44555a;
}

.btn {
    padding: 12px 25px;
     text-decoration: none;
     color: white;
     border-radius: 8px;
     font-weight: bold;
    display: inline-block;
    margin-top: 10px;
}

.btn-primary {
     background: var(--brand);
}

.btn-success {
     background: var(--accent);
}
</style>
</head>

<body>

<div class="navbar">
     <h2>PawMart</h2>
     <div>
         <a href="../index.php">Home</a>
        <a href="../products.php">Pet Supplies</a>
        <a href="../auth/logout.php">Logout</a>
     </div>
</div>

<div class="success-container">
     <div class="icon">✔️</div>

     <h1>Pet Order Placed Successfully!</h1>

     <h3>
         Bill Amount: ₹<?= number_format($total, 2) ?>
     </h3>

     <p>
         Payment Method: <b><?= htmlspecialchars($method) ?></b><br>
         Payment Status: <b><?= $display_status ?></b>
     </p>

     <?php if ($method === 'ONLINE') { ?>
          <div class="qr-box">
               <h4>Scan to Pay (UPI)</h4>
               <img src="../assets/images/upi-qr.svg" class="qr-img" alt="UPI QR code">
               <div class="upi-id">UPI ID: akshayhdk123-1@okicici</div>
          </div>
     <?php } ?>

    <a href="../index.php" class="btn btn-primary">Continue Pet Shopping</a><br>
    <a href="../orders.php" class="btn btn-success">View Pet Orders</a>
</div>

</body>
</html>




