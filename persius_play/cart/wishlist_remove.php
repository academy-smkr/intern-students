<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($product_id > 0){
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id=? AND product_id=?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

header("Location: ../favorites.php");
exit();
?>
