<?php
session_start();
include 'header.php';
require('db.php');

// Check for a successful registration message
if (isset($_GET['success']) && $_GET['success'] == 'registered') {
    echo '<p style="color:green;">Registration successful! Please log in with your new credentials.</p>';
}

// Check if the form is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Assigning posted values to variables
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Prepare query to fetch user details including role
    $query = "SELECT password, role FROM user WHERE username='$username'";

    // Execute the query
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Check if any record was found
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];
        $role = $row['role']; // Fetch the user's role

        // Verify the password with the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role; // Store user role in session

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php"); // Change to your admin page
            } else {
                header("Location: index.php"); // Default student page
            }
            exit;
        } else {
            $fmsg = "Invalid Login Credentials.";
        }
    } else {
        $fmsg = "Invalid Login Credentials.";
    }
}

// Display the login form if not logged in
if (!isset($_SESSION['username'])) {
    ?>
    <html>
    <head>
        <title>User Login Using PHP & MySQL</title>
        <meta name="robots" content="noindex" />
    </head>
    <body>
    <div class="container">
        <form class="form-signin" method="POST">
            <?php if(isset($fmsg)){ ?>
                <div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?></div>
            <?php } ?>
            <h2 class="form-signin-heading">Please Login</h2>
            <div class="input-group">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
        </form>
    </div>
    </body>
    </html>
<?php } ?>
