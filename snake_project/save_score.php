<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];
$score = $_SESSION['score'];

$stmt = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $score);
$stmt->execute();

session_destroy();
header("Location: leaderboard.php");
exit;
