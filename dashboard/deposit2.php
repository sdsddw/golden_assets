<h3 class="text-gray-700 text-2xl md:text-3xl font-medium mb-6">Deposit Funds</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- BTC Deposit -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-xl font-semibold text-gray-800">Deposit with Bitcoin (BTC)</h4>
            <img src="../bitcoin_logo.png" alt="Bitcoin Logo" class="h-10 w-10 object-contain">
        </div>
        <p class="text-gray-600 mb-4">Send BTC to the address below:</p>
        <div class="bg-gray-100 p-3 rounded-md mb-4">
            <code class="text-sm break-all">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</code>
        </div>
        <button onclick="showDepositModal()" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition duration-200">
            Deposit BTC
        </button>
    </div>

    <!-- USDT Deposit -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-xl font-semibold text-gray-800">Deposit with USDT (TRC20)</h4>
            <img src="../download.png" alt="USDT Logo" class="h-10 w-10 object-contain">
        </div>
        <p class="text-gray-600 mb-4">Send USDT to the address below:</p>
        <div class="bg-gray-100 p-3 rounded-md mb-4">
            <code class="text-sm break-all">TRzSzRaWEqNgANHs2kZUdoqndEz8LBnNdc</code>
        </div>
        <button onclick="showDepositModal('USDT')" class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition duration-200">
            Deposit USDT
        </button>
    </div>
</div>

<!--  Deposit Modal -->
<div id="depositModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-4 sm:p-5 border w-full max-w-sm sm:max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Deposit BTC</h3>
            <div id="amountInputs" class="mt-2 px-7 py-3">
                <div class="mb-4">
                    <label for="usdAmount" class="block text-sm font-medium text-gray-700">USD Amount</label>
                    <input type="number" id="usdAmount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter USD amount">
                </div>
                <div class="mb-4">
                    <label for="btcAmount" class="block text-sm font-medium text-gray-700">BTC Amount</label>
                    <input type="number" id="btcAmount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter BTC amount">
                </div>
                <p class="text-sm text-gray-500 mt-2">Exchange Rate: <span id="exchangeRate">Loading...</span></p>
            </div>
            <div id="btcAccountInfo" class="mt-2 px-7 py-3 hidden">
                <p class="text-sm text-gray-700 mb-2">Please send exactly <span id="confirmBtcAmount" class="font-bold"></span> USD in bitcoin to the following address:</p>
                <div class="bg-gray-100 p-3 rounded-md mb-4">
                    <code class="text-sm break-all">bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh</code>
                </div>
                <p class="text-sm text-gray-500 mb-4">After sending the BTC, click the confirm button below.</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDeposit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Confirm Deposit
                </button>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeDepositModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- USDT Deposit Modal -->
<div id="usdtDepositModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-4 sm:p-5 border w-full max-w-sm sm:max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Deposit USDT</h3>
            <div id="usdtAmountInput" class="mt-2 px-7 py-3">
                <div class="mb-4">
                    <label for="usdtAmount" class="block text-sm font-medium text-gray-700">USDT Amount</label>
                    <input type="number" id="usdtAmount" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter USDT amount">
                </div>
            </div>
            <div id="usdtAccountInfo" class="mt-2 px-7 py-3 hidden">
                <p class="text-sm text-gray-700 mb-2">Please send exactly <span id="confirmUsdtAmount" class="font-bold"></span> USDT to the following address:</p>
                <div class="bg-gray-100 p-3 rounded-md mb-4">
                    <code class="text-sm break-all">TRzSzRaWEqNgANHs2kZUdoqndEz8LBnNdc</code>
                </div>
                <p class="text-sm text-gray-500 mb-4">After sending the USDT, click the confirm button below.</p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmUsdtDeposit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Confirm Deposit
                </button>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="closeUsdtDepositModal()" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<div id="SuccessModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden transition-opacity duration-300 p-4">
    <div class="relative top-20 mx-auto p-4 sm:p-8 border w-full max-w-sm sm:max-w-md shadow-2xl rounded-xl bg-white transition-all duration-300 ease-in-out transform">
        <div id="processingContent" class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                <svg class="h-8 w-8 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Processing Deposit</h3>
            <p class="text-gray-600 mb-6">
                Your Deposit request is being processed. Please wait...
            </p>
        </div>
        <div id="approvalContent" class="mt-3 text-center hidden">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Deposit Pending Approval</h3>
            <p id="approvalMessage" class="text-gray-600 mb-6"></p>
            <button onclick="closedepositModal()" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Close
            </button>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let exchangeRate = 0;
let depositStep = 1;
let usdtDepositStep = 1;

function showDepositModal(currency) {
    if (currency === 'USDT') {
        document.getElementById('usdtDepositModal').classList.remove('hidden');
    } else {
        document.getElementById('depositModal').classList.remove('hidden');
        fetchExchangeRate();
    }
}

function closedepositModal() {
    const modal = document.getElementById('SuccessModal');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('processingContent').classList.remove('hidden');
        document.getElementById('approvalContent').classList.add('hidden');
        
        // Reset BTC deposit form
        document.getElementById('usdAmount').value = '';
        document.getElementById('btcAmount').value = '';
        $('#amountInputs').show();
        $('#btcAccountInfo').hide();
        depositStep = 1;

        // Reset USDT deposit form
        document.getElementById('usdtAmount').value = '';
        $('#usdtAmountInput').show();
        $('#usdtAccountInfo').hide();
        usdtDepositStep = 1;

        // Close both modals
        document.getElementById('depositModal').classList.add('hidden');
        document.getElementById('usdtDepositModal').classList.add('hidden');
        

        // Reset exchange rate display
        $('#exchangeRate').text('Loading...');
        window.location.href = 'index.php?page=history';
    }, 300);
}

function closeDepositModal() {
    document.getElementById('depositModal').classList.add('hidden');
    document.getElementById('usdAmount').value = '';
    document.getElementById('btcAmount').value = '';
    $('#amountInputs').show();
    $('#btcAccountInfo').hide();
    depositStep = 1;
}

function closeUsdtDepositModal() {
    document.getElementById('usdtDepositModal').classList.add('hidden');
    document.getElementById('usdtAmount').value = '';
    $('#usdtAmountInput').show();
    $('#usdtAccountInfo').hide();
    usdtDepositStep = 1;
    
    // Set a timeout to redirect after 20 seconds
    setTimeout(function() {
        window.location.href = 'index.php?page=history';
    }, 20000); // 20000 milliseconds = 20 seconds
}

function fetchExchangeRate() {
    $.ajax({
        url: 'https://api.coingecko.com/api/v3/simple/price?ids=bitcoin&vs_currencies=usd',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            exchangeRate = data.bitcoin.usd;
            $('#exchangeRate').text('1 BTC = $' + exchangeRate.toFixed(2));
        },
        error: function() {
            $('#exchangeRate').text('Failed to load');
        }
    });
}

function updateBTCAmount() {
    let usdAmount = parseFloat($('#usdAmount').val());
    console.log('USD Amount:', usdAmount);
    if (!isNaN(usdAmount) && exchangeRate > 0) {
        let btcAmount = usdAmount / exchangeRate;
        $('#btcAmount').val(btcAmount.toFixed(8));
    }
}

function updateUSDAmount() {
    let btcAmount = parseFloat($('#btcAmount').val());
    if (!isNaN(btcAmount) && exchangeRate > 0) {
        let usdAmount = btcAmount * exchangeRate;
        $('#usdAmount').val(usdAmount.toFixed(2));
    }
}

function logUSDTAmount() {
    let usdtAmount = parseFloat($('#usdtAmount').val());
    console.log('USDT Amount:', usdtAmount);
}

function showSuccessMod(amount, currency, address){
       const modal = document.getElementById('SuccessModal');
        modal.classList.remove('hidden');
        modal.classList.add('opacity-100');

        setTimeout(function() {
            document.getElementById('processingContent').classList.add('hidden');
            showSuccessModal(amount, currency, address);
        }, 3000); 
}

function showSuccessModal(currency, amount, amountType = '') {
    const modal = document.getElementById('SuccessModal');
    const processingContent = document.getElementById('processingContent');
    const approvalContent = document.getElementById('approvalContent');
    const approvalMessage = document.getElementById('approvalMessage');

    processingContent.classList.remove('hidden');
    approvalContent.classList.add('hidden');
    modal.classList.remove('hidden');

    setTimeout(() => {
        processingContent.classList.add('hidden');
        approvalContent.classList.remove('hidden');
        let messageText = `Your ${currency} deposit of ${amount} ${amountType} has been submitted and is pending approval.`;
        approvalMessage.textContent = messageText;
    }, 2000);
}

$(document).ready(function() {
    $('#usdAmount').on('input', updateBTCAmount);
    $('#btcAmount').on('input', updateUSDAmount);
    $('#usdtAmount').on('input', logUSDTAmount);


    $('#confirmDeposit').click(function() {
        if (depositStep === 1) {
            let usdAmount = parseFloat($('#usdAmount').val());
            let btcAmount = parseFloat($('#btcAmount').val());
        
            
            if (isNaN(usdAmount) || isNaN(btcAmount) || usdAmount <= 0 || btcAmount <= 0) {
                alert('Please enter valid amounts');
                return;
            }

            console.log('Confirming BTC deposit. USD Amount:', usdAmount);

            $('#amountInputs').hide();
            $('#btcAccountInfo').show();
            $('#confirmBtcAmount').text(usdAmount);
            depositStep = 2;
        } else if (depositStep === 2) {
            let usdAmount = parseFloat($('#usdAmount').val());
            console.log('BTC deposit confirmed. USD Amount:', usdAmount);

            // Send AJAX request
            $.ajax({
                url: 'process_deposit.php',
                type: 'POST',
                data: {
                    amount: usdAmount,  // Send USD amount instead of BTC
                    currency: 'BTC'     // Keep currency as BTC
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        showSuccessModal('BTC', usdAmount, 'USD');  // Pass USD as the amount type
                        closeDepositModal();
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });

    $('#confirmUsdtDeposit').click(function() {
        if (usdtDepositStep === 1) {
            let usdtAmount = parseFloat($('#usdtAmount').val());
            
            if (isNaN(usdtAmount) || usdtAmount <= 0) {
                alert('Please enter a valid USDT amount');
                return;
            }

            console.log('USDT Amount:', usdtAmount);

            $('#usdtAmountInput').hide();
            $('#usdtAccountInfo').show();
            $('#confirmUsdtAmount').text(usdtAmount.toFixed(2));
            usdtDepositStep = 2;
        } else if (usdtDepositStep === 2) {
            let usdtAmount = parseFloat($('#confirmUsdtAmount').text());
            console.log('Confirming USDT deposit. Amount:', usdtAmount);

            // Send AJAX request
            $.ajax({
                url: 'process_deposit.php',
                type: 'POST',
                data: {
                    amount: usdtAmount,
                    currency: 'USDT'
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response); // Log the response to console
                    if (response.success) {
                        showSuccessMod('USDT', usdtAmount, "this_address");
                        closeUsdtDepositModal();
               
                    } else {
                        alert('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        }
    });
});
</script>
<style>
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translate3d(0, -20%, 0);
    }
    to {
        opacity: 1;
        transform: translate3d(0, 0, 0);
    }
}

.animate-fade-in-down {
    animation: fadeInDown 0.5s ease-out;
}

@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
    }
    
    input, select, button {
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .break-all {
        word-break: break-all;
    }
}
</style>
