<?php
$usernameErr = $passwordErr = $loginErr = "";
$username = $password = "";
$loginSuccess = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Username
if (empty($_POST["username"])) {
$usernameErr = "Username is required";
} else {
$username = $_POST["username"];
}
// Password
if (empty($_POST["password"])) {
$passwordErr = "Password is required";
} else {
$password = $_POST["password"];
}
// Check credentials
if (!empty($username) && !empty($password)) {
if ($username === "suraj" && $password === "1234") {
$loginSuccess = true;
} else {
$loginErr = "Invalid username or password";
}
}
}
?>
<!DOCTYPE html>
<html>
<body>
<h2>Student Login</h2>
<p style="color:red">* required field</p>
<form method="post">
Username:
<input type="text" name="username">
<span style="color:red">*</span>
<?php echo $usernameErr; ?>
<br><br>
Password:
<input type="password" name="password">
<span style="color:red">*</span>
<?php echo $passwordErr; ?>
<br><br>
<input type="submit" value="Login">
</form>
<h3>Login Status:</h3>
<?php
if ($loginSuccess) {
echo "<span style='color:green'><b>Login Successful!</b></span><br>";
echo "Username: " . $username . "<br>";
} else {
if (!empty($loginErr)) {
echo "<span style='color:red'><b>" . $loginErr . "</b></span><br>";
}
}
?>
</body>
</html>