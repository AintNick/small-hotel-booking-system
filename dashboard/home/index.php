<?php

require_once 'authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn();

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link rel="stylesheet" href="../../src/css/dashboard.css">
    <link rel="stylesheet" href="../../src/css/main.css">
    <link rel="shortcut icon" href="../../src/images/favicon.ico" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body  class=" bg-green-500">
    <!-- <div class="center"><h1 class="welcome">Welcome To IT ELEC 2!, <span> <?php echo $user_data['username'] ?></span></h1>
    <button><a href="authentication/admin-class.php?admin_signout" >Sign Out</a></button></div> -->
    <header>
        <img src="../../src/images/logo.png" alt="logo" >
    </header>
</body> 
</html>   