<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

/* OPTIONAL: prevent deleting users with items */
$check = mysqli_query($conn, "SELECT id FROM items WHERE user_id='$id'");
if (mysqli_num_rows($check) > 0) {
    header("Location: users.php?error=has_items");
    exit;
}

mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
header("Location: users.php");
exit;
