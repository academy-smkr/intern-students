<?php
session_start();
include 'config.php';

$message = "";

// Show success message from registration
if (isset($_SESSION['success'])) {
    $message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Invalid password";
        }
    } else {
        $message = "Email not registered";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body { font-family: Arial; }
        .login-box {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { width: 100%; padding: 8px; }
        .msg { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <?php if ($message): ?>
        <p class="msg"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button name="login">Login</button><br><br>
        <a href="register.php">Did not register before?</a>
    </form>
</div>

</body>
</html>