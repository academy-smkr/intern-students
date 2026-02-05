<?php
include '../../config/db.php';
$id=$_GET['id'];
mysqli_query($conn,"DELETE FROM products WHERE id=$id");
header("Location: list.php");
