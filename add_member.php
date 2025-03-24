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
    $name = $_POST['name'];
    $role = $_POST['role'];
    $bio = $_POST['bio'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

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
            $upload_dir = 'uploads/members/';
            $image_path = $upload_dir . basename($image_name);

            // Ensure the directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Move uploaded image to the desired directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Insert data into the members table
                $sql = "INSERT INTO members (name, role, bio, email, phone, image_path, created_at) 
                        VALUES ('$name', '$role', '$bio', '$email', '$phone', '$image_path', NOW())";
                
                if ($conn->query($sql) === TRUE) {
                    echo "New member added successfully.";
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
    <title>Add Member</title>
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

        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 20px;
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
    <h2>Add New Member</h2>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required>

        <label for="bio">Bio:</label>
        <textarea name="bio" id="bio" rows="4" required></textarea>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" required>

        <input type="submit" value="Add Member">
    </form>
</div>

</body>
</html>
