<?php
session_start();
include('db_connection.php');

// Fetch all members
$sql = "SELECT * FROM members";  // Using members instead of team
$result = $conn->query($sql);

// Fetch portfolio items
$portfolio_sql = "SELECT * FROM portfolio";
$portfolio_result = $conn->query($portfolio_sql);

// Fetch gallery items
$gallery_sql = "SELECT * FROM gallery";
$gallery_result = $conn->query($gallery_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timeless Memories Photography</title>

    <!-- External Lightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Header and Navigation */
        header {
            background-color: #003366;
            color: white;
            padding: 30px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        nav {
            background-color: #005e8c;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-weight: 500;
            text-transform: uppercase;
            display: inline-block;
        }

        nav a:hover {
            background-color: #f8c846;
            color: #003366;
            border-radius: 5px;
        }

       /* Portfolio Section */
#portfolio {
    background-color: #ffffff;
    padding: 40px 20px;
}

.portfolio {
    display: grid;
    grid-template-columns: repeat(4, 1fr);  /* Four items per row */
    gap: 20px;
    padding: 10px;
}

.portfolio-item {
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
    max-width: 250px; /* Smaller portfolio box */
    margin: 0 auto;
}

.portfolio-item img {
    width: 100%;
    height: 150px; /* Fixed height to make the box smaller */
    object-fit: cover;
    border-bottom: 2px solid #ddd;
}

.portfolio-item h3 {
    margin: 10px;
    font-size: 1.2rem;
    color: #003366;
}

.portfolio-item p {
    margin: 0 10px 15px;
    color: #666;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .portfolio {
        grid-template-columns: repeat(2, 1fr); /* Two items per row on smaller screens */
    }
}

@media (max-width: 480px) {
    .portfolio {
        grid-template-columns: 1fr; /* One item per row on very small screens */
    }
}


       /* Gallery Section */
#gallery {
    background-color: #ffffff;
    padding: 40px 20px;
    margin-bottom: 40px;
}

.gallery-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    padding: 10px;
}

.gallery-item {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: white;
}

.gallery-item img {
    width: 100%;  /* Ensures the image stretches to fill the width of the container */
    height: 200px; /* Fixed height */
    object-fit: cover; /* Ensures the image covers the area while maintaining its aspect ratio */
}


       /* Members Section */
#members {
    background-color: #ffffff;
    padding: 40px 20px;
    margin-bottom: 40px;
}

.members-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Four members per row */
    gap: 20px;
    padding: 10px;
}

.member-item {
    background-color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    text-align: center;
    margin: 10px;
    width: 200px; /* Set a fixed width for the member container */
    margin: 0 auto; /* Center the members */
}

.member-item img {
    width: 100%; /* Ensure the image fills the width of the container */
    height: 200px; /* Set a fixed height */
    object-fit: cover; /* Maintain aspect ratio and cover the space */
    border-bottom: 2px solid #ddd;
}

.member-item h3 {
    margin: 10px;
    font-size: 1.2rem;
    color: #003366;
}

.member-item p {
    margin: 0 10px 15px;
    color: #666;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .members-container {
        grid-template-columns: repeat(2, 1fr); /* Two members per row on smaller screens */
    }
}

@media (max-width: 480px) {
    .members-container {
        grid-template-columns: 1fr; /* One member per row on very small screens */
    }
}



        /* Services Section */
        #services {
            background-color: #ffffff;
            padding: 40px 20px;
            margin-bottom: 40px;
        }

        .service-item {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            margin: 10px;
            padding: 20px;
        }

        .service-item h3 {
            font-size: 1.5rem;
            color: #003366;
            margin-bottom: 15px;
        }

        .service-item p {
            color: #666;
        }

        /* Contact Section */
        #contact {
            background-color: #f7f7f7;
            padding: 40px 20px;
            margin-bottom: 40px;
        }

        #contact h2 {
            font-size: 2rem;
            color: #003366;
            text-align: center;
            margin-bottom: 20px;
        }

        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f7f7f7;
        }

        .contact-form button {
            background-color: #005e8c;
            color: white;
            font-size: 1.2rem;
            padding: 15px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .contact-form button:hover {
            background-color: #003366;
        }

        /* Experience Section */
#experience {
    background-color: #ffffff;
    padding: 40px 20px;
    margin-bottom: 40px;
}

#experience h2 {
    font-size: 2rem;
    color: #003366;
    text-align: center;
    margin-bottom: 20px;
}

.experience-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    padding: 10px;
}

.experience-item {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.experience-item h3 {
    font-size: 1.5rem;
    color: #003366;
    margin-bottom: 10px;
}

.experience-item p {
    color: #666;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 20px;
}

.experience-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    #experience h2 {
        font-size: 1.5rem;
    }

    .experience-container {
        grid-template-columns: 1fr;
    }

    .experience-item {
        padding: 15px;
    }
}


        /* Footer */
        footer {
            background-color: #003366;
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <!-- Header & Navigation Bar -->
    <header>
        <h1>Timeless Memories Photography</h1>
        <p>Capturing Moments That Last Forever</p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="#portfolio">Portfolio</a>
        <a href="#gallery">Gallery</a>
        <a href="#members">Our Members</a>
        <a href="#services">Services</a>
        <a href="#contact">Contact</a>
        <?php if (isset($_SESSION['admin_id'])) { ?>
            <a href="admin_panel.php" class="admin-btn">Admin Panel</a>
        <?php } else { ?>
            <a href="login.php" class="admin-btn">Admin Login</a>
        <?php } ?>
    </nav>

    <!-- Portfolio Section -->
    <div class="section" id="portfolio">
        <h2>Our Portfolio</h2>
        <div class="portfolio">
            <?php
            if ($portfolio_result->num_rows > 0) {
                while ($row = $portfolio_result->fetch_assoc()) {
                    echo '<div class="portfolio-item">';
                    echo '<a href="' . $row['image_path'] . '" data-lightbox="portfolio-gallery" data-title="' . $row['title'] . '">';
                    echo '<img src="' . $row['image_path'] . '" alt="' . $row['title'] . '">';
                    echo '</a>';
                    echo '<h3>' . $row['title'] . '</h3>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo "No portfolio items found.";
            }
            ?>
        </div>
    </div>
<!-- Gallery Section -->
<!-- Gallery Section -->
<div class="section" id="gallery">
    <h2>Gallery</h2>
    
    <!-- Category Buttons (Filter) -->
    <div class="category-buttons">
        <button class="category-btn" data-category="all">All</button>
        <button class="category-btn" data-category="portrait">Portrait</button>
        <button class="category-btn" data-category="wedding">Wedding</button>
        <button class="category-btn" data-category="birthdays">Birthdays</button>
        <button class="category-btn" data-category="ceremonies">Ceremonies</button>
    </div>

    <div class="gallery-container">
        <?php
        if ($gallery_result->num_rows > 0) {
            while ($row = $gallery_result->fetch_assoc()) {
                echo '<div class="gallery-item" data-category="' . $row['category'] . '">';
                echo '<a href="' . $row['image_path'] . '" data-lightbox="gallery-gallery">';
                echo '<img src="' . $row['image_path'] . '" alt="Gallery Image">';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo "No gallery items found.";
        }
        ?>
    </div>
</div>


    <!-- Members Section -->
<div class="section" id="members">
    <h2>Our Members</h2>
    <div class="members-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Displaying member information
                echo '<div class="member-item">';
                // Using image_path instead of image
                echo '<img src="' . $row['image_path'] . '" alt="' . $row['name'] . '">';  // Changed 'image' to 'image_path'
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['role'] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No members found.";
        }
        ?>
    </div>
</div>

<!-- Experience Section -->
<div class="section" id="experience">
    <h2>Our Experience</h2>
    <div class="experience-container">
        <div class="experience-item">
            <h3>Timeless Memories Photography</h3>
            <p>With over 10 years of experience in the photography industry, Timeless Memories has been capturing moments that last forever. We specialize in wedding photography, portraits, events, and more. Our team is passionate about making every shot meaningful, whether it’s a big celebration or a quiet, intimate moment.</p>
        </div>
        <div class="experience-item">
            <h3>Our Journey</h3>
            <p>We began as a small team with a shared love for photography and storytelling. Over the years, we've expanded our services and honed our skills, gaining recognition for our high-quality work. From capturing candid moments to organizing large-scale shoots, we pride ourselves on our attention to detail and creative vision.</p>
        </div>
        <div class="experience-item">
            <h3>Why Choose Us</h3>
            <p>At Timeless Memories, we don't just take photos; we create timeless memories. We understand the importance of every shot, ensuring that each photograph is a work of art. Our professional photographers are not just skilled, but they also have a genuine passion for capturing real emotions and beautiful moments.</p>
        </div>
    </div>
</div>

    <!-- Services Section -->
    <div class="section" id="services">
        <h2>Our Services</h2>
        <div class="services-container">
            <div class="service-item">
                <h3>Photography</h3>
                <p>We capture beautiful moments that last forever.</p>
            </div>
            <div class="service-item">
                <h3>Videography</h3>
                <p>Our videography team ensures every event is recorded beautifully.</p>
            </div>
            <div class="service-item">
                <h3>Event Coverage</h3>
                <p>We provide comprehensive event coverage from start to finish.</p>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="section" id="contact">
        <h2>Contact Us</h2>
        <div class="contact-form">
            <form action="submit_contact.php" method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Timeless Memories Photography. All rights reserved.</p>
    </footer>

    <!-- External Lightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>

    <script>
        // Filter gallery by category
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function () {
                const category = this.getAttribute('data-category');
                document.querySelectorAll('.gallery-item').forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html> 

