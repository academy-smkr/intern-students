<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    header('Location: homepage.php');
    exit;
}
$error = '';
$success = '';
if (isset($_GET['registered'])) {
    $success = 'Registration successful. You may sign in.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username !== '') {
        // If user is registered (stored in session), verify password; otherwise allow simple sign-in.
        if (isset($_SESSION['users'][$username])) {
            if (password_verify($password, $_SESSION['users'][$username])) {
                $_SESSION['username'] = $username;
                $_SESSION['logged_in'] = true;
                header('Location: homepage.php');
                exit;
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true;
            header('Location: homepage.php');
            exit;
        }
    } else {
        $error = 'Please enter a username.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f5f5f7;color:#111;margin:0;padding:0;display:flex;align-items:center;justify-content:center;height:100vh}
        .card{background:#fff;padding:24px;border-radius:8px;box-shadow:0 6px 20px rgba(16,24,40,.08);width:320px}
        label{display:block;margin-bottom:8px;font-weight:600}
        input[type=text]{width:100%;padding:10px;border:1px solid #d1d5db;border-radius:6px}
        .error{color:#b91c1c;margin-bottom:12px}
        .success{color:#065f46;margin-bottom:12px}
        button{background:#2563eb;color:#fff;border:none;padding:10px 14px;border-radius:6px;cursor:pointer} 
        .hint{margin-top:12px;color:#6b7280;font-size:14px}
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" autocomplete="username" required>
            <div style="height:8px"></div>
            <label for="password">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password">
            <div style="height:12px"></div>
            <button type="submit">Sign in</button>
        </form>
        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <div class="hint">Try any username to sign in for this demo. <a href="register.php">Register</a></div> 
    </div>
</body>
</html>