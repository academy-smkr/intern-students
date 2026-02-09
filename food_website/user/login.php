<?php include "../db.php"; include "../header.php"; ?>

<h2>User Login</h2>
<form method="post">
Email:<br>
<input type="email" name="email"><br><br>
Password:<br>
<input type="password" name="password"><br><br>
<button name="login">Login</button>
</form>

<?php
if(isset($_POST['login'])){
    $q=mysqli_query($conn,
    "SELECT * FROM users WHERE email='$_POST[email]' AND password='$_POST[password]' AND role='user'");

    if(mysqli_num_rows($q)>0){
        $u=mysqli_fetch_assoc($q);
        $_SESSION['user_id']=$u['id'];
        header("Location: home.php");
    } else {
        echo "Invalid login";
    }
}
?>