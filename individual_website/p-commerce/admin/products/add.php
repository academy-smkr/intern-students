<?php
include '../../config/db.php';

if (isset($_POST['add'])) {
    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $img = time() . '_' . $_FILES['image']['name'];
    $target = "../../assets/images/" . $img;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        mysqli_query(
            $conn,
            "INSERT INTO products (name, price, image)
             VALUES ('$name', '$price', '$img')"
        );
        header("Location: list.php");
        exit;
    } else {
        $error = "Image upload failed!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Pet Product</title>
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
        .error { color: red; margin-top: 10px; }
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
    <h2>Add New Pet Product</h2>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Pet Product Name" required>
            <input type="number" name="price" placeholder="Price (₹)" required>
            <input type="file" name="image" required>

            <button type="submit" name="add">Add Pet Product</button>

            <?php if (!empty($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        </form>
    </div>
</div>

</body>
</html>
