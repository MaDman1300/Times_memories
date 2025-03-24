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
    $category = $_POST['category'];  // Get category from the form

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];
        $image_error = $_FILES['image']['error'];

        // Allowed file types
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (in_array($image_extension, $allowed_extensions)) {
            // Define upload folder and move the file
            $upload_dir = 'uploads/gallery/';
            $image_path = $upload_dir . basename($image_name);

            // Ensure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Move uploaded image to the desired directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert data into the gallery table, including category and image path
                $sql = "INSERT INTO gallery (image_path, created_at, category) 
                        VALUES ('$image_path', NOW(), '$category')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "New gallery item added successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid image type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Error: No image uploaded.";
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
    <title>Add Gallery Item</title>
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

        input[type="file"], select {
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
    <h2>Add New Gallery Item</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="category">Category:</label>
        <select name="category" id="category" required>
            <option value="portrait">Portrait</option>
            <option value="wedding">Wedding</option>
            <option value="birthdays">Birthdays</option>
            <option value="ceremonies">Ceremonies</option>
        </select>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <input type="submit" value="Add Gallery Item">
    </form>
</div>

</body>
</html>
