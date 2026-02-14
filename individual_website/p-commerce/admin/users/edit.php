<?php
include '../../config/db.php';

$id = $_GET['id'];

// fetch old data
$result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
$user = mysqli_fetch_assoc($result);

// update data
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    mysqli_query(
        $conn,
        "UPDATE users SET name='$name', email='$email' WHERE id=$id"
    );

    header("Location: list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Parent</title>
    <style>
        body { font-family: 'Nunito', Arial, sans-serif; background: #f8f6f2; margin: 0; color: #203036; }
        .sidebar { width: 200px; float: left; background: linear-gradient(160deg, #1f6f5f, #1a5b4f); color: #fff; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 0; }
        .sidebar a:hover { background: rgba(255,255,255,0.18); }
        .content { margin-left: 220px; padding: 20px; }
        .card { background: #fff; padding: 20px; border-radius: 6px; width: 420px; box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        input { width: 100%; padding: 10px; margin-top: 10px; box-sizing: border-box; }
        button { margin-top: 15px; padding: 10px; width: 100%; background: #1f6f5f; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #1a5b4f; }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>PawMart Admin</h2>
    <a href="../index.php">Dashboard</a>
    <a href="../products/list.php">Pet Products</a>
    <a href="list.php">Pet Parents</a>
    <a href="../orders/list.php">Pet Orders</a>
    <a href="../payments/list.php">Pet Payments</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Edit Pet Parent</h2>
    <div class="card">
        <form method="POST">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            <button name="update">Update Pet Parent</button>
        </form>
    </div>
</div>
</body>
</html>
