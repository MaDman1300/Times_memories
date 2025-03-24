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

    // Fetch the image path from the database
    $sql = "SELECT image_path FROM members WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];

        // Delete the image file from the server
        if (!empty($image_path) && file_exists($image_path)) {
            if (unlink($image_path)) {
                // Successfully deleted the image
            } else {
                echo "Error deleting image file.";
            }
        } else {
            echo "Error: Image file does not exist.";
        }

        // Delete the member from the database
        $sql_delete = "DELETE FROM members WHERE id = '$id'";

        if ($conn->query($sql_delete)) {
            header('Location: admin_panel.php?message=deleted');
            exit();
        } else {
            echo "Error deleting member: " . $conn->error;
        }
    } else {
        echo "Error: Member not found.";
    }
} else {
    echo "Error: No member ID specified.";
}
?>
