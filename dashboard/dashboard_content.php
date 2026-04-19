<?php 
include('../config.php');
require 'referral_functions.php';

// Fetch the logged-in user's data
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT * FROM customer WHERE Customer_ID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$totalReferrals = getTotalReferrals($connect, $customer_id);

$query = "
    SELECT 
        ui.plan_type, 
        ui.daily_roi, 
        ui.total_roi, 
        ui.start_date, 
        ui.end_date, 
        ui.user_id, 
        ui.amount,
        ui.received,
        c.Balance, 
        i.duration
    FROM 
        user_investments ui
    JOIN 
        customer c ON c.Customer_ID = ui.user_id
    JOIN 
        investments i ON i.investment_type = ui.plan_type
    WHERE 
        ui.user_id = ? AND ui.status = 'active'";
$stmt2 = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt2, "s", $customer_id);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

// Count the rows returned by the query
$activeInvestments = mysqli_num_rows($result2);


?>


<h3 class="text-gray-700 text-2xl md:text-3xl font-medium">Dashboard</h3>

<div class="mt-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
        <!-- Card 1: Deposit Wallet -->
        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
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

        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
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
        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                    <i class="fas fa-chart-line text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700">$<?php echo number_format($user['total_invest'] ?? 0, 2); ?></h4>
                    <div class="text-gray-500">Total Investment</div>
                </div>
            </div>
        </div>

        <!-- Card 3: Active Investments -->
        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                    <i class="fas fa-briefcase text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $activeInvestments ?? 0; ?></h4>
                    <div class="text-gray-500">Active Investments</div>
                </div>
            </div>
        </div>

        <!-- Card 4: Referrals -->
        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-600 bg-opacity-75">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="mx-5">
                    <h4 class="text-2xl font-semibold text-gray-700"><?php echo $totalReferrals ?? 'N/A'; ?></h4>
                    <div class="text-gray-500">Referrals</div>
                </div>
            </div>
        </div>

        <!-- Card 5: Last Login -->
        <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer">
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
<script>

</script>

