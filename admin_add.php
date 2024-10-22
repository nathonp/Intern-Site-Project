<?php
session_start();
require('db.php');
include 'auth.php';
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_POST['company']) && isset($_POST['location']) && isset($_POST['description']) && isset($_POST['posted_on']) && isset($_POST['deadline'])) {
        
        $title = $_POST['title'];
        $company = $_POST['company'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        $posted_on = $_POST['posted_on'];
        $deadline = $_POST['deadline'];

        header("Location: process_add.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Internship</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form action="process_add.php" method="post" style="padding-top: 100px;">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>
    
    <label for="company">Company:</label>
    <input type="text" id="company" name="company" required>
    
    <label for="location">Location:</label>
    <input type="text" id="location" name="location">
    
    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>
    
    <label for="posted_on">Posted On:</label>
    <input type="date" id="posted_on" name="posted_on" required>
    
    <label for="deadline">Application Deadline:</label>
    <input type="date" id="deadline" name="deadline">
    
    <button type="submit">Add Internship</button>
</form>
</body>
</html>
