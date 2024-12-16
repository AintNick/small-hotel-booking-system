<?php
require_once '../../database/dbconnection.php';


$database = new Database();
$conn = $database->dbConnection();


$query = "SELECT * FROM admins";
$stmt = $conn->prepare($query);
$stmt->execute();
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Admin Panel</h2>

    <a href="add.php" class="btn btn-primary mb-3">Add New Admin</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= htmlspecialchars($admin['id']); ?></td>
                    <td><?= htmlspecialchars($admin['username']); ?></td>
                    <td><?= htmlspecialchars($admin['email']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= $admin['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $admin['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>