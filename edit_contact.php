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

    // Fetch the current contact details
    $sql = "SELECT * FROM contacts WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existing_name = $row['name'];
        $existing_contact = $row['contact'];
        $existing_email = $row['email'];
        $existing_services = $row['services'];

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $services = $_POST['services'];

            // Update the contact in the database
            $sql_update = "UPDATE contacts SET name = '$name', contact = '$contact', email = '$email', services = '$services' WHERE id = '$id'";

            if ($conn->query($sql_update)) {
                header('Location: admin_panel.php?message=updated');
                exit();
            } else {
                echo "Error updating contact: " . $conn->error;
            }
        }
    } else {
        echo "Contact not found.";
    }
} else {
    echo "No contact ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
</head>
<body>
    <h1>Edit Contact</h1>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($existing_name) ?>" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($existing_contact) ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($existing_email) ?>" required><br><br>

        <label for="services">Services:</label>
        <textarea name="services" required><?= htmlspecialchars($existing_services) ?></textarea><br><br>

        <button type="submit">Update Contact</button>
    </form>
</body>
</html>
