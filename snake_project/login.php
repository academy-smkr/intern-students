<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $error = "Invalid credentials.";
    } elseif ($user['blocked'] == 1) {
        $error = "Account blocked by admin.";
    } elseif (!password_verify($password, $user['password'])) {
        $error = "Invalid credentials.";
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}
?>

<link rel="stylesheet" href="style.css">

<body class="login-body">
<div class="login-container">
    <h1>🐍 Snake Game</h1>

    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="username" required placeholder="Username">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
    </form>

    <a href="register.php">Create Account</a>
</div>
</body>

