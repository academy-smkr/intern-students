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
    <title>Edit Product</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; margin: 0; }
        .sidebar { width: 200px; float: left; background: #333; color: #fff; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 0; }
        .sidebar a:hover { background: #444; }
        .content { margin-left: 220px; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 6px; width: 400px; }
        input { width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #6c757d; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #495057; }
        img { margin-top: 10px; border-radius: 4px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="../index.php">Dashboard</a>
    <a href="list.php">Products</a>
    <a href="../users/list.php">Users</a>
    <a href="../subscriptions/list.php">Subscriptions</a>
    <a href="../payments/list.php">Payments</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Edit Product</h2>

    <div class="card">
        <form method="POST">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($p['name']) ?>" required>

            <label>Price</label>
            <input type="number" name="price" value="<?= htmlspecialchars($p['price']) ?>" required>

            <button type="submit" name="update">Update Product</button>
        </form>

        <p style="margin-top:15px;">
            <strong>Current Image:</strong><br>
            <?php
                $adminImg = $p['image'] ?? '';
                $adminImgPath = '../../assets/images/' . ($adminImg && file_exists('../../assets/images/'.$adminImg) ? $adminImg : 'default_poster.svg');
            ?>
            <img src="<?= $adminImgPath ?>" width="120">
        </p>
    </div>
</div>

</body>
</html>
