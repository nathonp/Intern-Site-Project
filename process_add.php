<?php
require('db.php');  // Assumes you already have a database connection setup

// Fetch data from form
$internship_site = $_POST['internship_site'];
$street_address = $_POST['street_address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$phone_number = $_POST['phone_number'];
$website = $_POST['website'];
$majors = $_POST['majors'];
$notes = $_POST['notes'];

// Check if all required fields are set
if (isset($internship_site, $street_address, $city, $state, $zip, $phone_number, $website, $majors, $notes)) {
    // Prepare the SQL statement
    $sql = "INSERT INTO internships (internship_site, street_address, city, state, zip, phone_number, website, majors, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $internship_site, $street_address, $city, $state, $zip, $phone_number, $website, $majors, $notes);
    $stmt->execute();

    // Check if the insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Internship added successfully.";
    } else {
        echo "Error adding internship: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Redirect to admin_add.php
header("Location: admin_add.php");
exit;
?>
