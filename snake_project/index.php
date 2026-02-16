<?php
session_start();

// 🔐 Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 🔢 Game settings
$gridSize = 20;

// 🐍 Initialize game once
if (!isset($_SESSION['snake'])) {
    $_SESSION['snake'] = [
        [10, 10],
        [9, 10],
        [8, 10]
    ];
    $_SESSION['direction'] = 'RIGHT';
    $_SESSION['food'] = [rand(0, $gridSize - 1), rand(0, $gridSize - 1)];
    $_SESSION['score'] = 0;
}

// 🎮 Change direction
if (isset($_POST['dir'])) {
    $allowed = ['UP', 'DOWN', 'LEFT', 'RIGHT'];
    if (in_array($_POST['dir'], $allowed)) {
        $_SESSION['direction'] = $_POST['dir'];
    }
}

// 🧠 Snake movement
$snake = $_SESSION['snake'];
$head = $snake[0];

switch ($_SESSION['direction']) {
    case 'UP':    $head[1]--; break;
    case 'DOWN':  $head[1]++; break;
    case 'LEFT':  $head[0]--; break;
    case 'RIGHT': $head[0]++; break;
}

// ❌ Wall collision
if (
    $head[0] < 0 || $head[0] >= $gridSize ||
    $head[1] < 0 || $head[1] >= $gridSize
) {
    session_unset();
    session_destroy();
    echo "<h1>Game Over</h1>";


