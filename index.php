<?php
session_start();
require('db.php');
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex" />
    <title>Welcome to McKendree InternHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<div class="container">
    <div class="hero-image" style="position: relative; height: 70vh;">
        <img src="/pexels-fauxels-3183150.jpg" alt="Descriptive Alt Text" style="
            width: 100%;
            height: 100% !important; /* Adjust the height as necessary */
            object-fit: cover; /* This makes the image cover the available space without losing its aspect ratio */
            position: absolute;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: -1 !important;
        ">
        <div class="hero-text" style="position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white; /* Ensures text is visible on top of the image */
            z-index: 10; /* Ensures the text is above the image */
            text-align: center;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.6);  // Adds a dark semi-transparent background
            padding: 20px;  // Adds some padding around the text
            border-radius: 1px;
            ">
            <h1 style="font-size: 48px; font-weight: 700; margin-bottom: 0px; line-height: 1.2;">
                Hello <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>!
            </h1>
            <p style="font-size: 24px; font-weight: 400; line-height: 1.5;">Welcome to the McKendree InternHub.</p>
        </div>
    </div>
    <?php if (!isset($_SESSION['username'])): ?>
        <div style="text-align: center; padding: 20px;">
            
                New user? Please <a href="login.php">Login</a> or <a href="register.php">Register</a>
            
        </div>
    <?php endif; ?>
</div>

<section class="container">
    <div>
        <div>
            <p style="width: 100%; left:50%; text-align: center; padding-top: 20px;">A website created for McKendree students looking for local internship opportunities pertaining to their major, minor, or career choice.</p>
            <p style="width: 100%; left:50%; text-align: center; padding: 1px;">
                <a href="listings.php" class="btn btn-info"><b>See Current Listings</b><br></a>
            </p>
        </div>
    </div>
</section>

<footer class="container">
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>
