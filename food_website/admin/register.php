
<?php include "../db.php"; include "../header.php"; ?>

<h2>Admin Register</h2>
<form method="post">
Name:<br>
<input type="text" name="name" required><br><br>

Email:<br>
<input type="email" name="email" required><br><br>

Password:<br>
<input type="password" name="password" required><br><br>

<button name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    mysqli_query($conn,
    "INSERT INTO users(name,email,password,role)
     VALUES('$name','$email','$password','admin')");

    echo "Admin registered";
}
?>