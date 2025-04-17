<?php
// dashboard
include 'header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Welcome, <?php echo $_SESSION['name']; ?> (Admin)</h2>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Customers</h3>
                <p><?php echo isset($_SESSION['customers']) ? count($_SESSION['customers']) : 0; ?></p>
            </div>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
