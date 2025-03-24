<?php
// Replace 'password123' with your desired password
$plainPassword = 'password123';

// Hash the password
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

echo "Hashed password: " . $hashedPassword;
?>
