<?php
session_start();

// Simulasi data user (tanpa database)
$users = [
    'admin' => [
        'password' => 'admin123',
        'role' => 'admin',
        'name' => 'Salsabila'
    ],
    'customer1' => [
        'password' => 'customer123',
        'role' => 'customer',
        'name' => 'Julia Fatikhah'
    ],
    'artisan1' => [
        'password' => 'artisan123',
        'role' => 'artisan',
        'name' => 'War'
    ]
];

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(isset($users[$username]) && $users[$username]['password'] == $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $users[$username]['role'];
        $_SESSION['name'] = $users[$username]['name'];
        
        // Redirect berdasarkan role
        switch($users[$username]['role']) {
            case 'admin':
                header('Location: admin/dashboard.php');
                break;
            case 'customer':
                header('Location: customer/dashboard.php');
                break;
            case 'artisan':
                header('Location: artisan/dashboard.php');
                break;
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pottery Studio - Login</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="login-container">
        <div class="login-title">Login to Pottery Studio</div>
        
        <?php if(isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            
            <button type="submit" name="login" class="login-btn">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
        
        <div class="terms">
            By logging in, you agree to our <a href="#">Terms and Services</a>
        </div>
    </div>
</body>
</html>