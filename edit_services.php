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

    // Fetch the current service details
    $sql = "SELECT * FROM services WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_title = $row['title'];
        $existing_description = $row['description'];
        $existing_cost = $row['cost'];

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $cost = $_POST['cost'];

            // Update the service in the database
            $sql_update = "UPDATE services SET title = '$title', description = '$description', cost = '$cost' WHERE id = '$id'";

            if ($conn->query($sql_update)) {
                header('Location: admin_panel.php?message=updated');
                exit();
            } else {
                echo "Error updating service: " . $conn->error;
            }
        }
    } else {
        echo "Service not found.";
    }
} else {
    echo "No service ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
</head>
<body>
    <h1>Edit Service</h1>

    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($existing_title) ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea name="description" required><?= htmlspecialchars($existing_description) ?></textarea><br><br>

        <label for="cost">Cost:</label>
        <input type="text" name="cost" value="<?= htmlspecialchars($existing_cost) ?>" required><br><br>

        <button type="submit">Update Service</button>
    </form>
</body>
</html>
