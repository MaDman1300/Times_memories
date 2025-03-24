<?php
session_start();
include('db_connection.php');

// Check if the user is logged in as admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current gallery item details
    $sql = "SELECT * FROM gallery WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_title = $row['title'];
        $existing_section = $row['section'];
        $existing_image_path = $row['image_path'];

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $section = $_POST['section'];

            // Handle image upload
            if ($_FILES['image']['name']) {
                $image_path = 'uploads/gallery/' . basename($_FILES['image']['name']);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                    if (!empty($existing_image_path) && file_exists($existing_image_path)) {
                        unlink($existing_image_path);
                    }
                } else {
                    echo "Error uploading new image.";
                    $image_path = $existing_image_path;
                }
            } else {
                $image_path = $existing_image_path;
            }

            // Update gallery item
            $sql_update = "UPDATE gallery SET title = '$title', section = '$section', image_path = '$image_path' WHERE id = '$id'";

            if ($conn->query($sql_update)) {
                header('Location: admin_panel.php?message=updated');
                exit();
            } else {
                echo "Error updating gallery item: " . $conn->error;
            }
        }
    } else {
        echo "Gallery item not found.";
    }
} else {
    echo "No gallery ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Gallery Item</title>
</head>
<body>
    <h1>Edit Gallery Item</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($existing_title) ?>" required><br><br>

        <label for="section">Section:</label>
        <input type="text" name="section" value="<?= htmlspecialchars($existing_section) ?>" required><br><br>

        <label for="image">Image (leave blank to keep current image):</label>
        <input type="file" name="image"><br><br>

        <?php if (!empty($existing_image_path) && file_exists($existing_image_path)): ?>
            <img src="<?= $existing_image_path ?>" alt="Current Image" width="200"><br><br>
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>

        <button type="submit">Update Gallery Item</button>
    </form>
</body>
</html>
