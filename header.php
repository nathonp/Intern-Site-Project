<?php
//session_start(); // Move session_start() here to ensure it's called before any output.
$current_page = basename($_SERVER['SCRIPT_NAME']); // Get the current page name for active class assignment.


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex" />
    <title><?php echo $current_page == 'index.php' ? 'Home' : ucfirst(basename($current_page, '.php')); ?> - McKendree InternHub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            padding-top: 90px; /* Automatically adds padding to avoid overlapping content */
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: #f8f9fa; /* Adjust color as needed */
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add shadow for better visibility */
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        .nav-links {
            list-style: none;
            display: flex;
            gap: 15px;
        }
        .nav-links li {
            display: inline;
        }
        .nav-links a {
            text-decoration: none;
            color: #007bff;
        }
        .nav-links a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-color: #53247f;"> <!-- Adjusted for Bootstrap 4 -->
        <div class="container">
            <a class="navbar-brand" href="index.php">McKendree InternHub</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <span style="color: red; font-weight: bold;">ADMIN</span>
            <?php endif; ?>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?= ($current_page == 'index.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <?php if (isset($_SESSION['username'])): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                        <?php else: ?>
                            <li><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <li class="nav-item <?= ($current_page == 'contact.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    
                    <?php if(isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</body>
