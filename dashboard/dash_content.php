<?php 
include('../config.php');

// Fetch the logged-in user's data
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM customer WHERE Customer_ID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Now you can use $user['Balance'] to get the balance
?>
<h3 class="text-gray-700 text-2xl md:text-3xl font-medium">Dashboard</h3>

<div class="mt-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
        <!-- Card 1: Deposit Wallet -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                    <i class="fas fa-wallet text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">$<?php echo number_format($user['Balance'], 2); ?></h4>
                    <div class="text-gray-500">Deposit Wallet</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                    <i class="fas fa-piggy-bank text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">$<?php echo number_format($user['Interest_Balance'] , 2); ?></h4>
                    <div class="text-gray-500">Interest Wallet</div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Earnings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">$<?php echo number_format($user['TotalEarnings'] ?? 0, 2); ?></h4>
                    <div class="text-gray-500">Total Earnings</div>
                </div>
            </div>
        </div>

        <!-- Card 3: Active Investments -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                    <i class="fas fa-briefcase text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $user['ActiveInvestments'] ?? 0; ?></h4>
                    <div class="text-gray-500">Active Investments</div>
                </div>
            </div>
        </div>

        <!-- Card 4: Referrals -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $user['Referrals'] ?? 0; ?></h4>
                    <div class="text-gray-500">Referrals</div>
                </div>
            </div>
        </div>

        <!-- Card 5: Last Login -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-600 bg-opacity-75">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-xl font-semibold text-gray-700"><?php echo $user['LastLogin'] ?? 'N/A'; ?></h4>
                    <div class="text-gray-500">Last Login</div>
                </div>
            </div>
        </div>
    </div>
</div>

