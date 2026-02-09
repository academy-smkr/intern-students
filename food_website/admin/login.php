
<?php include "../db.php"; include "../header.php"; ?>
<h2>Admin Login</h2>
<form method="post">
Email:<br>
<input type="email" name="email"><br><br>
Password:<br>
<input type="password" name="password"><br><br>
<button name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];

    $q=mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='admin'");

    if(mysqli_num_rows($q)>0){
        $row=mysqli_fetch_assoc($q);
        $_SESSION['admin_id']=$row['id'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid admin login";
    }
}
?>