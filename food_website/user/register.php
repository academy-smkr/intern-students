<?php include "../db.php"; include "../header.php"; ?>

<h2>User Register</h2>
<form method="post">
Name:<br>
<input type="text" name="name"><br><br>
Email:<br>
<input type="email" name="email"><br><br>
Password:<br>
<input type="password" name="password"><br><br>
<button name="register">Register</button>
</form>

<?php
if(isset($_POST['register'])){
    mysqli_query($conn,
    "INSERT INTO users(name,email,password,role)
     VALUES('$_POST[name]','$_POST[email]','$_POST[password]','user')");
    echo "User registered";
}
?>