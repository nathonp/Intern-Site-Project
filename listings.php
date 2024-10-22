<?php
session_start();
require('db.php');
include 'auth.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Internship Listings</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            padding-top: 70px; /* Adjust based on your navbar height */
        }

        .navbar {
            margin-bottom: 20px; /* Optional: Add space below the navbar */
        }

        /* Basic styles for the listing boxes */
        .internship-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .internship-box h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }

        .internship-box p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        .internship-box strong {
            font-weight: bold;
        }

        .internship-box .button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        .internship-box .button:hover {
            background-color: #0056b3;
        }

        /* Layout improvements */
        .listings-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="listings-container">
    <h1>Internship Listings</h1>

    <!-- START: Sorting Form -->
    <form method="get" action="listings.php" style="margin-bottom: 20px;">
        <label for="sort_by">Sort by: </label>
        <select id="sort_by" name="sort_by">
            <option value="title_asc">Alphabetical (A-Z)</option>
            <option value="title_desc">Alphabetical (Z-A)</option>
            <option value="posted_on_asc">Posted On (Oldest to Newest)</option>
            <option value="posted_on_desc">Posted On (Newest to Oldest)</option>
            <option value="deadline_asc">Deadline (Earliest to Latest)</option>
            <option value="deadline_desc">Deadline (Latest to Earliest)</option>
        </select>
        <button type="submit">Sort</button>
    </form>
    <!-- END: Sorting Form -->

    <?php
    require('db.php');

    // START: Sorting Logic
    $order_by = 'posted_on DESC'; // Default sorting

    if (isset($_GET['sort_by'])) {
        switch ($_GET['sort_by']) {
            case 'title_asc':
                $order_by = 'title ASC';
                break;
            case 'title_desc':
                $order_by = 'title DESC';
                break;
            case 'posted_on_asc':
                $order_by = 'posted_on ASC';
                break;
            case 'posted_on_desc':
                $order_by = 'posted_on DESC';
                break;
            case 'deadline_asc':
                $order_by = 'deadline ASC';
                break;
            case 'deadline_desc':
                $order_by = 'deadline DESC';
                break;
        }
    }
    // END: Sorting Logic

    $sql = "SELECT * FROM internships ORDER BY $order_by";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class='internship-box'>
                <h2>" . htmlspecialchars($row['title']) . "</h2>
                <p><strong>Company:</strong> " . htmlspecialchars($row['company']) . "</p>
                <p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>
                <p>" . nl2br(htmlspecialchars($row['description'])) . "</p>
                <p><strong>Posted on:</strong> " . htmlspecialchars($row['posted_on']) . "</p>
                <p><strong>Deadline:</strong> " . htmlspecialchars($row['deadline']) . "</p>
                <a href='#' class='button'>View Details</a>
            </div>";
        }
    } else {
        echo "<p>No internships listed yet.</p>";
    }
    ?>
</div>
</body>
</html>
