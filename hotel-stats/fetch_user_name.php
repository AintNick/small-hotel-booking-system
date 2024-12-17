<?php
// Include the necessary files
require_once __DIR__ . '/../database/dbconnection.php';
require_once __DIR__ . '/../dashboard/admin/authentication/admin-class.php';

// Instantiate the ADMIN class
$admin = new ADMIN();

// Get the userId from the URL parameter
$userId = isset($_GET['userId']) ? (int) $_GET['userId'] : 0;

if ($userId > 0) {
    try {
        // Run the query to fetch the user's name based on the userId
        $stmt = $admin->runQuery("SELECT username FROM user WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and output the result
        if ($user) {
            echo $user['username']; // Return the user's name
        } else {
            echo 'User not found'; // User does not exist
        }
    } catch (PDOException $e) {
        // Error handling
        echo 'Database error: ' . $e->getMessage();
    }
} else {
    // Invalid user ID
    echo 'Invalid user ID';
}
?>