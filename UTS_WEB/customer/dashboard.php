<?php
// dashboard
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'customer') {
    header('Location: ../login.php');
    exit();
}

// Simulasi data kelas (tanpa database)
if(!isset($_SESSION['classes'])) {
    $_SESSION['classes'] = [
        [
            'id' => 1,
            'name' => 'Beginner Pottery',
            'instructor' => 'Jane Smith',
            'schedule' => 'Every Monday, 6-8 PM',
            'price' => 120.00
        ],
        [
            'id' => 2,
            'name' => 'Advanced Wheel Throwing',
            'instructor' => 'John Doe',
            'schedule' => 'Every Wednesday, 6-8 PM',
            'price' => 150.00
        ]
    ];
}

// Simulasi data registrasi kelas customer
if(!isset($_SESSION['customer_classes'][$_SESSION['user']])) {
    $_SESSION['customer_classes'][$_SESSION['user']] = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Customer Dashboard</h1>
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
        <h2>Welcome, <?php echo $_SESSION['name']; ?></h2>
        
        <section class="my-classes">
            <h3>My Registered Classes</h3>
            <?php if(empty($_SESSION['customer_classes'][$_SESSION['user']])): ?>
                <p>You haven't registered for any classes yet.</p>
            <?php else: ?>
                <ul>
                    <?php foreach($_SESSION['customer_classes'][$_SESSION['user']] as $class_id): 
                        $class = null;
                        foreach($_SESSION['classes'] as $c) {
                            if($c['id'] == $class_id) {
                                $class = $c;
                                break;
                            }
                        }
                        if($class): ?>
                        <li>
                            <strong><?php echo $class['name']; ?></strong> with <?php echo $class['instructor']; ?>
                            <br>Schedule: <?php echo $class['schedule']; ?>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>