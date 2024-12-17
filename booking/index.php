<?php

require_once '../dashboard/admin/authentication/admin-class.php';

$id = $_GET['id'] ?? null;
$admin = new ADMIN();
$admin->isUserLoggedIn("../");

$stmt = $admin->runQuery("SELECT * FROM user WHERE id = :id");
$stmt->execute(array(":id" => $_SESSION['adminSession']));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $admin->runQuery('SELECT * FROM rooms WHERE id = :id');
$stmt->execute(array(":id" => $id));
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    // If no room is found, show a default message or redirect
    $room = [
        'name' => 'Room Not Found',
        'description' => 'No details available for this room.',
    ];
}

if (isset($_POST['btn-submit'])) {
    $roomId = $room['id'];
    $userId = $user_data["id"];
    $date = $_POST['date'];
    $paid = isset($_POST['paid']);

    if ($paid != true) {
        echo "<script>alert('Please check the paid checkbox.');</script>";
        return;
    }

    $stmt = $admin->runQuery('INSERT INTO booking (roomId, userId, bookingDate, paid) VALUES (:roomId, :userId, :bookingDate, :paid)');

    $stmt->execute([':roomId' => $roomId, ':userId' => $userId, ':bookingDate' => $date, ':paid' => $paid]);

    // update user

    $stmt = $admin->runQuery('UPDATE user SET room = :room WHERE id = :userId');

    $stmt->execute([':room' => $roomId, ':userId' => $userId]);

    header('Location: ../rooms/index.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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
        <h1 class="text-3xl font-regular font-bold"><?php echo $room['name'] ?></h1>
        <p class="mt-2"><?php echo $room['description'] ?></p>
        <p class="mt-4 px-5 rounded-full py-1 bg-green-600 text-white w-fit"><?php echo $room['price'] ?></p>

        <div class="mt-10 max-w-[500px]">
            <h2 class="text-2xl font-bold">Please Choose a date</h2>
            <form class="space-y-4" action="" method="POST">

                <!-- Date Picker -->
                <div class="flex flex-col gap-2">
                    <label class="font-medium" for="date">Select Date</label>
                    <input class="text-black border border-gray-300 rounded-md p-2 w-44" type="date" name="date"
                        id="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                </div>

                <!-- Paid Checkbox -->
                <div class="flex items-center gap-2">
                    <input class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500" type="checkbox"
                        name="paid" id="paid">
                    <label class="font-medium" for="paid">Paid</label>
                </div>

                <!-- Submit Button -->
                <button name="btn-submit"
                    class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition" type="submit">
                    Submit
                </button>
            </form>
        </div>
    </section>

    <script>
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