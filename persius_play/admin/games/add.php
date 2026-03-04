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
    <title>Add Game</title>
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
        .error { color: red; margin-top: 10px; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="../index.php">Dashboard</a>
    <a href="list.php">Games</a>
    <a href="../users/list.php">Players</a>
    <a href="../subscriptions/list.php">Subscriptions</a>
    <a href="../payments/list.php">Payments</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Add New Game</h2>

    <div class="card">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Game Name" required>
            <input type="number" name="price" placeholder="Monthly Subscription Cost" required>
            <input type="file" name="image" required>

            <button type="submit" name="add">Add Game</button>

            <?php if (!empty($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
        </form>
    </div>
</div>

</body>
</html>
