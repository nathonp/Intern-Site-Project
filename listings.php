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

        .listing-container {
            margin: 20px auto;
            max-width: 1200px;
        }

        .listing-table {
            width: 100%;
            border-collapse: collapse;
        }

        .listing-header, .listing-row {
            border: 1px solid #ddd;
        }

        .listing-header th,
        .listing-row td {
            text-align: left;
            padding: 8px;
        }

        .listing-header {
            background-color: #f9f9f9;
        }

        .view-details {
            text-align: center;
            color: #007bff;
            cursor: pointer;
            text-decoration: none;
        }

        .view-details:hover {
            text-decoration: underline;
        }

        .details-row {
            display: none;
        }

        .details-content {
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .notes-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .notes-section {
            text-align: center;
        }
        .majors-preview {
            max-width: 250px; /* Limit the width */
            white-space: nowrap; /* Prevent wrapping */
            overflow: hidden; /* Hide overflow */
            text-overflow: ellipsis; /* Add ellipsis (...) */
            display: inline-block;
            vertical-align: middle;
        }

        .details-box .majors-preview {
            white-space: normal; /* Allow wrapping in the expanded view */
            overflow: visible;
            text-overflow: clip;
            max-width: none;
        }

        .details-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


    </style>
    <script>
    function toggleDetails(id) {
        // Close any open details
        document.querySelectorAll('.details-row').forEach(row => {
            row.style.display = "none";
        });

        // Reset all toggle buttons
        document.querySelectorAll('.view-details').forEach(button => {
            button.innerText = "View Details";
        });

        // Toggle the selected details row
        const detailsRow = document.getElementById(`details-row-${id}`);
        const toggleButton = document.getElementById(`toggle-${id}`);

        if (detailsRow.style.display === "none" || detailsRow.style.display === "") {
            detailsRow.style.display = "table-row";
            toggleButton.innerText = "Hide Details";
        } else {
            detailsRow.style.display = "none";
            toggleButton.innerText = "View Details";
        }
    }


    </script>
</head>
<body>
<div class="listing-container">
    <h1>Internship Listings</h1>

    <form method="get" action="listings.php" style="margin-bottom: 20px;">
        <label for="filter_text">Search:</label>
        <input type="text" id="filter_text" name="filter_text" placeholder="Search listings" value="<?php echo isset($_GET['filter_text']) ? htmlspecialchars($_GET['filter_text']) : ''; ?>">

        <label for="sort_by">Sort by: </label>
        <select id="sort_by" name="sort_by">
            <option value="internship_site_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'internship_site_asc') ? 'selected' : ''; ?>>Internship Site (A-Z)</option>
            <option value="internship_site_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'internship_site_desc') ? 'selected' : ''; ?>>Internship Site (Z-A)</option>
        </select>
        
        <button type="submit">Apply</button>
    </form>

    <table class="listing-table">
        <thead>
            <tr class="listing-header">
                <th>Internship Site</th>
                <th>Majors</th>
                <th>City, State</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch listings from the database
            // Set default order and conditions
            $order_by = 'internship_site ASC'; // Default sorting
            $filter_condition = '1'; // Default condition (no filter)

            // Handle sorting
            if (isset($_GET['sort_by'])) {
                switch ($_GET['sort_by']) {
                    case 'internship_site_asc':
                        $order_by = 'internship_site ASC';
                        break;
                    case 'internship_site_desc':
                        $order_by = 'internship_site DESC';
                        break;
                }
            }

            // Handle filtering
            if (!empty($_GET['filter_text'])) {
                $filter_text = mysqli_real_escape_string($conn, $_GET['filter_text']);
                $filter_condition = "internship_site LIKE '%$filter_text%' OR majors LIKE '%$filter_text%' OR city LIKE '%$filter_text%' OR state LIKE '%$filter_text%'";
            }

            // Final query
            $sql = "SELECT * FROM internships WHERE $filter_condition ORDER BY $order_by";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    echo "<tr class='listing-row'>";
                    echo "<td>" . htmlspecialchars($row['internship_site']) . "</td>";
                    echo "<td><span class='majors-preview' title='" . htmlspecialchars($row['majors']) . "'>" . htmlspecialchars($row['majors']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['city']) . ", " . htmlspecialchars($row['state']) . "</td>";
                    echo "<td><a id='toggle-" . $id . "' class='view-details' onclick='toggleDetails(" . $id . ")'>View Details</a></td>";
                    echo "</tr>";
            
                    echo "<tr id='details-row-" . $id . "' class='details-row'>";
                    echo "<td colspan='4' class='details-content'>";
                    echo "<div class='details-box'>"; // Add a wrapping div
                    echo "<p><strong>Address:</strong> " . htmlspecialchars($row['street_address']) . ", " . htmlspecialchars($row['city']) . ", " . htmlspecialchars($row['state']) . " " . htmlspecialchars($row['zip']) . "</p>";
                    echo "<p><strong>Phone:</strong> " . htmlspecialchars($row['phone_number']) . "</p>";
                    echo "<p><strong>Website:</strong> <a href='" . htmlspecialchars($row['website']) . "' target='_blank'>" . htmlspecialchars($row['website']) . "</a></p>";
                    echo "<div class='notes-section'>";
                    echo "<p class='notes-title'>Notes</p>";
                    echo "<p>" . nl2br(htmlspecialchars($row['notes'])) . "</p>";
                    echo "</div>";
                    echo "</div>"; // Close wrapping div
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No listings available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>