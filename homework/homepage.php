<?php
session_start();
// Require login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'Guest', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Homepage</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f3f4f6;color:#111;margin:0;padding:0}
        .container{max-width:900px;margin:60px auto;padding:24px;background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(2,6,23,.06)}
        header{display:flex;justify-content:space-between;align-items:center}
        h1{margin:0;font-size:20px}
        .user{color:#374151}
        .logout-form{margin:0}
        .btn{background:#ef4444;color:#fff;border:none;padding:10px 14px;border-radius:8px;cursor:pointer}
        .content{margin-top:20px;color:#111}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <span class="user"><?php echo $username; ?></span></h1>
            <form class="logout-form" method="post" action="logout.php">
                <button class="btn" type="submit">Logout</button>
            </form>
        </header>
        <div class="content">
            <p>This is a simple homepage with a logout button implemented in PHP.</p>
            <p>Click <strong>Logout</strong> to end the session and return to the login page.</p>
        </div>
    </div>
</body>
</html>