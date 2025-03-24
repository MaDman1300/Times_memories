<?php
session_start();
include('db_connection.php');

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capture form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];

    // Insert data into the services table
    $sql = "INSERT INTO services (title, description, cost, created_at) 
            VALUES ('$title', '$description', '$cost', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "New service added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service Item</title>
    <style>
        /* Basic styles for the form */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #444;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Service</h2>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="4" required></textarea>

        <label for="cost">Cost:</label>
        <input type="number" name="cost" id="cost" required>

        <input type="submit" value="Add Service">
    </form>
</div>

</body>
</html>
