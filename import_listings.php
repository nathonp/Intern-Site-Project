<?php 
session_start();
require('db.php');
include 'auth.php';
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the order of columns and pasted CSV data
    $columnOrder = $_POST['columnOrder'];
    $csvData = $_POST['csvData'];

    // Split the column order into an array
    $columns = array_map('trim', explode(',', $columnOrder));

    // Split the CSV data into rows
    $rows = explode("\n", $csvData);

    // Prepare to insert data into the database
    $inserted = 0;
    foreach ($rows as $row) {
        // Skip empty rows
        if (trim($row) == '') continue;

        // Split each row by comma characters
        $values = array_map('trim', str_getcsv($row));

        // Check if the number of values matches the number of columns
        if (count($values) === count($columns)) {
            // Create an associative array of column => value
            $data = array_combine($columns, $values);

            // Extract values for each column
            $internship_site = $data['Internship Site'] ?? '';
            $street_address = $data['Street Address'] ?? '';
            $city = $data['City'] ?? '';
            $state = $data['State'] ?? '';
            $zip = $data['Zip'] ?? '';
            $phone_number = $data['Phone Number'] ?? '';
            $website = $data['Website'] ?? '';
            $majors = $data['Majors'] ?? '';
            $notes = $data['Notes'] ?? '';

            // Insert into the database
            $sql = "INSERT INTO internships (internship_site, street_address, city, state, zip, phone_number, website, majors, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $internship_site, $street_address, $city, $state, $zip, $phone_number, $website, $majors, $notes);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $inserted++;
            }
        }
    }

    echo "$inserted listings imported successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Import Listings</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Import Listings from CSV</h1>

    <!-- Note to the user -->
    <p><strong>Note:</strong> Save your Excel file as a CSV (Comma-Separated Values) file. Available column names include: <em>Internship Site</em>, <em>Street Address</em>, <em>City</em>, <em>State</em>, <em>Zip</em>, <em>Phone Number</em>, <em>Website</em>, <em>Majors</em>, <em>Notes</em>. You may use shortened versions like <em>Street</em> or <em>Phone</em>. Ensure you use one of these names, or the values will be ignored and not added to the database.</p>

    <form method="post" action="import_listings.php">
        <!-- New input field for specifying column order -->
        <br><label for="columnOrder">Specify the order of columns (comma-separated):</label>
        <input type="text" id="columnOrder" name="columnOrder" placeholder="e.g., Internship Site, Website, City, State" style="width: 100%;" required>

        <!-- Text area for pasting CSV data -->
        <br><br><label for="csvData">Paste your CSV data here:</label>
        <br><br><textarea id="csvData" name="csvData" rows="10" cols="50" style="width: 100%;" required></textarea>

        <!-- Submit button -->
        <br><button type="submit">Import</button>
    </form>
</div>
</body>
</html>
