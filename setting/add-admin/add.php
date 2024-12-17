<?php
require_once '../../database/dbconnection.php';
require_once __DIR__ . '/../../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");
$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $database = new Database();
    $conn = $database->dbConnection();

    try {
        // Start a transaction
        $conn->beginTransaction();

        // Insert into admins table
        $query = "INSERT INTO admins (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Update isAdmin in the user table
        $updateQuery = "UPDATE user SET isAdmin = 1 WHERE email = :email";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bindParam(':email', $email);
        $updateStmt->execute();

        // Commit the transaction
        $conn->commit();

        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        // Rollback in case of error
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Add New Admin</h2>
        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Admin</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

</body>

</html>