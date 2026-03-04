<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
include '../../config/db.php';
include '../includes/header.php';

// DELETE PRODUCT
if(isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $res = mysqli_query($conn, "SELECT image FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if($row && file_exists('../../assets/images/'.$row['image'])) {
        unlink('../../assets/images/'.$row['image']);
    }
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: list.php");
    exit;
}

// Fetch all unique products by name
$res = mysqli_query($conn, "SELECT * FROM products GROUP BY name");

$gamesimg_dir = '../../assets/images/gamesimg/';
if (is_dir($gamesimg_dir)) {
    $scanned = scandir($gamesimg_dir);
    $gamesimg_files = is_array($scanned) ? array_diff($scanned, array('.', '..')) : [];
} else {
    $gamesimg_files = [];
}
?>

<div class="main">
    <h2>Games Images</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 24px; margin-bottom: 32px;">
        <?php foreach($gamesimg_files as $img): ?>
            <div style="display: flex; flex-direction: column; align-items: center; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px #bbb; padding: 16px; width: 180px;">
                <img src="<?= $gamesimg_dir . $img ?>" alt="<?= htmlspecialchars($img) ?>" style="width: 140px; height: 140px; object-fit: cover; border-radius: 8px; margin-bottom: 12px;">
                <button class="btn" style="width: 100%;">Play</button>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Games List</h2>
    <a href="add.php" class="btn">Add New Game</a>
    <table>
        <tr>
            <th>Image</th>
            <th>Game Name</th>
            <th>Monthly Cost</th>
            <th>Action</th>
        </tr>
        <?php while($p = mysqli_fetch_assoc($res)): ?>
        <tr>
            <?php
                $adminImg = $p['image'] ?? '';
                $adminImgPath = '../../assets/images/' . ($adminImg && file_exists('../../assets/images/'.$adminImg) ? $adminImg : 'default_poster.svg');
            ?>
            <td><img src="<?= $adminImgPath ?>" width="60" alt="<?= htmlspecialchars($p['name']) ?>"></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td>₹<?= htmlspecialchars($p['price']) ?>/month</td>
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