<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the ID is passed in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current portfolio item details
    $sql = "SELECT * FROM portfolio WHERE id = '$id'";
    $result = $conn->query($sql);

    // Ensure that the query returned a result
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_title = $row['title'];
        $existing_description = $row['description'];
        $existing_image_path = $row['image_path'];

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get new data from the form
            $title = $_POST['title'];
            $description = $_POST['description'];

            // Check if a new image is uploaded
            if ($_FILES['image']['name']) {
                // Handle the image upload
                $image_path = 'uploads/portfolio/' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    // If a new image is uploaded, delete the old one from the server
                    if (!empty($existing_image_path) && file_exists($existing_image_path)) {
                        unlink($existing_image_path);
                    }
                } else {
                    echo "Error uploading new image.";
                    $image_path = $existing_image_path; // Retain the old image if upload fails
                }
            } else {
                // If no new image is uploaded, retain the old image
                $image_path = $existing_image_path;
            }

            // Update the portfolio item in the database
            $sql_update = "UPDATE portfolio SET title = '$title', description = '$description', image_path = '$image_path' WHERE id = '$id'";

            if ($conn->query($sql_update)) {
                // Redirect back to the admin panel after successful update
                header('Location: admin_panel.php?message=updated');
                exit(); // Make sure to stop further script execution
            } else {
                echo "Error updating portfolio item: " . $conn->error;
            }
        }
    } else {
        echo "Error: Portfolio item not found.";
    }
} else {
    echo "Error: No portfolio ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Portfolio Item</title>
</head>
<body>
    <h1>Edit Portfolio Item</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($existing_title) ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($existing_description) ?></textarea><br><br>

        <label for="image">Image (leave blank to keep current image):</label>
        <input type="file" id="image" name="image"><br><br>

        <?php if (!empty($existing_image_path) && file_exists($existing_image_path)): ?>
            <img src="<?= $existing_image_path ?>" alt="Current Image" width="200"><br><br>
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>

        <button type="submit">Update Portfolio Item</button>
    </form>
</body>
</html>
