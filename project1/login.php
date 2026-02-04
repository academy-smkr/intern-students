<?php
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (
        isset($_SESSION['registered_user'], $_SESSION['registered_pass']) &&
        $username === $_SESSION['registered_user'] &&
        password_verify($password, $_SESSION['registered_pass'])
    ) {
        $_SESSION['username'] = $username;
        header("Location: home.php");
        exit;
    } else {
        $message = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>

    <p><?php echo $message; ?></p>
</body>
</html>
