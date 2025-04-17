<?php
session_start();

if(!isset($_SESSION['user']) || $_SESSION['role'] != 'artisan') {
    header('Location: ../login.php');
    exit();
}

// Proses tambah kelas baru
if(isset($_POST['add_class'])) {
    $new_id = 1;
    if(!empty($_SESSION['classes'])) {
        $ids = array_column($_SESSION['classes'], 'id');
        $new_id = max($ids) + 1;
    }
    
    $new_class = [
        'id' => $new_id,
        'name' => $_POST['name'],
        'instructor' => $_SESSION['name'],
        'schedule' => $_POST['schedule'],
        'price' => $_POST['price']
    ];
    
    $_SESSION['classes'][] = $new_class;
    header('Location: manage_classes.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Classes</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <header>
        <h1>Manage Classes</h1>
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
        <h2>Add New Class</h2>
        
        <form method="post">
            <div class="form-group">
                <label>Class Name:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Schedule:</label>
                <input type="text" name="schedule" required placeholder="e.g. Every Monday, 6-8 PM">
            </div>
            
            <div class="form-group">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" required>
            </div>
            
            <button type="submit" name="add_class">Add Class</button>
        </form>
        
        <h2>My Classes</h2>
        <?php
        $my_classes = [];
        foreach($_SESSION['classes'] as $class) {
            if($class['instructor'] == $_SESSION['name']) {
                $my_classes[] = $class;
            }
        }
        ?>
        
        <?php if(empty($my_classes)): ?>
            <p>You don't have any classes scheduled yet.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Schedule</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($my_classes as $class): ?>
                    <tr>
                        <td><?php echo $class['name']; ?></td>
                        <td><?php echo $class['schedule']; ?></td>
                        <td>$<?php echo number_format($class['price'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>