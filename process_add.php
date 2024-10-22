<?php
require('db.php');  // Assumes you already have a database connection setup

// Fetch data from form
$title = $_POST['title'];
$company = $_POST['company'];
$location = $_POST['location'];
$description = $_POST['description'];
$posted_on = $_POST['posted_on'];
$deadline = $_POST['deadline'];

// Insert data into the database
    if (isset($_POST['title'], $_POST['company'], $_POST['location'], $_POST['description'], $_POST['posted_on'], $_POST['deadline'])) {
        $sql = "INSERT INTO internships (title, company, location, description, posted_on, deadline) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $_POST['title'], $_POST['company'], $_POST['location'], $_POST['description'], $_POST['posted_on'], $_POST['deadline']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Internship added successfully.";
        } else {
            echo "Error adding internship: " . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }

    header("Location: admin_add.php");
?>