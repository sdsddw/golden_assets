<?php
session_start();
include('../config.php');

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../sign_in.php");
    exit;
}


$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM customer WHERE Customer_ID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$whatthefuck = $user["Balance"];
$whatthefuck1 = $user["Customer_Name"];
$total_investment = $user['total_invest'];

$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://golden-assets.gold/css/iziToast.min.css">
    <link rel="icon" href="/images/2.png" type="image/x-icon">
    <link rel="shortcut icon" type="image/png" href="/images/2.png" />
    <meta name="title" Content="Dashboard  - Trade | Real Estate | Oil And Gas - Dashboard">
    <meta name="description" content="An investment company is a corporation or trust engaged in the business of investing pooled capital into financial securities. Investment companies make profits by buying and selling shares, Cryptocurrencies, property, bonds, cash, other funds and 

    
    <script>
    function copyReferralLink() {
        var copyText = document.getElementById("referralLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Referral link copied to clipboard!");
    }
    </script>
    <style>
        :root {
            --icon-color: #C0C0C0; /* Default silver color */
            --icon-bg: #ffffff; /* Default background color */
        }

        .shiny-icon {
            color: var(--icon-color); /* Use the color variable */
            background: linear-gradient(145deg, var(--icon-bg), #e6e6e6); /* Gradient for shine */
            border-radius: 50%; /* Round shape */
            padding: 5px; /* Padding for the background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 0 10px rgba(255, 255, 255, 0.5); /* Shadow for depth */
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.7); /* Glowing effect */
        }

        #user-menu {
            position: absolute; /* or fixed if you want it to stay in view */
            z-index: 1000; /* High z-index to overlay other elements */
            top: 100%; /* Position it below the button */
            right: 0; /* Align it to the right */
            /* Optional: Add transition for smooth appearance */
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-800 text-white w-64 min-h-screen overflow-y-auto transition-all duration-300 ease-in-out transform -translate-x-full md:translate-x-0 fixed md:relative z-30">
            <div class="p-4" flex items-center space-x-3>
            <div class="logo-container">
        <a href="https://golden-assets.gold">
            <img src="https://golden-assets.gold/images/g.png" alt="Golden Assets Logo" class="w-[180px] h-[85px] md:w-[180px] md:h-[85px] object-contain transition-transform duration-300 hover:scale-110">
    </div>
                <h1 class="text-2xl font-semibold">GOLDEN ASSETS</h1>
            </div>
            <nav class="mt-4">
                <a href="?page=dashboard" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'dashboard' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="?page=investment_plans" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'investment_plans' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-wallet mr-2"></i>Investment Plans
                </a>
                <a href="?page=first_interest_log" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'first_interest_log' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-book mr-2"></i>Interest Log
                </a>
                <a href="?page=deposit" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'deposit' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-money-bill-wave mr-2"></i>Deposit Now
                </a>
                <a href="?page=withdraw" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'withdraw' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-money-bill-wave-alt mr-2"></i>Withdraw Now
                </a>
                <a href="?page=history" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'history' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-history mr-2"></i>Transaction History
                </a>
    
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-chart-bar mr-2"></i>User Activities
                </a>
                <a href="?page=referrals" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'referrals' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-users mr-2"></i>My Referrals
                </a>
                <hr class="my-4 border-gray-600">
                <a href="?page=my_account" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white <?php echo $current_page == 'my_account' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-user mr-2"></i>My Account
                </a>
                <a href="?page=logout" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>

            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navbar -->
            <header class="bg-white shadow-md">
                <div class="container mx-auto px-4 py-3">
                    <div class="flex items-center justify-between">
                        <button id="sidebar-toggle" class="text-gray-500 focus:outline-none md:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="flex items-center space-x-4 ml-auto">
                            <div class="text-gray-700 pr-4 border-r border-gray-300">
                                <span class="font-semibold">Balance:</span><br class="md:hidden"> $<?php echo number_format($whatthefuck, 2); ?>
                            </div>
                            <div class="relative">
                                <button id="user-menu-button" class="flex items-center focus:outline-none">
                                    <img class="h-8 w-8 rounded-full mr-2" src="https://golden-assets.gold/images/avatar/avatar.png" alt="User avatar">
                                    <span class="text-gray-700 text-sm sm:text-base mr-1 hidden sm:inline">
                                        <?php echo $user['Customer_Name']; ?>
                                    </span>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden transition-all duration-300 ease-in-out transform opacity-0 scale-95">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-200 sm:hidden">
                                        <?php echo $user['Customer_Name']; ?>
                                    </div>
                                    <a href="?page=my_account" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Account</a>
                                    <a href="#" id="logout-link" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>


            <!-- Page Content -->
            <main id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 transition-opacity duration-300 ease-in-out">
                <div class="container mx-auto px-4 py-8">
                    <h3 id="page-title" class="text-gray-700 text-2xl md:text-3xl font-medium mb-6"></h3>
                    <div id="page-content">
                        <?php
                        // Get the current domain dynamically
                        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                        $domain = $_SERVER['HTTP_HOST'];
                        $base_url = "{$protocol}://{$domain}";

                        // Pass the base URL to the included files
                        $GLOBALS['base_url'] = $base_url;

                        switch ($current_page) {
                            case 'dashboard':
                                include 'dashboard_content.php';
                                break;
                            case 'investment_plans':
                                include 'plans.php';
                                break;
                            case 'deposit_now':
                                include 'deposit.php';
                                break;
                            case 'deposit':
                                include 'deposit.php';
                                break;
                            case 'withdraw':
                                include 'withdraw.php';
                                break;
                            case 'history':
                                include 'history.php';
                                break;
                            case 'referrals':
                                include 'referrals.php';
                                break;
                            case 'my_account':
                                    include 'my_account.php';
                                    break;
                            case 'first_interest_log':
                                include 'first_interest_log.php';
                                break;
                                
                            default:
                                include 'logsout.php';
                        }
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#sidebar-toggle').click(function() {
                $('#sidebar').toggleClass('-translate-x-full');
                // Add a slight delay to allow the CSS transition to take effect
                setTimeout(() => {
                    $('#sidebar').toggleClass('ease-in-out');
                }, 50);
            });
            var customer_id = '<?php echo $_SESSION['customer_id'];?>';
            console.log(customer_id);

            function closeSidebarOnMobile() {
                if (window.innerWidth < 768) { // Assuming md breakpoint is 768px
                    $('#sidebar').addClass('-translate-x-full');
                    // Add a slight delay to allow the CSS transition to take effect
                    setTimeout(() => {
                        $('#sidebar').addClass('ease-in-out');
                    }, 50);
                }
            }

            // Close sidebar when clicking on menu items
            $('#sidebar a').click(function() {
                closeSidebarOnMobile();
            });

            // Close sidebar when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#sidebar, #sidebar-toggle').length) {
                    closeSidebarOnMobile();
                }
            });

            document.getElementById('user-menu-button').addEventListener('click', function() {
                const menu = document.getElementById('user-menu');
                
                setTimeout(() => {
                menu.classList.toggle('hidden');
                menu.classList.toggle('opacity-0');
                menu.classList.toggle('scale-95'); // Ensure it is hidden after the transition
                }, 300); // Match this with your transition duration
            });

            // Close the menu when clicking outside
            document.addEventListener('click', function(event) {
                const menu = document.getElementById('user-menu');
                if (!event.target.closest('#user-menu-button') && !menu.classList.contains('hidden')) {
                    menu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 200);
                }
            });

            function logout() {
                $.ajax({
                    url: '../logout.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '../sign_in.php';
                        }
                    },
                    error: function() {
                        alert('An error occurred during logout.');
                    }
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.logout = function() {
                $.ajax({
                    url: '../logout.php',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '../sign_in.php';
                        } else {
                            alert('Logout failed: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        alert('An error occurred during logout. Please try again.');
                    }
                });
            };

            document.getElementById('logout-link').addEventListener('click', function(e) {
                e.preventDefault();
                logout();
            });
        });

        // function investNow(anything) {}
        // console.log(anything)

        function loadPage(url) {
            const mainContent = document.getElementById('main-content');
            mainContent.style.opacity = '0';
            
            setTimeout(() => {
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        // Extract the main content
                        const pageContent = doc.querySelector('.container.mx-auto.px-4.py-8').innerHTML;
                        
                        // Update the page content
                        document.getElementById('page-content').innerHTML = pageContent;
                        
                        // Update the page title if it exists
                        const pageTitle = doc.querySelector('h3');
                        if (pageTitle) {
                            document.getElementById('page-title').textContent = pageTitle.textContent;
                        }
                        
                        mainContent.style.opacity = '1';
                        history.pushState(null, '', url);
                    });
            }, 300);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('a[href^="?page="]').forEach(link => {
                link.addEventListener('click', (e) => {
                    //e.preventDefault();
                    loadPage(e.target.href);
                });
            });
        });
    </script>
</body>
</html>