<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$cart_id = (int)$_GET['id'];
$type = $_GET['type'];
$uid = $_SESSION['user'];

// Get current quantity (security: user-based)
$stmt = $conn->prepare("SELECT qty FROM cart WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $cart_id, $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    $qty = $row['qty'];

    if ($type === 'inc') {
        $qty++;
        $stmt = $conn->prepare("UPDATE cart SET qty=? WHERE id=?");
        $stmt->bind_param("ii", $qty, $cart_id);
        $stmt->execute();
    }

    if ($type === 'dec') {
        if ($qty > 1) {
            $qty--;
            $stmt = $conn->prepare("UPDATE cart SET qty=? WHERE id=?");
            $stmt->bind_param("ii", $qty, $cart_id);
            $stmt->execute();
        } else {
            // qty == 1 → remove item
            $stmt = $conn->prepare("DELETE FROM cart WHERE id=?");
            $stmt->bind_param("i", $cart_id);
            $stmt->execute();
        }
    }
}

header("Location: cart.php");
exit;

