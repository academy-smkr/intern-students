<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        // Store credentials in session (for demo only)
        $_SESSION['registered_user'] = $username;
        $_SESSION['registered_pass'] = password_hash($password, PASSWORD_DEFAULT);

        $message = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Register</button>
    </form>

    <p><?php echo $message; ?></p>
</body>
</html>
