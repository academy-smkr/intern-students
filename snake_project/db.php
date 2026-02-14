<?php
$conn = new mysqli("localhost", "root", "", "snake_game");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

