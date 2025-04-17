<!DOCTYPE html>
<html>
<head>
    <title>Pottery Studio - Register</title>
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
    <div class="register-container">
        <div class="register-title">Create Your Account</div>
        
        <form method="post">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" placeholder="Your full name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" placeholder="Your email address" required>
            </div>
            <div class="form-group">
                <label>Phone Number:</label>
                <input type="tel" name="phone" placeholder="Your phone number" required>
            </div>
            <button type="submit" name="register" class="register-btn">Register</button>
        </form>
        
        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>