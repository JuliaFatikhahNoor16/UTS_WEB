<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pottery Studio - Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <img src="img/logo.png" alt="Pottery Studio Logo" class="logo-img">
            <h1>Welcome to Pottery Studio</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <li><a href="admin/dashboard.php">Admin Dashboard</a></li>
                    <?php elseif($_SESSION['role'] == 'customer'): ?>
                        <li><a href="customer/dashboard.php">My Dashboard</a></li>
                    <?php elseif($_SESSION['role'] == 'artisan'): ?>
                        <li><a href="artisan/dashboard.php">Artisan Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
    
<main>
    <section class="hero">
        <div class="hero-content">
            <h2>Discover the Art of Pottery</h2>
            <p>Join our classes or shop unique handmade pottery items</p>
        </div>
    </section>
    
    <section class="features">
        <div class="feature">
            <div class="feature-image">
                <img src="img/pottery class.jpg" alt="Pottery Class">
            </div>
            <div class="feature-content">
                <h3>Classes</h3>
                <p>Learn pottery from our skilled artisans</p>
                <?php if(isset($_SESSION['user']) && $_SESSION['role'] == 'customer'): ?>
                    <a href="customer/register_class.php" class="btn">Register Now</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="feature">
            <div class="feature-image">
                <img src="img/products.jpg" alt="Pottery Products">
            </div>
            <div class="feature-content">
                <h3>Products</h3>
                <p>Shop our unique pottery collection</p>
                <a href="manage_products.php" class="btn">Browse Collection</a>
            </div>
        </div>
        
        <div class="feature">
            <div class="feature-image">
                <img src="img/ya.jpg" alt="Pottery Workshop">
            </div>
            <div class="feature-content">
                <h3>Workshop</h3>
                <p>Book our studio for your creative projects</p>
                <a href="workshop.php" class="btn">Book Now</a>
            </div>
        </div>
    </section>
</main>
    
    <footer>
        <p>&copy; 2023 Pottery Studio. All rights reserved.</p>
    </footer>
</body>
</html>