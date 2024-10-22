<?php
session_start();
require 'db.php';

// Check if the verification code form has been submitted
if (isset($_POST['verification_code'])) {
    $entered_code = $_POST['verification_code'];

    // Compare the entered code with the one stored in the session
    if ($entered_code == $_SESSION['verification_code']) {
        // If they match, insert the user into the database
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];  // Consider hashing the password before storing it for security reasons

        $sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $sql)) {
            // Destroy the session after successful registration to clear the session data
            session_destroy();

            // Redirect to the login page with a success message
            header("Location: login.php?success=registered");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "<center><h3>Invalid verification code. Please try again.</h3></center>";
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
        <h2 class="form-signin-heading">Enter Verification Code</h2>
        <input type="text" name="verification_code" class="form-control" placeholder="Verification Code" required autofocus>
        <button class="btn btn-lg btn-block" style="background-color: purple; color: white;" type="submit">Verify</button> 
    </form>
</div>

</body>
</html>
