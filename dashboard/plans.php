<?php

$sql_investments = "SELECT * FROM investments WHERE investment_type = 'Basic'";
$result_investments = $connect->query($sql_investments);
$investmentPlans_basic = $result_investments->fetch_all(MYSQLI_ASSOC);

$sql_investments = "SELECT * FROM investments WHERE investment_type = 'Standard'";
$result_investments = $connect->query($sql_investments);
$investmentPlans_standard = $result_investments->fetch_all(MYSQLI_ASSOC);

$sql_investments = "SELECT * FROM investments WHERE investment_type = 'Premium'";
$result_investments = $connect->query($sql_investments);
$investmentPlans_premium = $result_investments->fetch_all(MYSQLI_ASSOC);

$sql_investments = "SELECT * FROM investments WHERE investment_type = 'VIP'";
$result_investments = $connect->query($sql_investments);
$investmentPlans_vip = $result_investments->fetch_all(MYSQLI_ASSOC);

?>
<style>
    :root {
        --icon-color: #C0C0C0;
        /* Default silver color */
        --icon-bg: #ffffff;
        /* Default background color */
    }

    .shiny-icon {
        color: var(--icon-color);
        /* Use the color variable */
        background: linear-gradient(145deg, var(--icon-bg), #e6e6e6);
        /* Gradient for shine */
        border-radius: 50%;
        /* Round shape */
        padding: 5px;
        /* Padding for the background */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 0 10px rgba(255, 255, 255, 0.5);
        /* Shadow for depth */
        text-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
        /* Glowing effect */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- <link rel="stylesheet" href="https://golden-assets.gold/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="https://golden-assets.gold/css/swiper-bundle.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/animate.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/odometer-theme-default.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/fancybox.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/magnific-pupup.css">
<!-- <link rel="stylesheet" href="https://golden-assets.gold/css/styles.css"> -->
<!-- Plugins CSS (All Plugins Files) -->
<link rel="stylesheet" href="https://golden-assets.gold/css/all.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/nice-select.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/owl.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/owl.theme.default.min.css">
<link rel="stylesheet" href="https://golden-assets.gold/css/iziToast.min.css">
<!-- <link rel="stylesheet" href="https://golden-assets.gold/css/main.css"> -->

<h3 class="text-gray-700 text-2xl md:text-3xl font-medium text-center mb-8">INVESTMENT PLANS</h3>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Plan 1 -->
    <div
        class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: orange"></i>Basic Plan
        </h4>
        <?php foreach ($investmentPlans_basic as $plan): ?>
            <p class="text-gray-600 mb-4">Perfect for beginners</p>
            <ul class="text-sm text-gray-600 mb-6">
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment:
                    <strong>$<?php echo number_format($plan['min_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment:
                    <strong>$<?php echo number_format($plan['max_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI:
                    <strong><?php echo number_format($plan['daily_roi']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI:
                    <strong><?php echo number_format($plan['total_roi']); ?>%</strong>
                </li>
            
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision:
                    <strong><?php echo number_format($plan['referral_commission']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration:
                    <strong><?php echo number_format($plan['duration']); ?> days</strong>
                </li>
            </ul>
        <?php endforeach; ?>
        <button onclick="investNow('basic')"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest
            Now</button>
    </div>


    <!-- Plan 2 -->
    <div
        class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2"></i>Standard Plan <!-- Silver Star -->
        </h4>

        <?php foreach ($investmentPlans_standard as $plan): ?>
            <p class="text-gray-600 mb-4">For intermediate investors</p>
            <ul class="text-sm text-gray-600 mb-6">
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment:
                    <strong>$<?php echo number_format($plan['min_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment:
                    <strong>$<?php echo number_format($plan['max_investment']); ?></strong>
                </li>

                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI:
                    <strong><?php echo number_format($plan['daily_roi']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI:
                    <strong><?php echo number_format($plan['total_roi']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision:
                    <strong><?php echo number_format($plan['referral_commission']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration:
                    <strong><?php echo number_format($plan['duration']); ?> days</strong>
                </li>
            </ul>
        <?php endforeach; ?>
        <button onclick="investNow('standard')"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest
            Now</button>
    </div>


    <!-- Plan 3 -->
    <div
        class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #EACA3B"></i>Premium Plan <!-- Bronze Star -->
        </h4>
        <?php foreach ($investmentPlans_premium as $plan): ?>
            <p class="text-gray-600 mb-4">For experienced investors</p>
            <ul class="text-sm text-gray-600 mb-6">
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment:
                    <strong>$<?php echo number_format($plan['min_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment:
                    <strong>$<?php echo number_format($plan['max_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Weekly ROI:
                    <strong><?php echo number_format($plan['daily_roi']); ?>%</strong>
                </li>
                <!-- <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI:
                    <strong><?php echo "UNLIMITED" ?></strong>
                </li> -->
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision:
                    <strong><?php echo number_format($plan['referral_commission']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration:
                    <strong> UNLIMITED</strong>
                </li>
            </ul>
        <?php endforeach; ?>
        <button onclick="investNow('premium')"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest
            Now</button>
    </div>


    <!-- VIP Plan -->
    <div
        class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #FBE067"></i>
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #FBE067"></i>
            <i class="fas fa-star shiny-icon  mr-2" style="--icon-color: #FBE067"></i>VIP Plan
        </h4>
        <?php foreach ($investmentPlans_vip as $plan): ?>
            <p class="text-gray-600 mb-4">Exclusive benefits for elite investors</p>
            <ul class="text-sm text-gray-600 mb-6">
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment:
                    <strong>$<?php echo number_format($plan['min_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment:
                    <strong>$<?php echo number_format($plan['max_investment']); ?></strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI:
                    <strong><?php echo number_format($plan['daily_roi']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI:
                    <strong><?php echo number_format($plan['total_roi']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision:
                    <strong><?php echo number_format($plan['referral_commission']); ?>%</strong>
                </li>
                <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration:
                    <strong><?php echo number_format($plan['duration']); ?> days</strong>
                </li>
            </ul>
        <?php endforeach; ?>
        <button onclick="investNow('VIP')"
            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest
            Now</button>
    </div>

</div>
<div id="investModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden transition-opacity duration-300 ease-in-out opacity-0 transform translate-y-4">
    <div
        class="relative top-20 mx-auto p-4 sm:p-5 border w-full max-w-sm sm:max-w-md shadow-lg rounded-md bg-white transition-transform duration-300 ease-in-out transform translate-y-4">
        <div class="mt-3 text-center">
            <div class="text-lg font-bold text-gray-800 mb-4 flex justify-center space-x-1">


                <h3 id="CurrentPlan"></h3>
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                    <i id="icons"><i />
                </h3>
            </div>
            <div id="amountInputs" class="mt-2 px-7 py-3">
                <!-- New Account Selection -->
                <div class="mb-4">
                    <label for="accountSelect" class="block text-sm font-medium text-gray-700">Select Account</label>
                    <select id="accountSelect"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="balance">Balance: $<?php echo number_format($user['Balance'], 2); ?></option>
                        <option value="interest">Interest Wallet:
                            $<?php echo number_format($user['Interest_Balance'], 2); ?></option>
                    </select>
                </div>
                <!-- Existing input fields for USD and BTC -->
                <div class="mb-4">
                    <label for="usdAmount" class="block text-sm font-medium text-gray-700">USD Amount</label>
                    <input type="number" id="usdAmount"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Enter USD amount">
                </div>

                <!-- Existing buttons -->
                <div class="items-center px-4 py-3">
                    <button id="confirmDeposit" onclick="ConfirmDeposit()"
                        class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Confirm Deposit
                    </button>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closeDepositModal()"
                        class="px-4 py-2 bg-gray-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include iziToast JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
    <script>
        const modalTitle = document.getElementById('modalTitle');

        function closeDepositModal() {
            const modal = document.getElementById('investModal');
            
            // Reset form values
            document.getElementById('usdAmount').value = '';
            document.getElementById('accountSelect').selectedIndex = 0;
            
            // Clear any error messages
            const errorElements = modal.getElementsByClassName('error-message');
            Array.from(errorElements).forEach(el => el.remove());
            
            // Reset button state
            const confirmButton = document.getElementById('confirmDeposit');
            // confirmButton.disabled = false;
            // confirmButton.textContent = 'Confirm Deposit';
            
            // Hide modal with animation
            modal.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function showDepositModal() {
            const modal = document.getElementById('investModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0', 'translate-y-4');
            }, 300);
        }

        function updateModalTitle(plan) {
            let currentPlan = document.getElementById('CurrentPlan');
            currentPlan.innerText = plan;
        }

        function clearModalTitle() {
            const modalTitle = document.getElementById('modalTitle');

            for (let i = 0; i < 6; i++) {
                if (modalTitle.lastChild) {
                    modalTitle.removeChild(modalTitle.lastChild);
                }
            }
        }

        function getSelectedAccount() {
            const accountSelect = document.getElementById('accountSelect');
            const selectedValue = accountSelect.value;
            console.log("Selected Account:", selectedValue);
            return selectedValue;
            // You can use the selectedValue as needed
        }

        function resetAccountSelect() {
            const accountSelect = document.getElementById('accountSelect');
            accountSelect.selectedIndex = 0; // Reset to the first option
        }

        function getAmount() {
            const amountInput = document.getElementById('usdAmount');
            return parseFloat(amountInput.value) || 0;
        }

        function invest(invest_type, amount, selected_account) {
            if (amount <= 0) {
                iziToast.show({
                        title: 'Notification',
                        message: responseData.message,
                        position: 'topRight',
                        color: 'red',
                    });
                return;
            }
            var userEmail = <?php echo json_encode($_SESSION['email']); ?>;
            console.log(userEmail)
            let customer_id = <?php echo $_SESSION['customer_id']; ?>;
            console.log("customer id: " + customer_id + " investment type: " + invest_type + " amount is : " + amount + " selected Type: " + selected_account);
            $.ajax({
                url: 'con_investment1.php',
                method: 'POST',
                data: {
                    investment_type: invest_type,
                    investment_amount: amount,
                    customer_id: customer_id,
                    selected_account: selected_account
                },
                success: function(response) {
                    var responseData = $.parseJSON(response);
                    console.log(responseData.message);
                    iziToast.show({
                        title: 'Notification',
                        message: responseData.message,
                        position: 'topRight',
                        color: 'green',
                    });
                    setTimeout(() => {
                        // Send confirmation email to user
                       
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    iziToast.show({
                        title: 'Notification',
                        message: 'An error occurred while processing your investment',
                        position: 'topRight',
                        color: 'red',
                    });
                    // alert('An error occurred while processing your investment.');
                },
                complete: function() {
                    confirmButton.disabled = false;
                    confirmButton.textContent = 'Confirm Deposit';
                }
            });
        }
        let selected_type = "shebi";
        console.log(selected_type)

        function investNow(anything) {
            let icon = document.getElementById('icons');
            if (anything == 'VIP') {
                clearModalTitle()
                showDepositModal();
                updateModalTitle("VIP Plan");
                let icon1 = document.createElement('i');
                let icon2 = document.createElement('i');
                icon.className = 'fas fa-star text-yellow-500 mr-2';
                icon1.className = 'fas fa-star text-yellow-500 mr-2';
                icon2.className = 'fas fa-star text-yellow-500 mr-2';
                modalTitle.prepend(icon, icon1, icon2);
                selected_type = anything;
            }
            if (anything == 'premium') {
                clearModalTitle()
                showDepositModal();
                updateModalTitle("Premium Plan")
                icon.className = 'fas fa-star text-yellow-500 mr-2';
                modalTitle.prepend(icon);
                selected_type = anything;
            }
            if (anything == 'standard') {
                clearModalTitle()
                showDepositModal();
                updateModalTitle("Standard Plan");
                icon.className = 'fas fa-star text-gray-400 mr-2';
                modalTitle.prepend(icon);
                selected_type = anything;
            }
            if (anything == 'basic') {
                clearModalTitle()
                showDepositModal();
                updateModalTitle("Basic Plan");
                icon.className = 'fas fa-star text-orange-500 mr-2';
                modalTitle.prepend(icon);
                selected_type = anything;
                console.log(anything)
            }
        }

        function logger() {
            console.log(selected_type)
        }

        function ConfirmDeposit() {
            const amount = getAmount();
            const selected_account_type = getSelectedAccount();
            
            if(!validateInvestmentAmount(amount, selected_type)){
                return
            }
            if (!validateInvestmentForm(amount, selected_account_type, selected_type)) {
                return;
            }
            
            // Validate investment amount limits
            if (!checkAccountBalance(amount, selected_type)) {
                return;
            }
            
            // Proceed with investment
            invest(selected_type, amount, selected_account_type);
            
            // Clear form after successful submission
            clearType();
        }

        function clearType() {
            amount = 0;
            document.getElementById('usdAmount').value = ''; // Clear the input field
            console.log(selected_type + " this is the selected type");
            resetAccountSelect()
        }

        const INVESTMENT_TYPES = {
            VIP: {
                title: "VIP Plan",
                icons: 3,
                iconClass: 'fas fa-star text-yellow-500 mr-2',
                limits: { min: 10001, max: 50000 }
            },
            PREMIUM: {
                title: "Premium Plan",
                icons: 1,
                iconClass: 'fas fa-star text-yellow-500 mr-2',
                limits: { min: 5001, max: 10000 }
            },
            STANDARD: {
                title: "Standard Plan",
                icons: 1,
                iconClass: 'fas fa-star text-gray-400 mr-2',
                limits: { min: 1001, max: 5000 }
            },
            BASIC: {
                title: "Basic Plan",
                icons: 1,
                iconClass: 'fas fa-star text-orange-500 mr-2',
                limits: { min: 100, max: 1000 }
            }
        };
        function checkAccountBalance(amount, accountType) {
       const balances = {
           balance: <?php echo $user['Balance']; ?>,
           interest: <?php echo $user['Interest_Balance']; ?>
       };
       
       if (amount > balances[accountType]) {
        iziToast.show({
                        title: 'Notification',
                        message: `Insufficient funds in ${accountType} account`,
                        position: 'topRight',
                        color: 'red',
                    });
        //    alert(`Insufficient funds in ${accountType} account`);
           return false;
       }
       
       return true;
   }

        function validateInvestmentAmount(amount, type) {
            const INVESTMENT_LIMITS = {
                basic: { min: 100, max: 1000 },
                standard: { min: 1001, max: 50000 },
                premium: { min: 10000, max: 5000000 },
                VIP: { min: 50000, max: 1000000 }
            };

            const limits = INVESTMENT_LIMITS[type.toLowerCase()];
            
            if (amount < limits.min) {
                iziToast.error({
                        title: 'Notification',
                        message: `Minimum investment for ${type} plan is $${limits.min}`,
                        position: 'topRight',
                        color: 'red',
                    });
                // alert(`Minimum investment for ${type} plan is $${limits.min}`);
                return false;
            }
            
            if (amount > limits.max) {
                iziToast.error({
                        title: 'Notification',
                        message: `Maximum investment for ${type} plan is $${limits.max}`,
                        position: 'topRight',
                        color: 'red',
                    });
                // alert(`Maximum investment for ${type} plan is $${limits.max}`);
                return false;
            }

            return true;
        }

        function validateInvestmentForm(amount, account, investmentType) {
            if (!amount || amount <= 0) {
                iziToast.error({
                        title: 'Notification',
                        message: "Please select a valid amount",
                        position: 'topRight',
                        color: 'red',
                    });
                return false;
            }
            
            if (!account) {
                alert("Please select an account");
                return false;
            }

            // Check if investment type is valid
            if (!['basic', 'standard', 'premium', 'VIP'].includes(investmentType)) {
                alert("Invalid investment type");
                return false;
            }

            return true;
        }
    </script>