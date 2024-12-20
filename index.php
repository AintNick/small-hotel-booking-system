
<?php
    include_once 'config/settings-configuration.php'
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="src/css/main.css">
    <link rel="stylesheet" href="src/css/form.css">
    <link rel="shortcut icon" href="src/images/favicon.ico" type="image/x-icon">
</head>
<body >
    <div class="container">
    <div class="center">
        <div class="form-wrapper login">
            <h2>Sign In</h2>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" >
                <input type="email" name="email" placeholder="Enter Email" required> <br>
                <input type="password" name="password" placeholder="Password" required> <br>
                <button type="submit" name="btn-signin">Sign In</button>
            </form>

            
            
        </div>  
        
        <div class="form-wrapper register">
            <h2>Register</h2>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" >
                <input type="text" name="username" placeholder="Enter Username" required> <br>
                <input type="email" name="email" placeholder="Enter Email" required> <br>
                <input type="password" name="password" placeholder="Password" required> <br>
                <button type="submit" name="btn-signup">Sign Up</button>
            </form>
        </div>
        <div>
            <span>
                <p class="toggle-desc">Don't have a account yet? </p><p class="toggle" onclick="toggleForm()">Sign up</p>
            </span>
            <a style="display: block; text-align: center; margin-top: -10px; opacity: 0.7; font-size: 0.8rem; text-decoration: underline" href="http://localhost/project-1/forgot-password.php">Forgot Password</a>
        </div>
    </div> 
</div>
    <script src="src/js/main.js"></script>
</body>
</html> 