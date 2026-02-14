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
    <title>Pet Products List</title>
    <style>
        body { font-family: 'Nunito', Arial, sans-serif; background: #f8f6f2; margin: 0; color: #203036; }
        .sidebar { width: 200px; float: left; background: linear-gradient(160deg, #1f6f5f, #1a5b4f); color: #fff; min-height: 100vh; padding: 20px; box-sizing: border-box; }
        .sidebar a { display: block; color: #fff; text-decoration: none; padding: 10px 0; }
        .sidebar a:hover { background: #444; }
        .content { margin-left: 220px; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #1f6f5f; color: #fff; }
        img { border-radius: 4px; }
        .btn { padding: 6px 12px; background: #ff7a2f; color: #fff; text-decoration: none; border-radius: 4px; }
        .btn:hover { background: #e36a25; }
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
    <h2>Pet Products List</h2>
    <a href="add.php" class="btn">Add New Pet Product</a>
    <table>
        <tr>
            <th>Image</th>
            <th>Pet Item</th>
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
