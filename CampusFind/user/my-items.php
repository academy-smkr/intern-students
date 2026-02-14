<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* DELETE ITEM */
if (isset($_GET['delete'])) {
    $item_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM items WHERE id='$item_id' AND user_id='$user_id'");
    header("Location: my-items.php");
    exit;
}

/* FETCH USER ITEMS */
$query = mysqli_query($conn, "
    SELECT *
    FROM items
    WHERE user_id='$user_id'
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Items | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">

<div class="header">
    <h1>My Items</h1>
    <div>
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<div class="container">
<div class="card">

<table width="100%" cellpadding="10">
<tr style="background:#003366;color:white;">
    <th>Image</th>
    <th>Item</th>
    <th>Category</th>
    <th>Location</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php if (mysqli_num_rows($query) == 0) { ?>
<tr>
    <td colspan="6" align="center">You haven’t posted any items yet.</td>
</tr>
<?php } ?>

<?php while ($row = mysqli_fetch_assoc($query)) { ?>
<tr>

    <!-- IMAGE -->
    <td>
        <?php if ($row['image']) { ?>
            <img src="../assets/images/<?php echo $row['image']; ?>"
                 style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
        <?php } else { ?>
            —
        <?php } ?>
    </td>

    <!-- TITLE -->
    <td><?php echo $row['title']; ?></td>

    <!-- CATEGORY -->
    <td><?php echo $row['category']; ?></td>

    <!-- LOCATION -->
    <td><?php echo $row['location']; ?></td>

    <!-- STATUS -->
    <td>
        <span class="badge <?php echo $row['status']; ?>">
            <?php echo ucfirst($row['status']); ?>
        </span>
    </td>

    <!-- ACTION -->
    <td>
        <a href="my-items.php?delete=<?php echo $row['id']; ?>"
           class="btn"
           style="background:#e63946;"
           onclick="return confirm('Delete this item?');">
            Delete
        </a>
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
