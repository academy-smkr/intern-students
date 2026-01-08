
<?php
if (isset($_POST['Username'])) {

    $name = $_POST['Username'];
    $age = $_POST['Age'];

    echo "Username/email : $name <br>";
    
    if ($age >= 18) {
        echo "$name You have loged into you account !";
    }else {
        echo "$name You can not login into your account without parental access";
    }
}
?>