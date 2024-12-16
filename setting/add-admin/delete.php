<?php
require_once '../../database/dbconnection.php';

$id = $_GET['id'];

$database = new Database();
$conn = $database->dbConnection();

$query = "DELETE FROM admins WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    header('Location: index.php');
    exit();
} else {
    echo "Error deleting admin.";
}
?>