<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$users = mysqli_query($conn, "SELECT id, name, email, created_at FROM users ORDER BY created_at ");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Users | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
<div class="header">
    <h1>Users Management</h1>
    <a href="index.php" class="btn">Dashboard</a>
</div>

<div class="container">
<div class="card">

<table width="100%" cellpadding="10">
<tr style="background:#003366;color:white;">
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Joined</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($users)) { ?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= $row['name'] ?></td>
    <td><?= $row['email'] ?></td>
    <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
    <td>
        <a href="edit-user.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
        <a href="delete-user.php?id=<?= $row['id'] ?>"
           class="btn"
           style="background:#e63946;"
           onclick="return confirm('Delete this user?')">
           Delete
        </a>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

<div class="footer">© <?= date("Y") ?> CampusFind | Admin</div>
</div>

</body>
</html>
