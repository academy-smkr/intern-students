<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
    SELECT items.*, users.name AS poster
    FROM items
    JOIN users ON items.user_id = users.id
    WHERE items.status='found'
    ORDER BY items.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Found Items | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
<div class="header">
    <h1>Found Items</h1>
    <a href="dashboard.php" class="btn">Dashboard</a>
</div>

<div class="container">
<div class="card">

<table width="100%" cellpadding="10">
<tr style="background:#003366;color:white;">
    <th>Image</th>
    <th>Item</th>
    <th>Category</th>
    <th>Location</th>
    <th>Posted By</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($query) == 0) { ?>
<tr>
    <td colspan="7" align="center">No found items available.</td>
</tr>
<?php } ?>

<?php while ($row = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td>
        <?php if ($row['image']) { ?>
            <img src="../assets/images/<?php echo $row['image']; ?>"
                 style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
        <?php } ?>
    </td>

    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['category']; ?></td>
    <td><?php echo $row['location']; ?></td>
    <td><?php echo $row['poster']; ?></td>

    <td>
        <span class="badge found">Found</span>
    </td>

    <td>
        <?php if ($row['user_id'] != $user_id) { ?>
            <a href="claim-item.php?item_id=<?php echo $row['id']; ?>"
               class="btn" style="background:#f4a261;">
                Claim
            </a>
        <?php } else { ?>
            <span style="color:#888;">Your item</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind
</div>
</div>
</body>
</html>
