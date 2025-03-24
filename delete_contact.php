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

    // Delete the contact from the database
    $sql_delete = "DELETE FROM contacts WHERE id = '$id'";

    if ($conn->query($sql_delete)) {
        header('Location: admin_panel.php?message=deleted');
        exit();
    } else {
        echo "Error deleting contact: " . $conn->error;
    }
} else {
    echo "Error: No contact ID specified.";
}
?>
