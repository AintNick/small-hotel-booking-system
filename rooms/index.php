<?php

require_once '../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $admin->runQuery('SELECT * FROM rooms');
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../src/css/dashboard.css">
    <link rel="stylesheet" href="../src/css/main.css">
    <link rel="stylesheet" href="../output.css">
    <link rel="shortcut icon" href="../src/images/favicon.ico" type="image/x-icon">
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

    <section class="container">
        <div>
            <h1 class="text-3xl font-regular font-bold">Rooms</h1>
            <p>Note: We offer per night only</p>
        </div>

        <!-- Room Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mt-7 justify-center">
            <?php foreach ($rooms as $room): ?>
                <a href="../room/index.php<?php echo '?id=' . $room['id']; ?>">
                    <div
                        class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText hover:rotate-3  mx-auto md:mx-0">
                        <img class="w-full" src="<?= $room['imageUrl'] ?>" alt="Sunset in the mountains">
                        <div class="px-6 py-4">
                            <div class="font-extrabold font-regular text-2xl mb-2"><?= $room['name'] ?></div>
                            <p class="text-gray-700 text-base line-clamp-3">
                                <?= $room['description'] ?>
                            </p>
                            <div class=" pt-4 pb-2">
                                <span
                                    class="bg-green-600 text-white font-regular font-medium text-base rounded-full px-5 py-1"><?= $room['price'] ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>
    </section>
    <script>
        function signOut() {
            if (confirm("Are you sure you want to sign out?")) {
                window.location.href = "../dashboard/admin/authentication/admin-class.php?admin_signout";
            }
        }

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