<?php
require('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $internship_site = $_POST['internship_site'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone_number = $_POST['phone_number'];
    $website = $_POST['website'];
    $majors = $_POST['majors'];
    $notes = $_POST['notes'];

    // Update the database
    $sql = "UPDATE internships 
            SET internship_site = ?, 
                street_address = ?, 
                city = ?, 
                state = ?, 
                zip = ?, 
                phone_number = ?, 
                website = ?, 
                majors = ?, 
                notes = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssi",
        $internship_site,
        $street_address,
        $city,
        $state,
        $zip,
        $phone_number,
        $website,
        $majors,
        $notes,
        $id
    );

    if ($stmt->execute()) {
        echo "Listing updated successfully.";
    } else {
        echo "Error updating listing: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back to edit listings page
    header("Location: edit_listings.php");
    exit;
}
?>

