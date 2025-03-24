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

    // Fetch the current member details
    $sql = "SELECT * FROM members WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_name = $row['name'];
        $existing_role = $row['role'];
        $existing_bio = $row['bio'];
        $existing_email = $row['email'];
        $existing_phone = $row['phone'];
        $existing_image_path = $row['image_path'];

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $role = $_POST['role'];
            $bio = $_POST['bio'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];

            if ($_FILES['image']['name']) {
                $image_path = 'uploads/members/' . basename($_FILES['image']['name']);
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

            $sql_update = "UPDATE members SET name = '$name', role = '$role', bio = '$bio', email = '$email', phone = '$phone', image_path = '$image_path' WHERE id = '$id'";

            if ($conn->query($sql_update)) {
                header('Location: admin_panel.php?message=updated');
                exit();
            } else {
                echo "Error updating member: " . $conn->error;
            }
        }
    } else {
        echo "Member not found.";
    }
} else {
    echo "No member ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member</title>
</head>
<body>
    <h1>Edit Member</h1>

    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($existing_name) ?>" required><br><br>

        <label for="role">Role:</label>
        <input type="text" name="role" value="<?= htmlspecialchars($existing_role) ?>" required><br><br>

        <label for="bio">Bio:</label>
        <textarea name="bio" required><?= htmlspecialchars($existing_bio) ?></textarea><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($existing_email) ?>" required><br><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?= htmlspecialchars($existing_phone) ?>" required><br><br>

        <label for="image">Image (leave blank to keep current image):</label>
        <input type="file" name="image"><br><br>

        <?php if (!empty($existing_image_path) && file_exists($existing_image_path)): ?>
            <img src="<?= $existing_image_path ?>" alt="Current Image" width="200"><br><br>
        <?php else: ?>
            <p>No image available</p>
        <?php endif; ?>

        <button type="submit">Update Member</button>
    </form>
</body>
</html>
