<?php
require_once __DIR__ . '/../database/dbconnection.php';
require_once __DIR__ . '/../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['btn-create-room'])) {
    $admin = new ADMIN();
    $name = $_POST['name'];
    $description = $_POST['description'];
    $imageUrl = $_POST['imageUrl'];
    $price = $_POST['price'];
    $reserved = false;

    $stmt = $admin->runQuery('INSERT INTO rooms (name, description, imageUrl, price, reserved) VALUES (:name, :description, :imageUrl, :price, :reserved)');

    $stmt->execute([':name' => $name, ':description' => $description, ':imageUrl' => $imageUrl, ':price' => $price, ':reserved' => $reserved]);

    header('Location: ../rooms/index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
    <link rel="stylesheet" href="../output.css">
</head>

<body>
    <header class="px-10 py-2 bg-header flex justify-between items-center">
        <span class="flex gap-2 items-center">
            <img class="object-contain" src="../src/images/logo.png" alt="logo">
            <h1 class="text-3xl font-bold font-accent">ComfyCorners</h1>
        </span>
        <nav class="flex items-center font-regular gap-16 font-medium text-lg">
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded" href="../rooms">Rooms</a>
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded"
                href="../reservation">Reservation</a>
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded" href="../about">About</a>
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
                <p onclick="setting()" class="cursor-pointer text-center text-nowrap">Setting</p>
                <p onclick="signOut()" class="cursor-pointer mt-2 text-red-500 text-center text-nowrap">Sign out</p>

            </div>
        </div>
    </header>

    <!-- Content -->

    <section class="container  w-full h-screen">
        <h1 class="w-full text-3xl font-bold">Create Room</h1>

        <div class=" mt-5 max-w-[500px]">
            <form class=" space-y-4" action="" method="POST">
                <div class="flex flex-col gap-2">
                    <label class="font-medium" for="name">Room Name</label>
                    <input class=" text-black border border-gray-300 rounded-md p-2" type="text" name="name" id="name"
                        placeholder="Enter Room Name" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-medium" for="description">Description</label>
                    <textarea class=" text-black border border-gray-300 rounded-md px-2 py-1" cols="30" type="text"
                        name="description" id="description" placeholder="Enter Room Description" required></textarea>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-medium" for="imageUrl">Image Url</label>
                    <input class=" text-black border border-gray-300 rounded-md p-2" type="text" name="imageUrl"
                        id="imageUrl" placeholder="Enter Room Image Url" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-medium" for="price">Your Pricing</label>
                    <input class=" text-black border border-gray-300 rounded-md p-2" type="number" name="price"
                        id="name" placeholder="Enter Room Price" required>
                </div>
                <button name="btn-create-room" class="bg-green-600 text-white px-5 py-2 rounded-md"
                    type="submit">Create</button>
            </form>
        </div>
    </section>
    <script>
        // Header stuff
        function toggleUserPopover() {
            const popover = document.getElementById('popoverContent');

            if (popover.classList.contains('hidden')) {
                // Add animation class and show
                popover.classList.add('animate-fade');
                popover.classList.remove('hidden');
            } else {
                // Hide popover
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