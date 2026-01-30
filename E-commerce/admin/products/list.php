<?php
include '../../config/db.php';

// DELETE PRODUCT
if(isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    // Get image filename to delete from server
    $res = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if($row && file_exists('../../assets/images/'.$row['image'])) {
        unlink('../../assets/images/'.$row['image']);
    }

    // Delete product from database
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: list.php");
    exit;
}

// Fetch all products
$res = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products List</title>
    <style>
        body { font-family: Arial; background: #f4f6f8; margin: 0; }
        .sidebar { width: 200px; float: left; background: #333; color: #fff; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 0; }
        .sidebar a:hover { background: #444; }
        .content { margin-left: 220px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #007bff; color: #fff; }
        img { border-radius: 4px; }
        .btn { padding: 6px 12px; background: #007bff; color: #fff; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="../index1.php">Dashboard</a>
    <a href="list.php">Products</a>
    <a href="../users/list.php">Users</a>
    <a href="../orders/list.php">Orders</a>
    <a href="../payments/list.php">Payments</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="content">
    <h2>Products List</h2>
    <a href="add.php" class="btn">Add New Product</a>
    <table>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php while($p = mysqli_fetch_assoc($res)): ?>
        <tr>
            <td><img src="../../assets/images/<?= $p['image'] ?>" width="60" alt="<?= $p['name'] ?>"></td>
            <td><?= $p['name'] ?></td>
            <td>₹<?= $p['price'] ?></td>
            <td>
                <a href="edit.php?id=<?= $p['id'] ?>" class="btn">Edit</a>
                <a href="list.php?delete_id=<?= $p['id'] ?>" class="btn" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>