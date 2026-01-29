<?php

$conn = mysqli_connect("localhost","root","","employee _info");

if (!$conn) {
    die("connection failed");
}
if (isset($_POST["register"])){
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employees (name, email, mobile, salary) VALUES('$name', '$email', '$mobile', '$salary')";

    if(mysqli_query($conn,$sql)){
        $msg = "Submitted successfully";
    }
    else{
        $msg = "Error occurred";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Form</title>
</head>
<body>

<h2>Employee Form</h2>

<form method="post">
    <label>Employee Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mobile:</label><br>
    <input type="text" name="mobile" required><br><br>

    <label>Salary:</label><br>
    <input type="text" name="salary" required><br><br>

    <input type="submit" name="register" value="Register">
</form>

<?php
// Display message
if (!empty($msg)) {
    echo "<p style='color:green;'>$msg</p>";
}
?>

</body>
</html>