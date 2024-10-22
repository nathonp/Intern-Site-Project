<?php
session_start();
	require('db.php');
    include 'auth.php';
    include 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex" />
        <title>Dashboard - Secured Page</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body>
        <section style="margin-top: 70px;">
            <div class="form">
            <p>Dashboard</p>
            <p>This is your profile page.</p>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
            </div>
        </section>
    </body>
</html>

<?php include 'footer.php'; ?>