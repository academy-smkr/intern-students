<!DOCTYPE html>
<html>
<head>
    <title>Bank account application form</title>
</head>
<body>
    <h2>Bank Application Form</h2>

<?php
    $name = $email = $mobile = $age = $account = "";
    $terms = false;

    if(isset($_POST["submit"])) {
        $name = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        $mobile = trim($_POST["mobile"]);
        $age = trim($_POST["age"]);
        $account = $_POST["account"];
        $terms = isset($_POST["terms"]);
    }
?>

    <form method="post">

    Name : <br>
    <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

    Email : <br>
    <input type="text" name="email" value="<?php echo $email; ?>"><br><br>

    Mobile : <br>
    <input type="number" name="mobile" value="<?php echo $mobile; ?>"><br><br>

    Age : <br>
    <input type="number" name="age" value="<?php echo $age; ?>"><br><br>

    Account Type : <br>
    <select name="account">
        <option value="">--Select Account--</option>
        <option value="current" <?php if ($account=="current") echo "selected"; ?>>Current Account</option>
        <option value="savings" <?php if ($account=="savings") echo "selected"; ?>>Savings Account</option>
    </select>
    <br><br>

    <input type="checkbox" name="terms" <?php if ($terms) echo "checked";?>> I agree to the terms and conditions
    <br><br>

    <input type="submit" name="submit"> <br><br>

    </form>

<?php

    if(empty($name)){
        echo "Name is required";
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo "Invalid email";
    }
    elseif(!preg_match("/^[0-9]{10}$/",$mobile)){
        echo "mobile number must be 10 digits";
    }
    elseif($age < 13 || $age > 60){
        echo "Age must be between 13 and 60";
    }
    elseif(empty($account)){
        echo "Select the account type";
    }
    elseif(!$terms){
        echo "Agree to the terms and condition";
    }
    else{
        echo "Registration Successfull";
    }

?>

</body>
</html>