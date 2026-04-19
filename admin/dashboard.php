<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 'overview';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen overflow-y-auto transition-all duration-300 ease-in-out transform -translate-x-full md:translate-x-0 fixed md:relative z-30">
            <div class="p-4">
                <h1 class="text-2xl font-semibold">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="?page=users" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'users' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-users mr-2"></i>User Management
                </a>
                <a href="?page=transactions" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'transactions' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-exchange-alt mr-2"></i>Transaction Management
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-md">
                <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                    <button id="sidebar-toggle" class="text-gray-500 focus:outline-none md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="ml-auto">
                        <a href="logout.php" class="text-gray-700 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-4 py-8">
                    <?php
                    switch ($current_page) {
                        case 'users':
                            include 'users.php';
                            break;
                        case 'transactions':
                            include 'transactions.php';
                            break;
                        default:
                            echo "<h2 class='text-2xl font-bold mb-4'>Welcome to Admin Dashboard</h2>";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebar-toggle').click(function() {
                $('#sidebar').toggleClass('-translate-x-full');
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#sidebar, #sidebar-toggle').length) {
                    $('#sidebar').addClass('-translate-x-full');
                }
            });
        });
    </script>
</body>
</html>