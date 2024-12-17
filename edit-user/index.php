<?php
require_once '../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");

    $stmt = $admin->runQuery("SELECT username, age, address, contact_number, isAdmin FROM user WHERE id = :id");
    $stmt->execute(array(":id" => $_SESSION['adminSession']));
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-update-user'])) {
        $updated_username = $_POST['username'];
        $updated_age = $_POST['age'];
        $updated_address = $_POST['address'];
        $updated_contact_number = $_POST['contact_number'];

        $stmt = $admin->runQuery("UPDATE user SET username = :username, age = :age, address = :address, contact_number = :contact_number WHERE id = :id");
        $stmt->execute(array(
            ":username" => $updated_username,
            ":age" => $updated_age,
            ":address" => $updated_address,
            ":contact_number" => $updated_contact_number,
            ":id" => $_SESSION['adminSession']
        ));

        $user_data['username'] = $updated_username;
        $user_data['age'] = $updated_age;
        $user_data['address'] = $updated_address;
        $user_data['contact_number'] = $updated_contact_number;

        $success = "User information updated successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Info</title>
    <link rel="stylesheet" href="../output.css">
</head>

<body>
    <header class="px-10 py-2 bg-header flex justify-between items-center">
        <span class="flex gap-2 items-center">
            <img class="object-contain" src="../src/images/logo.png" alt="logo">
            <h1 class="text-3xl font-bold font-accent">ComfyCorners</h1>
        </span>
        <nav class="flex items-center font-regular gap-16 font-medium text-lg">
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded" href="#">Rooms</a>
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded"
                href="../reservation">Reservation</a>
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded" href="#">About</a>
        </nav>
        <div class="relative size-fit">
            <!-- Trigger Image -->
            <div onclick="toggleUserPopover()" class="bg-white size-10 cursor-pointer rounded-full">
                <img src="../src/images/user-placeholder.svg" alt="user">
            </div>

             <!-- Pop-over Content -->
             <div id="popoverContent"
                class="absolute left-1/2 transform -translate-x-1/2 mt-2 hidden bg-background border border-gray-300 rounded-lg shadow-lg z-10 px-4 py-2 h-fit space-y-2">
                <?php if ($user_data['isAdmin'] == true): ?>
                    <p onclick="addRoom()" class="cursor-pointer text-nowrap text-center">Add Room</p>
                <?php endif; ?>
                <?php if ($user_data['isAdmin'] == true): ?>
                    <p onclick="manageUsers()" class="cursor-pointer text-nowrap text-center">Users</p>
                <?php endif; ?>
                <p onclick="editUser()" class="cursor-pointer text-center text-nowrap">User Profile</p>
                <p onclick="setting()" class="cursor-pointer text-center text-nowrap">Setting</p>
                <p onclick="signOut()" class="cursor-pointer mt-2 text-red-500 text-center text-nowrap">Sign out</p>

            </div>
        </div>
    </header>

    <section class="container mt-5 max-w-[500px]">
        <h1 class="text-2xl font-bold mb-3">Edit Your Information</h1>

        <?php if (isset($error)): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-2">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif (isset($success)): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-2">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div class="flex flex-col gap-2">
                <label for="username" class="font-medium">Username</label>
                <input type="text" name="username" id="username" class="border p-2" required 
                       value="<?= htmlspecialchars($user_data['username'] ?? '') ?>">
            </div>
            <div class="flex flex-col gap-2">
                <label for="age" class="font-medium">Age</label>
                <input type="number" name="age" id="age" class="border p-2" required 
                       value="<?= htmlspecialchars($user_data['age'] ?? '') ?>">
            </div>
            <div class="flex flex-col gap-2">
                <label for="address" class="font-medium">Address</label>
                <input type="text" name="address" id="address" class="border p-2" required 
                       value="<?= htmlspecialchars($user_data['address'] ?? '') ?>">
            </div>
            <div class="flex flex-col gap-2">
                <label for="contact_number" class="font-medium">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" class="border p-2" required 
                       value="<?= htmlspecialchars($user_data['contact_number'] ?? '') ?>">
            </div>
            <div class="flex flex-col gap-2">
            <button type="submit" name="btn-update-user" 
            class="bg-blue-600 text-white py-2 rounded"
            style="width: 170px; background-color: #4CAF50;"> Update Information </button>
            </div>
        </form>
    </section>

 <!-- Content -->

 <script>
        function toggleUserPopover() {
            const popover = document.getElementById('popoverContent');

            if (popover.classList.contains('hidden')) {
              
                popover.classList.add('animate-fade');
                popover.classList.remove('hidden');
            } else {
                
                popover.classList.add('hidden');
                popover.classList.remove('animate-fade');
            }
        }

        function addRoom() {
            window.location.href = "../create-room";
        }

        function manageUsers() {
            window.location.href = "../users";
        }

        function editUser() {
        window.location.href = "../edit-user";
        }

        function setting() {
            window.location.href = "../setting";
        }

        function signOut() {
            if (confirm("Are you sure you want to sign out?")) {
                window.location.href = "../dashboard/admin/authentication/admin-class.php?admin_signout";
            }
        }
    </script>
</body>

</html>