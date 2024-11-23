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
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../src/css/dashboard.css">
    <link rel="stylesheet" href="../../src/css/main.css">
    <link rel="stylesheet" href="../../output.css">
    <link rel="shortcut icon" href="../../src/images/favicon.ico" type="image/x-icon">
</head>

<body>
    <!-- <div class="center"><h1 class="welcome">Welcome To IT ELEC 2!, <span> <?php echo $user_data['username'] ?></span></h1>
    <button><a href="authentication/admin-class.php?admin_signout" >Sign Out</a></button></div> -->
    <header class="px-10 py-2 bg-header flex justify-between items-center">
        <span class=" flex gap-2 items-center"><img class="object-contain" src="../../src/images/logo.png" alt="logo">
            <h1 class="text-3xl font-bold font-accent">ComfyCorners</h1>
        </span>
        <nav class="flex items-center font-regular">
            <a href="#">Rooms</a>
            <a href="#">Reservation</a>
            <a href="#">About</a>
        </nav>
        <div class="bg-white size-10 rounded-full"><img src="../../src/images/user-placeholder.svg" alt="" srcset="">
        </div>

    </header>

    <section class="container">
        <div>
            <h1 class="text-3xl font-regular font-bold">Rooms</h1>
            <p>Note: We offer per night only</p>
        </div>

        <!-- Room Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mt-7">
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText">
                <img class="w-full" src="https://utfs.io/f/684222d9-2237-40bc-8c31-73d839a25c20-839mtx.jpg"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et
                        perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText">
                <img class="w-full" src="https://utfs.io/f/684222d9-2237-40bc-8c31-73d839a25c20-839mtx.jpg"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et
                        perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText">
                <img class="w-full" src="https://utfs.io/f/684222d9-2237-40bc-8c31-73d839a25c20-839mtx.jpg"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et
                        perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText">
                <img class="w-full" src="https://utfs.io/f/684222d9-2237-40bc-8c31-73d839a25c20-839mtx.jpg"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et
                        perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-card text-cardText">
                <img class="w-full" src="https://utfs.io/f/684222d9-2237-40bc-8c31-73d839a25c20-839mtx.jpg"
                    alt="Sunset in the mountains">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-2">The Coldest Sunset</div>
                    <p class="text-gray-700 text-base">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et
                        perferendis eaque, exercitationem praesentium nihil.
                    </p>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
                    <span
                        class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
                </div>
            </div>
        </div>
    </section>
</body>

</html>