<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: homepage.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'Please provide both username and password.';
    } elseif (isset($_SESSION['users'][$username])) {
        $error = 'That username is already registered. Please choose another.';
    } else {
        // Store user in session (demo only). In real app use a DB.
        $_SESSION['users'][$username] = password_hash($password, PASSWORD_DEFAULT);
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f7;color:#111;margin:0;padding:0;display:flex;align-items:center;justify-content:center;height:100vh}
        .card{background:#fff;padding:24px;border-radius:8px;box-shadow:0 6px 20px rgba(16,24,40,.08);width:360px}
        label{display:block;margin-bottom:8px;font-weight:600}
        input[type=text], input[type=password]{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
        .error{color:#b91c1c;margin-bottom:12px}
        button{background:#10b981;color:#fff;border:none;padding:10px 14px;border-radius:6px;cursor:pointer}
        .hint{margin-top:12px;color:#6b7280;font-size:14px}
    </style>
</head>
<body>
    <div class="card">
        <h2>Create an account</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" autocomplete="username" required>
            <div style="height:8px"></div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="new-password" required>
            <div style="height:12px"></div>
            <button type="submit">Register</button>
        </form>
        <div class="hint">Already have an account? <a href="login.php">Sign in</a></div>
    </div>
</body>
</html>