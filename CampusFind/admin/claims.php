<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

/* APPROVE */
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $c = mysqli_fetch_assoc(mysqli_query($conn,"SELECT item_id FROM claims WHERE id='$id'"));
    mysqli_query($conn,"UPDATE claims SET status='approved' WHERE id='$id'");
    mysqli_query($conn,"UPDATE items SET status='claimed' WHERE id='".$c['item_id']."'");
    header("Location: claims.php");
    exit;
}

/* REJECT */
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    $c = mysqli_fetch_assoc(mysqli_query($conn,"SELECT item_id FROM claims WHERE id='$id'"));
    mysqli_query($conn,"UPDATE claims SET status='rejected' WHERE id='$id'");
    mysqli_query($conn,"UPDATE items SET status='found' WHERE id='".$c['item_id']."'");
    header("Location: claims.php");
    exit;
}

$claims = mysqli_query($conn,"
    SELECT claims.*, items.title, items.image, users.name
    FROM claims
    JOIN items ON claims.item_id = items.id
    JOIN users ON claims.user_id = users.id
    ORDER BY claims.created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Claims | Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">
<div class="header">
    <h1>Claims – Admin</h1>
    <a href="index.php" class="btn">Dashboard</a>
</div>

<div class="container">
<div class="card">

<table width="100%" cellpadding="12">
<tr style="background:#003366;color:white;">
    <th>Image</th>
    <th>Item</th>
    <th>Claimed By</th>
    <th>Proof</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($claims)) { ?>
<tr>
    <td>
        <?php if ($row['image']) { ?>
            <img src="../assets/images/<?php echo $row['image']; ?>"
                 style="width:60px;height:60px;object-fit:cover;border-radius:6px;">
        <?php } ?>
    </td>
    <td><?php echo $row['title']; ?></td>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['proof']; ?></td>
    <td><?php echo ucfirst($row['status']); ?></td>
    <td>
        <?php if ($row['status'] == 'pending') { ?>
            <a href="claims.php?approve=<?php echo $row['id']; ?>" class="btn">Approve</a>
            <a href="claims.php?reject=<?php echo $row['id']; ?>" class="btn" style="background:#e63946;">Reject</a>
        <?php } else { echo "—"; } ?>
    </td>
</tr>
<?php } ?>

</table>

</div>
</div>

<div class="footer">© <?php echo date("Y"); ?> CampusFind | Admin</div>
</div>
</body>
</html>
