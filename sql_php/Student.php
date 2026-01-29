<?php

$conn = mysqli_connect("localhost","root","","student_info");

if(!$conn) {
    die("connection failed");
}
if (isset($_POST['register'])) {

    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $mobile = $_POST['mobile'];
    $course = $_POST['course'];

    $sql = "INSERT INTO students (name, email, mobile, course)
            VALUES ('$name', '$email', '$mobile', '$course')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Submitted successfully";
    } else {
        $msg = "Error occurred";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Application Form</title>
</head>
<body>

<h2>Student Application Form</h2>

<?php
// Display message
if (!empty($msg)) {
    echo "<p style='color:green;'>$msg</p>";
}
?>

<form method="post">
    <label>Student Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mobile:</label><br>
    <input type="text" name="mobile" required><br><br>

    <label>Course:</label><br>
    <input type="text" name="course" required><br><br>

    <input type="submit" name="register" value="Register">
</form>

</body>
</html>
