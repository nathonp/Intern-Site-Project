<?php
session_start();
require('db.php');
include 'auth.php';
include 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

// Fetch all listings from the database
$sql = "SELECT * FROM internships ORDER BY internship_site ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Listings</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .listing-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }

        .listing-header, .listing-row {
            border: 1px solid #ddd;
        }

        .listing-header th,
        .listing-row td {
            text-align: left;
            padding: 10px;
        }

        .listing-header {
            background-color: #f9f9f9;
        }

        .edit-form {
            display: none;
        }

        .edit-button, .save-button, .cancel-button {
            cursor: pointer;
            padding: 5px 10px;
            margin: 2px;
            border: none;
            border-radius: 3px;
            color: white;
        }

        .edit-button {
            background-color: #007bff;
        }

        .save-button {
            background-color: #28a745;
        }

        .cancel-button {
            background-color: #dc3545;
        }

        .edit-button:hover,
        .save-button:hover,
        .cancel-button:hover {
            opacity: 0.9;
        }
    </style>
    <script>
        function toggleEdit(id) {
            const form = document.getElementById(`edit-form-${id}`);
            const displayRow = document.getElementById(`display-row-${id}`);

            if (form.style.display === "none" || form.style.display === "") {
                form.style.display = "table-row";
                displayRow.style.display = "none";
            } else {
                form.style.display = "none";
                displayRow.style.display = "table-row";
            }
        }

        function confirmChanges() {
            return confirm("Are you sure you want to save the changes?");
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Edit Listings</h1>

    <table class="listing-table">
        <thead>
            <tr class="listing-header">
                <th>Internship Site</th>
                <th>Majors</th>
                <th>City</th>
                <th>State</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    ?>
                    <!-- Display Row -->
                    <tr id="display-row-<?= $id ?>" class="listing-row">
                        <td><?= htmlspecialchars($row['internship_site']) ?></td>
                        <td><?= htmlspecialchars($row['majors']) ?></td>
                        <td><?= htmlspecialchars($row['city']) ?></td>
                        <td><?= htmlspecialchars($row['state']) ?></td>
                        <td>
                            <button class="edit-button" onclick="toggleEdit(<?= $id ?>)">Edit</button>
                        </td>
                    </tr>

                    <!-- Edit Form Row -->
                    <!-- Edit Form Row -->
                    <tr id="edit-form-<?= $id ?>" class="edit-form">
                        <form method="post" action="process_edit.php">
                            <td colspan="5">
                                <p><strong>Internship Site:</strong><br>
                                    <input type="text" name="internship_site" value="<?= htmlspecialchars($row['internship_site']) ?>" required>
                                </p>
                                <p><strong>Street Address:</strong><br>
                                    <input type="text" name="street_address" value="<?= htmlspecialchars($row['street_address']) ?>">
                                </p>
                                <p><strong>City:</strong><br>
                                    <input type="text" name="city" value="<?= htmlspecialchars($row['city']) ?>" required>
                                </p>
                                <p><strong>State:</strong><br>
                                    <input type="text" name="state" value="<?= htmlspecialchars($row['state']) ?>" required>
                                </p>
                                <p><strong>Zip:</strong><br>
                                    <input type="text" name="zip" value="<?= htmlspecialchars($row['zip']) ?>">
                                </p>
                                <p><strong>Phone Number:</strong><br>
                                    <input type="text" name="phone_number" value="<?= htmlspecialchars($row['phone_number']) ?>">
                                </p>
                                <p><strong>Website:</strong><br>
                                    <input type="text" name="website" value="<?= htmlspecialchars($row['website']) ?>">
                                </p>
                                <p><strong>Majors:</strong><br>
                                    <input type="text" name="majors" value="<?= htmlspecialchars($row['majors']) ?>" required>
                                </p>
                                <p><strong>Notes:</strong><br>
                                    <textarea name="notes" rows="4" style="width: 100%;"><?= htmlspecialchars($row['notes']) ?></textarea>
                                </p>
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button class="save-button" type="submit" onclick="return confirmChanges()">Save</button>
                                <button class="cancel-button" type="button" onclick="toggleEdit(<?= $id ?>)">Cancel</button>
                            </td>
                        </form>
                    </tr>

                    <?php
                }
            } else {
                echo "<tr><td colspan='5'>No listings available to edit.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
