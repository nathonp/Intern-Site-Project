<?php
session_start();
require('db.php');
include 'auth.php';
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['internship_site']) && isset($_POST['street_address']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zip']) && isset($_POST['phone_number']) && isset($_POST['website']) && isset($_POST['majors']) && isset($_POST['notes'])) {
        
        $internship_site = $_POST['internship_site'];
        $street_address = $_POST['street_address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $phone_number = $_POST['phone_number'];
        $website = $_POST['website'];
        $majors = $_POST['majors'];
        $notes = $_POST['notes'];

        // You will need to implement your database insertion logic in process_add.php
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
    <label for="internship_site">Internship Site:</label>
    <input type="text" id="internship_site" name="internship_site" required><br><br>
    
    <label for="street_address">Street Address:</label>
    <input type="text" id="street_address" name="street_address"><br><br>
    
    <label for="city">City:</label>
    <input type="text" id="city" name="city"><br><br>
    
    <label for="state">State:</label>
    <input type="text" id="state" name="state"><br><br>
    
    <label for="zip">Zip:</label>
    <input type="text" id="zip" name="zip"><br><br>
    
    <label for="phone_number">Phone Number:</label>
    <input type="text" id="phone_number" name="phone_number"><br><br>
    
    <label for="website">Website:</label>
    <input type="url" id="website" name="website"><br><br>
    
    <label for="majors">Majors:</label>
    <textarea id="majors" name="majors" style="width: 400px;"></textarea><br><br>
    
    <label for="notes">Notes:</label>
    <textarea id="notes" name="notes" style="width: 400px;"></textarea><br><br>
    
    <button type="submit">Add Internship</button>
</form>
</body>
</html>
