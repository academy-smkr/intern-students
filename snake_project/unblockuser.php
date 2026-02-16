<?php
include 'db.php';
$id = intval($_GET['id']);
$conn->query("UPDATE users SET blocked = 0 WHERE id = $id");
header("Location: admin.php");
exit;
