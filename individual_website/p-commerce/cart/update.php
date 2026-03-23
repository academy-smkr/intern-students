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

// Get current quantity and stock (security: user-based)
$stmt = $conn->prepare("SELECT c.qty, p.stock FROM cart c JOIN products p ON c.product_id = p.id WHERE c.id=? AND c.user_id=?");
$stmt->bind_param("ii", $cart_id, $uid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {

    $qty = $row['qty'];
    $stock = (int)$row['stock'];

    if ($type === 'inc') {
        if ($qty + 1 > $stock) {
            die('Not enough stock available');
        }
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

