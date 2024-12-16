<?php
// Start the session to check user login status
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
    // If the user is not an admin, display an error message and stop execution
    echo "You do not have permission to perform this action.";
    exit(); // Stop further execution of the script
}

// Fetch the ID from the query string
$id = isset($_GET['id']) ? $_GET['id'] : null;

// If no ID is provided, show an error and stop execution
if ($id === null) {
    echo "Error: ID is required.";  // Display an error message
    exit(); // Stop further execution of the script
}

// Connect to the database
require_once '../dashboard/admin/authentication/admin-class.php';
$database = new Database();
$conn = $database->dbConnection();

// SQL query to delete an admin by ID
$query = "DELETE FROM admins WHERE id = :id"; // Ensure 'admins' is the correct table name
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);

// Check for deletion confirmation
if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
    try {
        // Execute the deletion query
        if ($stmt->execute()) {
            echo "Admin deleted successfully.";
            // Optionally redirect to the admin list page
            header('Location: index.php');
            exit();
        } else {
            echo "Error deleting admin.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// HTML and JS for confirmation button
echo '<script>
    function confirmDelete() {
        var userConfirmation = confirm("Are you sure you want to delete this admin?");
        if (userConfirmation) {
            window.location.href = "delete-admin.php?id=' . $id . '&confirm=true";  // Reload with confirm query parameter
        }
    }
</script>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your external CSS here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        .action-btn {
            background-color: #ef4a59;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }

        .action-btn:hover {
            background-color: #e3404f;
        }

        .delete-btn {
            text-align: right;
        }

        .delete-btn button {
            background-color: #ff3333;
            color: white;
            border: none;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }

        .delete-btn button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin List</h2>

        <!-- Admins Table -->
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>

            <!-- Fetch admins and display them in table rows -->
            <?php
            // SQL query to fetch admin data
            $stmt = $conn->prepare("SELECT id, username, email FROM admins");
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                // Show delete button on the right side
                echo "<td class='delete-btn'>
                        <button onclick='confirmDelete()'>Delete</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>
