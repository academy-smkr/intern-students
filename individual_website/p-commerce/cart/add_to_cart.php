<?php
session_start();
include '../config/db.php';
$uid = $_SESSION['user'] ?? null;
$pid = intval($_GET['id'] ?? 0);

if (!$uid || $pid <= 0) {
    header("Location: ../products.php");
    exit;
}

// Check stock
$stmt = $conn->prepare("SELECT stock FROM products WHERE id=?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$stockRes = $stmt->get_result()->fetch_assoc();
$stock = (int)($stockRes['stock'] ?? 0);
if ($stock <= 0) {
    die('Product is out of stock');
}

// If already in cart, increment (but not beyond stock)
$stmt = $conn->prepare("SELECT qty FROM cart WHERE user_id=? AND product_id=?");
$stmt->bind_param("ii", $uid, $pid);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    $newQty = $row['qty'] + 1;
    if ($newQty > $stock) {
        die('Not enough stock available');
    }
    $stmt = $conn->prepare("UPDATE cart SET qty=? WHERE user_id=? AND product_id=?");
    $stmt->bind_param("iii", $newQty, $uid, $pid);
    $stmt->execute();
} else {
    $stmt = $conn->prepare("INSERT INTO cart(user_id,product_id,qty) VALUES(?,?,1)");
    $stmt->bind_param("ii", $uid, $pid);
    $stmt->execute();
}

header("Location: cart.php");
