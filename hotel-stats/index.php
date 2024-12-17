<?php
require_once __DIR__ . '/../database/dbconnection.php';
require_once __DIR__ . '/../dashboard/admin/authentication/admin-class.php';

$admin = new ADMIN();
$admin->isUserLoggedIn("../");

// Pagination settings
$limit = 10; // Number of records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch sales with room details
$stmt = $admin->runQuery("
    SELECT sales.*, rooms.name AS room_name, rooms.imageUrl AS room_image
    FROM sales
    JOIN rooms ON sales.roomId = rooms.id
    ORDER BY sales.date DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total count for pagination
$countStmt = $admin->runQuery("SELECT COUNT(*) AS total FROM sales");
$countStmt->execute();
$total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($total / $limit);

// Fetch total sales
$stmt = $admin->runQuery("SELECT totalSales FROM hotel_stats WHERE id = 1");
$stmt->execute();
$hotelStats = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Log</title>
    <link rel="stylesheet" href="../output.css">
</head>

<body class="bg-[#291f1e] text-white">
    <!-- Header Section -->
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

    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #291f1e;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 10px;
            z-index: 1000;
        }

        .popup h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .popup button {
            background-color: #ef4a59;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .popup button:hover {
            background-color: #d13d46;
        }
    </style>

    <!-- Main Content -->
    <section class="container mx-auto py-10 px-4">
        <h2 class="text-2xl font-bold mb-5">Total Sales : <?php echo number_format($hotelStats['totalSales'], 2); ?>
        </h2>
        <h2 class="text-2xl font-bold mb-5">Previous Sales</h2>

        <!-- Sales Cards -->
        <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($sales as $sale): ?>
                <div class="flex flex-col bg-white text-black rounded-lg shadow-md">
                    <img class="w-full h-40 object-cover rounded-md mb-4 max-h-40 min-h-4"
                        src="<?php echo htmlspecialchars($sale['room_image']); ?>" alt="Room Image">
                    <h3 class="text-lg font-bold mb-2 px-4"><?php echo htmlspecialchars($sale['room_name']); ?></h3>
                    <p class="text-sm text-gray-700 px-4">Price: <?php echo number_format($sale['price'], 2); ?></p>
                    <p class="text-sm text-gray-700 px-4 mb-3">Date: <?php echo date('F j, Y', strtotime($sale['date'])); ?>
                    </p>
                    <button onclick="fetchUserName(<?php echo $sale['userId']; ?>)"
                        style="font-size: 0.875rem; color: black; margin-left: 1rem; margin-bottom: 0.75rem; background-color: #f7dc6f; width: fit-content; padding-left: 2rem; padding-right: 2rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 5px;">
                        View User: <?php echo $sale['userId']; ?>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-2 text-gray-900">
            <?php if ($page > 1): ?>
                <a class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    href="?page=<?php echo $page - 1; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="px-4 py-2 <?php echo $i === $page ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300'; ?> rounded"
                    href="?page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300" href="?page=<?php echo $page + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- JavaScript -->
    <script>
        function fetchUserName(userId) {
            // Send an AJAX request to fetch the user name based on userId
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `./fetch_user_name.php?userId=${userId}`, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Parse the response and display it in the popup
                    const userName = xhr.responseText;
                    showUserPopup(userName);
                }
            };
            xhr.send();
        }

        function showUserPopup(userName) {
            // Create the popup content
            const popupContent = `
            <div class="popup">
                <h2>User Name: ${userName}</h2>
                <button onclick="closePopup()">Close</button>
            </div>
        `;

            // Add the popup to the body
            document.body.insertAdjacentHTML('beforeend', popupContent);
        }

        function closePopup() {
            // Close the popup
            const popup = document.querySelector('.popup');
            popup.remove();
        }
        // Header Popover Logic
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

        function setting() {
            window.location.href = "../setting/add-admin.php";
        }

        function signOut() {
            if (confirm("Are you sure you want to sign out?")) {
                window.location.href = "../dashboard/admin/authentication/admin-class.php?admin_signout";
            }
        }
    </script>
</body>

</html>
<!-- 
git fetch origin
git checkout 16-update-isadmin -->