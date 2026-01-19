<!DOCTYPE html>
<html>
<head>
    <title>Sticky Form</title>
</head>
<body>
    <h2>Sticky Form Example</h2>

    <?php
        $name = $email = $comment = $gender = $country = "";
        $agree = false;
        $error = "";

        if (isset($_POST["submit"])) {
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $comment = trim($_POST["comment"]);
            $gender = $_POST["gender"] ?? "";
            $country = $_POST["country"] ?? "";
            $agree = isset($_POST["agree"]);
        }

        if (empty($name)){
            $error = "Name is required ";
        }
        elseif(empty($email)){
            $error = "Email is required";
        }
        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $error = "Invaild email";
        }
        elseif(!$agree){
            $error = "You must agree to terms and conditions";
        }
        else{
            echo "<p style='color:green'>Form Submitted Successfully</p>";
        }
    ?>

    <form method="post">
        Name: <br>
        <input type="text" name="name" value="<?php echo $name; ?>" required>
        <br><br>

        Email : <br>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <br><br>

        Comment :<br>
        <textarea name="comment"><?php echo $comment; ?></textarea>
        <br><br>

        Gender :<br>
        <input type="radio" name="gender" value="Male" <?php if ($gender=="Male") echo "checked"; ?>> Male
        <input type="radio" name="gender" value="Female" <?php if ($gender=="Female") echo "checked"; ?>> Female
        <br><br>

        Country :<br>
        <select name="country">
        <option value="">--Select--</option>
        <option value="India" <?php if ($country=="India") echo "selected"; ?>>India</option>
        <option value="USA" <?php if ($country=="USA") echo "selected"; ?>>USA</option>
        <option value="UK" <?php if ($country=="UK") echo "selected"; ?>>UK</option>
        </select>
        <br><br>

        <input type="checkbox" name="agree" <?php if ($agree) echo "checked"; ?>> I agree to terms
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <p style="color:red"><?php echo $error; ?></p>
    
</body>
</html>