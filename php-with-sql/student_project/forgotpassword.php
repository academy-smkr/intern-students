<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

include 'config.php';

$message = "";

if (isset($_POST['submit'])) {

     $email = $_POST['email'];

     $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($row = $result->fetch_assoc()) {

         $token  = bin2hex(random_bytes(32));
         $expiry = date("Y-m-d H:i:s", strtotime("+1 day"));
        
         $stmt = $conn->prepare(
             "UPDATE users SET reset_token=?, token_expiry=? WHERE email=?"
         );
         $stmt->bind_param("sss", $token, $expiry, $email);
         $stmt->execute();

         $resetLink = "http://localhost/phpdemo/intern-students/php-with-sql/student_project/resetpassword.php?token=$token";
         $mail = new PHPMailer(true);

         try {
             $mail->isSMTP();
             $mail->Host  = 'smtp.gmail.com';
             $mail->SMTPAuth  = true;
             $mail->Username  = 'nayakkaushiki19@gmail.com'; // 🔴 CHANGE
             $mail->Password  = 'jgta umjj vqnn iqhe'; // 🔴 CHANGE
             $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
             $mail->Port = 587;

             $mail->setFrom('yourgmail@gmail.com', 'Student App');
             $mail->addAddress($email);

             $mail->isHTML(true);
             $mail->Subject = 'Password Reset';
             $mail->Body = "
                 Click the link below to reset your password:<br><br>
                <a href='$resetLink'>$resetLink</a>
             ";

             $mail->send();
             $message = " Reset link sent to your email";

         } catch (Exception $e) {
             $message = " Mail Error: {$mail->ErrorInfo}";
        }

     } else {
         $message = "Email not registered";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>

     <form method="post">
         <input type="email" name="email" required placeholder="Enter your email">
         <button name="submit">Send Reset Link</button>
     </form>

     <p><?= $message ?></p>
     <a href="login.php">Back to Login</a>
</body>
</html>

