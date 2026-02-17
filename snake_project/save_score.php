<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['score'])) {
    header("Location: index.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$score = (int) $_SESSION['score'];

$stmt = $conn->prepare("INSERT INTO scores (user_id, score) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $score);
$stmt->execute();

unset($_SESSION['snake'], $_SESSION['direction'], $_SESSION['food'], $_SESSION['score']);

header("Location: leaderboard.php");
exit;
