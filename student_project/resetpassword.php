<?php
include 'config.php';
$message = "";

if (!isset($_GET['token'])) {
    die("Invalid request");
}

$token = $_GET['token'];

$stmt = $conn->prepare(
    "SELECT id FROM users 
    WHERE reset_token=? AND token_expiry > NOW()"
);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if (!$user = $result->fetch_assoc()) {
     die("Token expired or invalid");
}

if (isset($_POST['reset'])) {
    $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

     $stmt = $conn->prepare(
        "UPDATE users SET password=?, reset_token=NULL, token_expiry=NULL WHERE id=?"
     );
     $stmt->bind_param("si", $newPass, $user['id']);
     $stmt->execute();

     $message = "Password reset successful. <a href='login.php'>Login</a>";
}
?>

<form method="post">
     <h3>Reset Password</h3>
     <input type="password" name="password" required placeholder="New Password">
     <button name="reset">Reset Password</button>
     <p><?= $message ?></p>
</form>