<?php
// Start the session and include the database connection file
session_start();
include('db_connection.php');

// Define error and success messages
$error_message = '';
$success_message = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form input data to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $services = mysqli_real_escape_string($conn, $_POST['services']);

    // Validate required fields
    if (empty($name) || empty($contact) || empty($email) || empty($services)) {
        $error_message = 'Please fill in all fields.';
    } else {
        // Insert the form data into the contacts table
        $sql = "INSERT INTO contacts (name, contact, email, services) 
                VALUES ('$name', '$contact', '$email', '$services')";

        if (mysqli_query($conn, $sql)) {
            $success_message = 'Your message has been sent successfully. Thank you!';
        } else {
            $error_message = 'Error: ' . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeless Memories Photography - Contact</title>
    <style>
        /* Include your CSS styles here or link to an external stylesheet */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .section {
            padding: 20px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .contact-form button {
            background-color: #005e8c;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .contact-form button:hover {
            background-color: #003366;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Timeless Memories Photography</h1>
        <p>Capturing Moments That Last Forever</p>
    </header>

    <!-- Contact Section -->
    <div class="section" id="contact">
        <h2>Contact Us</h2>

        <!-- Display Error or Success Message -->
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php elseif ($success_message): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form class="contact-form" action="contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="tel" name="contact" placeholder="Your Contact Number" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="services" placeholder="What services are you looking for?" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Timeless Memories Photography. All rights reserved.</p>
    </footer>

</body>
</html>
