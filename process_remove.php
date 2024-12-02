<?php
session_start();
require('db.php');
include 'auth.php';
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

// Handle deletions if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
    // Convert the array of IDs into a comma-separated string for the query
    $ids_to_delete = implode(",", array_map('intval', $_POST['delete_ids']));

    // Prepare and execute the SQL query to delete listings
    $sql = "DELETE FROM internships WHERE id IN ($ids_to_delete)";
    if ($conn->query($sql) === TRUE) {
        echo "Selected listings have been successfully removed.";
    } else {
        echo "Error removing listings: " . $conn->error;
    }
}

// Fetch listings from the database for display
$sql = "SELECT id, internship_site FROM internships ORDER BY internship_site ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Remove Listings</title>
    <link rel="stylesheet" href="css/style.css">
    <script>
        let unsavedChanges = false;

        // Function to mark changes as unsaved
        function markUnsavedChanges() {
            unsavedChanges = true;
        }

        // Function for "Select All" functionality
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.listing-checkbox');
            checkboxes.forEach(cb => cb.checked = checkbox.checked);
            markUnsavedChanges();
        }

        // Confirm before leaving the page if there are unsaved changes
        window.addEventListener('beforeunload', function (e) {
            if (unsavedChanges) {
                e.preventDefault();
                e.returnValue = 'You have unsaved changes. Do you really want to leave?';
            }
        });

        // Mark changes as saved when the form is submitted
        function confirmMultiDelete() {
            const selectedCount = document.querySelectorAll('.listing-checkbox:checked').length;
            if (selectedCount > 0) {
                unsavedChanges = false; // Reset the flag
                return confirm(`Are you sure you want to delete ${selectedCount} listings?`);
            } else {
                alert("Please select at least one listing to delete.");
                return false;
            }
        }
    </script>
</head>
<body>
<div class="container" style="margin-top: 80px;">
    <h1>Remove Listings</h1>

    <form method="post" action="process_remove.php" onsubmit="return confirmMultiDelete();">
        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"> Select All<br><br>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='listing-item'>";
                echo "<input type='checkbox' class='listing-checkbox' name='delete_ids[]' value='" . $row['id'] . "' onclick='markUnsavedChanges()'>";
                echo "<span>" . htmlspecialchars($row['internship_site']) . "</span>";
                echo "</div>";
            }
        } else {
            echo "<p>No listings available to remove.</p>";
        }
        ?>
        <br>
        <button type="submit">Save Changes</button>
    </form>
</div>
</body>
</html>
