<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'artisan') {
    header('Location: ../login.php');
    exit();
}

// Simulasi data kelas yang diajarkan oleh pengrajin ini
$my_classes = [];
foreach($_SESSION['classes'] as $class) {
    if($class['instructor'] == $_SESSION['name']) {
        $my_classes[] = $class;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Artisan Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Artisan Dashboard</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="manage_classes.php">Manage Classes</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Welcome, <?php echo $_SESSION['name']; ?> (Artisan)</h2>
        
        <section class="my-classes">
            <h3>My Classes</h3>
            <?php if(empty($my_classes)): ?>
                <p>You don't have any classes scheduled yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach($my_classes as $class): ?>
                    <li>
                        <strong><?php echo $class['name']; ?></strong>
                        <br>Schedule: <?php echo $class['schedule']; ?>
                        <br>Price: $<?php echo number_format($class['price'], 2); ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>