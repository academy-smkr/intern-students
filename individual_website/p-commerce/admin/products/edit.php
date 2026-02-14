<?php
include '../../config/db.php';

$id = intval($_GET['id']);
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));

if (isset($_POST['update'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    mysqli_query(
        $conn,
        "UPDATE products SET name='$name', price='$price' WHERE id=$id"
    );

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet Product</title>
    <style>
        body { font-family: 'Nunito', Arial, sans-serif; background: #f8f6f2; margin: 0; color: #203036; }
        .sidebar { width: 200px; float: left; background: linear-gradient(160deg, #1f6f5f, #1a5b4f); color: #fff; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 0; }
        .sidebar a:hover { background: #444; }
        .content { margin-left: 220px; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 6px; width: 400px; }
        input { width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #1f6f5f; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #1a5b4f; }
        img { margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>PawMart Admin</h2>
    <a href="../index.php">Dashboard</a>
    <a href="list.php">Pet Products</a>
    <a href="../users/list.php">Pet Parents</a>
    <a href="../orders/list.php">Pet Orders</a>
    <a href="../payments/list.php">Pet Payments</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Edit Pet Product</h2>

    <div class="card">
        <form method="POST">
            <label>Pet Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required>

            <label>Price (₹)</label>
            <input type="number" name="price" value="<?= htmlspecialchars($p['price']) ?>" required>

            <button type="submit" name="update">Update Pet Product</button>
        </form>

        <p style="margin-top:15px;">
            <strong>Current Image:</strong><br>
            <img src="../../assets/images/<?= $p['image'] ?>" width="120">
        </p>
    </div>
</div>

</body>
</html>
