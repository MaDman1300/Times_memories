<?php
session_start();
include('db_connection.php');

// Redirect to login page if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch data for each section
$sql_portfolio = "SELECT * FROM portfolio ORDER BY created_at DESC";
$result_portfolio = $conn->query($sql_portfolio);

$sql_experience = "SELECT * FROM skillsexperience ORDER BY created_at DESC";
$result_experience = $conn->query($sql_experience);

$sql_gallery = "SELECT * FROM gallery ORDER BY created_at DESC";
$result_gallery = $conn->query($sql_gallery);

$sql_services = "SELECT * FROM services ORDER BY created_at DESC";
$result_services = $conn->query($sql_services);

$sql_members = "SELECT * FROM members ORDER BY created_at DESC";
$result_members = $conn->query($sql_members);

$sql_contacts = "SELECT * FROM contacts ORDER BY created_at DESC";
$result_contacts = $conn->query($sql_contacts);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Timeless Memories Photography</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .admin-container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 32px;
            color: #444;
            margin-bottom: 20px;
        }

        /* Section Styles */
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 26px;
            color: #444;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        /* Button Styles */
        .btn {
            background-color: #333;
            color: #fff;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #444;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Action Button Styles */
        .action-btn {
            background-color: #d9534f;
            color: #fff;
            padding: 6px 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .action-btn:hover {
            background-color: #c9302c;
        }

        /* Media Queries for Responsiveness */
        @media (max-width: 768px) {
            .admin-container {
                width: 95%;
            }
            h1 {
                font-size: 28px;
            }
            .section-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="admin-container">
    <h1>Admin Panel</h1>

    <!-- Portfolio Section -->
    <div class="section">
        <h2 class="section-title">Manage Portfolio</h2>
        <a href="add_portfolio.php" class="btn">Add New Portfolio Item</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_portfolio->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Portfolio Image" width="100"></td>
                        <td>
                            <a href="edit_portfolio.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                            <a href="delete_portfolio.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Experience Section -->
    <div class="section">
        <h2 class="section-title">Manage Experience</h2>
        <a href="add_experience.php" class="btn">Add New Experience</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_experience->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>
                            <a href="edit_experience.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                            <a href="delete_experience.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Gallery Section -->
    <div class="section">
        <h2 class="section-title">Manage Gallery</h2>
        <a href="add_gallery.php" class="btn">Add New Gallery Image</a>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_gallery->fetch_assoc()) { ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($row['image_path']) ?>" alt="Gallery Image" width="100"></td>
                        <td>
                            <a href="edit_gallery.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                            <a href="delete_gallery.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Services Section -->
    <div class="section">
        <h2 class="section-title">Manage Services</h2>
        <a href="add_services.php" class="btn">Add New Service</a>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_services->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['cost']) ?></td>
                        <td>
                            <a href="edit_service.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                            <a href="delete_service.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Team Members Section -->
    <div class="section">
        <h2 class="section-title">Manage Team Members</h2>
        <a href="add_member.php" class="btn">Add New Team Member</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_members->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['role']) ?></td>
                        <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="Member Image" width="100"></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>
                            <a href="edit_member.php?id=<?= $row['id'] ?>" class="action-btn">Edit</a>
                            <a href="delete_member.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Contact Requests Section -->
    <div class="section">
        <h2 class="section-title">Manage Contact Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Services Requested</th>
                    <th>Submitted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_contacts->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['contact']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['services'])) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                            <a href="delete_contact.php?id=<?= $row['id'] ?>" class="action-btn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
