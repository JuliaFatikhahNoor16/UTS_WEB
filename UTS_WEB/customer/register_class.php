<?php
// register_class
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

// Proses pendaftaran kelas
if(isset($_POST['register_class'])) {
    $class_id = $_POST['class_id'];
    
    // Tambahkan kelas ke customer
    if(!in_array($class_id, $_SESSION['customer_classes'][$_SESSION['user']])) {
        $_SESSION['customer_classes'][$_SESSION['user']][] = $class_id;
    }
    
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for Class</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Register for Pottery Class</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="register_class.php">Register for Class</a></li>
                <li><a href="order_product.php">Order Products</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Available Classes</h2>
        
        <form method="post">
            <div class="class-options">
                <?php foreach($_SESSION['classes'] as $class): ?>
                <div class="class-card">
                    <input type="radio" name="class_id" value="<?php echo $class['id']; ?>" id="class_<?php echo $class['id']; ?>">
                    <label for="class_<?php echo $class['id']; ?>">
                        <h3><?php echo $class['name']; ?></h3>
                        <p>Instructor: <?php echo $class['instructor']; ?></p>
                        <p>Schedule: <?php echo $class['schedule']; ?></p>
                        <p>Price: $<?php echo number_format($class['price'], 2); ?></p>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="submit" name="register_class">Register</button>
        </form>
    </main>
</body>
</html>