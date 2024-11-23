
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
            <h2 style="width: 100%;">Recover_Account</h2>
            <form action="dashboard/admin/authentication/admin-class.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>" >
                <input type="email" name="email" placeholder="Enter Email" required> <br>
                <button type="submit" name="btn-recover">Recover</button>
            </form>
        </div>
        <span>
           <p class="toggle-desc">Don't have a account yet? </p><a class="toggle" href="./">Sign up</a>
       </span>
    </div>      
</div>
    <script src="src/js/main.js"></script>
</body>
</html> 