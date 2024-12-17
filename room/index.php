<?php

require_once '../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");
$id = $_GET['id'] ?? null;

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $admin->runQuery('SELECT * FROM rooms WHERE id = :id');
$stmt->execute(array(":id" => $id));
$room = $stmt->fetch(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
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
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded"
                href="../about-page">About</a>
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
                    <p onclick="setting()" class="cursor-pointer text-center text-nowrap">Setting</p><?php endif; ?>
                <p onclick="signOut()" class="cursor-pointer mt-2 text-red-500 text-center text-nowrap">Sign out</p>

            </div>
        </div>
    </header>

    <!-- Content -->

    <section class="container">
        <div class="flex gap-7 ">
            <div class="flex-1">
                <img class=" w-full" src="<?php echo $room['imageUrl'] ?>" alt="Room Image">
            </div>
            <div class="flex-1 flex justify-between flex-col">
                <div>
                    <h1 class=" text-4xl font-bold"><?php echo $room['name'] ?></h1>
                    <p class="mt-4 text-lg"><?php echo $room['description'] ?></p>
                    <div class="mt-4 space-x-4">
                        <span class="px-6 rounded-full py-1 bg-green-600 text-white"><?php echo $room['price'] ?></span>
                        <span class="px-6 rounded-full py-1 bg-yellow-600 text-white">6pm - 6am</span>
                    </div>
                    <span class="mt-4 flex gap-1"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star">
                    </span>
                </div>

                <div class="mt-auto">
                    <p>NOTE: time in and time out is 6am to 6pm</p>
                    <span class=" flex gap-4"><button onclick="bookNow()"
                            class="mt-4 px-6 py-2 bg-green-600 text-white rounded hover:animate-pulse">Book
                            Now!!</button><?php if ($user_data['isAdmin'] == true): ?>
                            <a href="../edit-room?id=<?php echo $id; ?>"
                                class="mt-4 px-6 py-2 bg-yellow-600 text-white rounded hover:animate-pulse">Edit
                                Room</a>
                        <?php endif; ?></span>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="w-full mt-10">
            <h1 class="w-full text-3xl font-bold">Comments</h1>
            <div class="w-full mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class=" min-w-[300px] max-w-[500px] py-4 px-5 rounded bg-[#572f2a] ">
                    <h5 class="font-bold text-lg">Timothyty.</h5>
                    <p class=" line-clamp-3 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus,
                        quidem et!</p>
                    <span class="mt-4 flex gap-1"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star">
                    </span>
                </div>

                <div class=" min-w-[300px] max-w-[500px] py-4 px-5 rounded bg-[#572f2a] ">
                    <h5 class="font-bold text-lg">Timothyty.</h5>
                    <p class=" line-clamp-3 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus,
                        quidem et!</p>
                    <span class="mt-4 flex gap-1"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star">
                    </span>
                </div>

                <div class=" min-w-[300px] max-w-[500px] py-4 px-5 rounded bg-[#572f2a] ">
                    <h5 class="font-bold text-lg">Timothyty.</h5>
                    <p class=" line-clamp-3 mt-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus,
                        quidem et!</p>
                    <span class="mt-4 flex gap-1"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star"><img
                            src="../src/images/star.svg" alt="star"><img src="../src/images/star.svg" alt="star">
                    </span>
                </div>
            </div>
        </div>
    </section>

    <script>
        function bookNow() {
            window.location.href = "../booking?id=<?php echo $room['id'] ?>";
        }


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
            window.location.href = "../setting/add-admin/index.php";
        }

        function signOut() {
            if (confirm("Are you sure you want to sign out?")) {
                window.location.href = "../dashboard/admin/authentication/admin-class.php?admin_signout";
            }
        }
    </script>
</body>

</html>