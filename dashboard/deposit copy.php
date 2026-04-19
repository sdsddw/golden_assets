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
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
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
                <p class="text-sm text-gray-700 mb-2">Please send exactly <span id="confirmBtcAmount" class="font-bold"></span> BTC to the following address:</p>
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

<!-- Confirmation Overlay -->
<div id="confirmationOverlay" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-0 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white transform transition-all ease-in-out duration-300" id="confirmationBox">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Payment Request Sent Successfully</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Your payment will be approved within 30 minutes of payment confirmation.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="continueButton" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                    Continue
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let exchangeRate = 0;
let depositStep = 1;

function showDepositModal() {
    document.getElementById('depositModal').classList.remove('hidden');
    fetchExchangeRate();
}

function closeDepositModal() {
    document.getElementById('depositModal').classList.add('hidden');
    document.getElementById('usdAmount').value = '';
    document.getElementById('btcAmount').value = '';
    $('#amountInputs').show();
    $('#btcAccountInfo').hide();
    depositStep = 1;
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

function showConfirmationOverlay() {
    const overlay = document.getElementById('confirmationOverlay');
    const box = document.getElementById('confirmationBox');
    overlay.classList.remove('hidden');
    setTimeout(() => {
        box.classList.remove('top-0');
        box.classList.add('top-20');
    }, 10);

    // Animate the checkmark
    const checkmark = overlay.querySelector('svg path');
    const length = checkmark.getTotalLength();
    checkmark.style.strokeDasharray = length;
    checkmark.style.strokeDashoffset = length;
    checkmark.style.transition = 'stroke-dashoffset 0.5s ease-in-out';
    setTimeout(() => {
        checkmark.style.strokeDashoffset = '0';
    }, 300);
}

$(document).ready(function() {
    $('#usdAmount').on('input', updateBTCAmount);
    $('#btcAmount').on('input', updateUSDAmount);

    $('#confirmDeposit').click(function() {
        if (depositStep === 1) {
            let usdAmount = parseFloat($('#usdAmount').val());
            let btcAmount = parseFloat($('#btcAmount').val());
            
            if (isNaN(usdAmount) || isNaN(btcAmount) || usdAmount <= 0 || btcAmount <= 0) {
                alert('Please enter valid amounts');
                return;
            }

            $('#amountInputs').hide();
            $('#btcAccountInfo').show();
            $('#confirmBtcAmount').text(btcAmount.toFixed(8));
            depositStep = 2;
        } else if (depositStep === 2) {
            // Close the deposit modal
            closeDepositModal();
            // Show the confirmation overlay
            showConfirmationOverlay();
        }
    });

    $('#continueButton').click(function() {
        // Close the confirmation overlay
        document.getElementById('confirmationOverlay').classList.add('hidden');
        // Redirect to transaction history
        window.location.href = '?page=history';
    });
});
</script>

<style>
    #confirmationBox {
        transition: transform 0.3s ease-in-out;
        transform: translateY(-100%);
    }
    #confirmationBox.top-20 {
        transform: translateY(0);
    }
</style>
