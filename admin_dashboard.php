<?php
session_start();
	require('db.php');
    include 'auth.php';
    include 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex" />
        <title>Dashboard - Secured Page</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>

    <body>
        <section style="margin-top: 10px; text-align: center">
            <div class="form">
                <h2><b>**Admin Dashboard**</b></h2>
                <p><i>Please see the below links to make changes to the database.</i></p>

                <a href="admin_add.php">Add One Listing <br></a>
                <a href="import_listings.php">Import Multiple Listings<br><br></a>

                <a href="listings.php">See the Listings Page<br><br></a>
                
                <a href="process_remove.php">Remove Listings<br></a>
                <a href="edit_listings.php">Edit Listings<br><br><br></a>
            </div>
        </section>
    </body>
</html>

<?php include 'footer.php'; ?>