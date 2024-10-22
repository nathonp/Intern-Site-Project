<?php
session_start();
require('db.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    // Hash the password using PASSWORD_DEFAULT, which currently uses bcrypt
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email ends with 'mckendree.edu'
    if (strpos($email, '@gmail.com') !== false) {

        // Generate a random 4-digit verification code
        $verification_code = rand(1000, 9999);

        // Store the verification code and user details in session variables
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['verification_code'] = $verification_code;

        // PHPMailer setup
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'nathonpete@gmail.com'; // Your Gmail address
            $mail->Password   = 'deqj yfds vlwy lzjb'; // Your Gmail app-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587; // TCP port for TLS

            // Recipients
            $mail->setFrom('no_reply@gmail.com', 'Your Website Team');
            $mail->addAddress($email, $username); // Add recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your Verification Code';
            $mail->Body    = "Hello $username,<br><br>Your verification code is: <strong>$verification_code</strong><br><br>Please enter this code to complete your registration.<br><br>Best Regards,<br>Your Website Team";
            $mail->AltBody = "Hello $username,\n\nYour verification code is: $verification_code\n\nPlease enter this code to complete your registration.\n\nBest Regards,\nYour Website Team";

            $mail->send();
            echo 'Verification email has been sent.';

            // Redirect to the verification page
            header("Location: verify.php");
            exit();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        mysqli_close($conn);
    } else {
        echo "<center><h3>Please register using your Mckendree email address.</h3></center>";
    }
}
?>
<html>
<head>
    <?php include 'header.php'; ?>
    <meta name="robots" content="noindex" />
</head>
<body>

<div class="container">
      <form class="form-signin" method="POST">
      
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
        <h2 class="form-signin-heading">Please Register using your Mckendree Email</h2>
        <div class="input-group">
          <span class="input-group-addon" id="basic-addon1">@</span>
          <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-block" style="background-color: purple; color: white;" type="submit">Register</button> 
      </form>
</div>

</body>
</html>
