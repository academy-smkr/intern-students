<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$result = $conn->query("SELECT * FROM users");
?>

<h1>Admin Panel</h1>
<a href="index.php">Back to Game</a>
<br><br>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Username</th>
    <th>Role</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['username'] ?></td>
    <td><?= $row['role'] ?></td>
    <td><?= $row['blocked'] ? "Blocked" : "Active" ?></td>
    <td>
        <?php if ($row['blocked']): ?>
            <a href="unblock_user.php?id=<?= $row['id'] ?>">Unblock</a>
        <?php else: ?>
            <a href="block_user.php?id=<?= $row['id'] ?>">Block</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>
