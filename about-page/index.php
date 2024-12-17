<?php
require_once __DIR__ . '/../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");

// Fetch user data for authentication
$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
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
            <a class="px-5 py-1 hover:bg-[#ef4a59] hover:animate-pulse transition rounded" href="../about-page">About</a>
        </nav>
        <div class="relative size-fit">
            <div onclick="toggleUserPopover()" class="bg-white size-10 cursor-pointer rounded-full">
                <img src="../src/images/user-placeholder.svg" alt="user">
            </div>
            <div id="popoverContent"
                class="absolute hidden bg-background border border-white-300 rounded-lg shadow-lg px-4 py-2 space-y-2">
                <p onclick="manageUsers()" class="cursor-pointer text-nowrap text-center">Users</p>
                <p onclick="setting()" class="cursor-pointer text-center text-nowrap">Setting</p>
                <p onclick="signOut()" class="cursor-pointer mt-2 text-red-500 text-center text-nowrap">Sign out</p>
            </div>
        </div>
    </header>

    <section class="container mx-auto mt-10 px-6">
        <h1 class="text-4xl font-bold text-center mb-8">About ComfyCorners</h1>
        <div class="max-w-4xl mx-auto text-center text-white-700">
            <p class="text-lg leading-relaxed mb-6">
                Welcome to <strong>ComfyCorners</strong>, your go-to destination for luxurious, cozy, and affordable
                accommodations.
                Whether you're planning a weekend getaway or a long-term stay, we offer a wide range of rooms designed
                to meet your unique needs.
            </p>
            <p class="text-lg leading-relaxed mb-6">
                Our mission is to provide an exceptional hospitality experience with comfort, style, and convenience.
                At ComfyCorners, we believe in making every stay a memorable one. With carefully curated interiors and
                top-notch amenities,
                you’ll feel right at home.
            </p>
        </div>

        <div class="mt-10">
            <h2 class="text-3xl font-semibold text-center mb-6">Meet Our CEO</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <img src="../src/images/businessman.jpg" alt="CEO of ComfyCorners"
                    style="max-width: 300px; width: 100%; height: auto;" class="rounded-lg shadow-md">
                <div class="text-center md:text-left">
                    <h3 class="text-2xl font-bold mb-2">John Doe</h3>
                    <p class="text-lg leading-relaxed text-white-700">
                        John Doe, the visionary CEO of ComfyCorners, brings years of experience in hospitality and a
                        passion for excellence.
                        Under his leadership, ComfyCorners has grown into a trusted name in the industry, recognized for
                        unparalleled comfort
                        and customer satisfaction. John’s commitment to innovation and personalized service ensures that
                        every guest feels valued.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="mt-10 bg-white-800 text-white text-center py-6">
        <p class="text-sm">© <?= date('Y') ?> ComfyCorners. All Rights Reserved.</p>
    </footer>

    <script>
        function toggleUserPopover() {
            const popover = document.getElementById('popoverContent');
            popover.classList.toggle('hidden');
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