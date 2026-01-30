<?php
include 'config.php';

$message = "";

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $message = "Email already registered";
    } else {
        // Insert user
        $stmt = $conn->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $password);
        $stmt->execute();

        $_SESSION['success'] = "Registration successful. Please login.";
            header("Location: login.php");
            exit();
    }
}
?>

<form method="post">
Name: <input type="text" name="name" required><br><br>
Email: <input type="email" name="email" required><br><br>
Password: <input type="password" name="password" required><br><br>
<button name="register">Register</button>
</form>

<p style="color:red;"><?php echo $message; ?></p>