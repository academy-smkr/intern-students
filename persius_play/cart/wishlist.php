<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['user'])){
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user'];
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($product_id <= 0){
    echo "Invalid product!";
    exit();
}

// Check if already in wishlist
$stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id=? AND product_id=?");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    echo "<p style='text-align:center; margin-top:50px;'>Product already in wishlist! <a href='../product.php'>Go back</a></p>";
    exit();
}

// Insert into wishlist
$stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);

if($stmt->execute()){
    echo "<p style='text-align:center; margin-top:50px;'>Game added to favorites! <a href='../favorites.php'>View Favorites</a></p>";
} else {
    echo "Error adding to wishlist.";
}
?>
