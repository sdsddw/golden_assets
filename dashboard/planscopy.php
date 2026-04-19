<?php  
require("../config.php");

// Fetch investment plans
$sql_investments = "SELECT * FROM investments";
$result_investments = $connect->query($sql_investments);
$investmentPlans = $result_investments->fetch_all(MYSQLI_ASSOC);

?>


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
</style>
<h3 class="text-gray-700 text-2xl md:text-3xl font-medium text-center mb-8">Investment Plans</h3>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Plan 1 -->
    <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: orange"></i>Basic Plan
        </h4>
        <p class="text-gray-600 mb-4">Perfect for beginners</p>
        <ul class="text-sm text-gray-600 mb-6">
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment: <strong>$100</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment: <strong>$1,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI: <strong>10%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI: <strong>1%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision: <strong>10%</strong></li>            
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration: <strong>7 days</strong></li>
        </ul>
        <button onclick="investNow('basic')" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest Now</button>
    </div>

    <!-- Plan 2 -->
    <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2"></i>Standard Plan <!-- Silver Star -->
        </h4>
        <p class="text-gray-600 mb-4">For intermediate investors</p>
        <ul class="text-sm text-gray-600 mb-6">
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment: <strong>$1,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment: <strong>$10,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI: <strong>20%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI: <strong>1%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision: <strong>10%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration: <strong>14 days</strong></li>
        </ul>
        <button onclick="investNow('standard')" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest Now</button>
    </div>

    <!-- Plan 3 -->
    <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #EACA3B"></i>Premium Plan <!-- Bronze Star -->
        </h4>
        <p class="text-gray-600 mb-4">For experienced investors</p>
        <ul class="text-sm text-gray-600 mb-6">
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment: <strong>$10,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment: <strong>$100,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI: <strong>40%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI: <strong>1%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision: <strong>10%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration: <strong>40 days</strong></li>
        </ul>
        <button onclick="investNow('premium')" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest Now</button>
    </div>

    <!-- VIP Plan -->
    <div class="bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105 hover:shadow-xl cursor-pointer border border-gray-200">
        <h4 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #FBE067"></i>
            <i class="fas fa-star shiny-icon mr-2" style="--icon-color: #FBE067"></i>
            <i class="fas fa-star shiny-icon  mr-2" style="--icon-color: #FBE067"></i>VIP Plan
        </h4>
        <p class="text-gray-600 mb-4">Exclusive benefits for elite investors</p>
        <ul class="text-sm text-gray-600 mb-6">
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Minimum Investment: <strong>$50,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Maximum Investment: <strong>$500,000</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Total ROI: <strong>60%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Daily ROI: <strong>2%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Referral Commision: <strong>10%</strong></li>
            <li class="mb-2"><i class="fas fa-check-circle text-green-500 mr-2"></i>Duration: <strong>60 days</strong></li>
        </ul>
        <button onclick="investNow('VIP')" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Invest Now</button>
    </div>
</div>

<div id="investModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden transition-opacity duration-300 ease-in-out opacity-0 transform translate-y-4">
    <div class="relative top-20 mx-auto p-4 sm:p-5 border w-full max-w-sm sm:max-w-md shadow-lg rounded-md bg-white transition-transform duration-300 ease-in-out transform translate-y-4">
        <div class="mt-3 text-center">
            <div class="text-lg font-bold text-gray-800 mb-4 flex justify-center space-x-1">


            <h3 id="CurrentPlan" ></h3>
               <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                <i id="icons"><i/>
               </h3>
            </div>
            <div id="amountInputs" class="mt-2 px-7 py-3">
                <!-- New Account Selection -->
                <div class="mb-4">
                    <label for="accountSelect" class="block text-sm font-medium text-gray-700">Select Account</label>
                    <select id="accountSelect" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="balance">Balance: $<?php echo number_format($user['Balance'], 2); ?></option>
                        <option value="interest">Interest Wallet: $<?php echo number_format($user['Interest_Balance'], 2); ?></option>
                    </select>
                </div>
                <!-- Existing input fields for USD and BTC -->
                <div class="mb-4">
                    <label for="usdAmount" class="block text-sm font-medium text-gray-700">USD Amount</label>
                    <input type="number" id="usdAmount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter USD amount">
                </div>
           
            <!-- Existing buttons -->
            <div class="items-center px-4 py-3">
                <button id="confirmDeposit" class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Confirm Deposit
                </button>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeDepositModal()" class="px-4 py-2 bg-gray-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modalTitle = document.getElementById('modalTitle');
    function closeDepositModal() {
        const modal = document.getElementById('investModal');
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
    const modalTitle = document.getElementById('modalTitle'); // Ensure this is the correct element

    for (let i = 0; i < 6; i++) {
        if (modalTitle.lastChild) {
            modalTitle.removeChild(modalTitle.lastChild);
        }
    }
    }
    function investNow(anything) {
        
        let icon = document.getElementById('icons');
        if(anything == 'VIP'){
            clearModalTitle()
            showDepositModal();
            updateModalTitle("VIP Plan");
            let icon1 = document.createElement('i');
            let icon2 = document.createElement('i');
            icon.className = 'fas fa-star text-yellow-500 mr-2';
            icon1.className = 'fas fa-star text-yellow-500 mr-2';
            icon2.className = 'fas fa-star text-yellow-500 mr-2';
            
            modalTitle.prepend(icon, icon1, icon2);
        }
        if(anything == 'premium'){
            clearModalTitle()
            showDepositModal();
            updateModalTitle("Premium Plan")
            icon.className = 'fas fa-star text-yellow-500 mr-2';
            modalTitle.prepend(icon);
        }
        if(anything == 'standard'){
            clearModalTitle()
            showDepositModal();
            updateModalTitle("Standard Plan");
            icon.className = 'fas fa-star text-gray-400 mr-2';
            modalTitle.prepend(icon);
        }
        if(anything == 'basic'){
            clearModalTitle()
            showDepositModal();
            updateModalTitle("Basic Plan");
            icon.className = 'fas fa-star text-orange-500 mr-2';
            modalTitle.prepend(icon);
            
        console.log(anything)
        }
    }
</script>
