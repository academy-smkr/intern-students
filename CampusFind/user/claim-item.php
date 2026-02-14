<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['item_id'])) {
    header("Location: lost-items.php");
    exit;
}

$item_id = intval($_GET['item_id']);
$msg = "";

/* Check if item exists and is still FOUND */
$itemCheck = mysqli_query(
    $conn,
    "SELECT * FROM items WHERE id='$item_id' AND status='found'"
);

if (mysqli_num_rows($itemCheck) == 0) {
    $msg = "Item not available for claim.";
}

/* Check if user already claimed this item */
$claimCheck = mysqli_query(
    $conn,
    "SELECT * FROM claims WHERE item_id='$item_id' AND user_id='$user_id'"
);

if (mysqli_num_rows($claimCheck) > 0) {
    $msg = "You have already claimed this item.";
}

/* Handle claim submission */
if (isset($_POST['claim']) && $msg == "") {

    $proof = mysqli_real_escape_string($conn, $_POST['proof']);

    // INSERT ONLY ONCE (IMPORTANT)
    mysqli_query($conn, "
        INSERT INTO claims (item_id, user_id, proof, status)
        VALUES ('$item_id', '$user_id', '$proof', 'pending')
    ");

    $msg = "Claim submitted successfully! Admin will verify.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Claim Item | CampusFind</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="page-wrapper">

<div class="header">
    <div style="display:flex;align-items:center;gap:15px;">
        <img src="../assets/images/college-logo.png">
        <h1>CampusFind</h1>
    </div>
    <div>
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card" style="max-width:600px;margin:auto;">
        <h2>Claim Item</h2>

        <?php if ($msg != "") { ?>
            <p style="color:green;"><?php echo $msg; ?></p>
        <?php } ?>

        <?php if ($msg == "") { ?>
        <form method="POST">
            <label>Proof of Ownership:</label>
            <textarea name="proof" required
                placeholder="Serial number, color, unique marks, where you lost it..."></textarea>

            <button type="submit" name="claim" class="btn">
                Submit Claim
            </button>
        </form>
        <?php } ?>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> CampusFind
</div>

</div>
</body>
</html>
