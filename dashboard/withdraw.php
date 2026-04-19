<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

    <h3 class="text-3xl font-bold text-gray-800 mb-8">Withdraw Funds</h3>


    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-8">
            <h4 class="text-2xl font-semibold text-gray-700 mb-6">Request Withdrawal</h4>
            <form id="withdrawForm" class="space-y-6">
            <div class="text-left mb-4">
        <p>Interest Balance</p><h4 class="text-2xl font-semibold text-gray-700">$<?php echo number_format($user['Interest_Balance'], 2); ?></h4>
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md mt-2 mb-4">
            <p class="text-yellow-700 text-sm">Note: Withdrawals can only be made from your Interest Wallet balance.</p>
        </div>
    </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount to Withdraw</label>
                        <input type="number" id="amount" name="amount" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Enter amount" required>
                    </div>
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Select Currency</label>
                        <select id="currency" name="currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" required>
                            <option value="">Choose a currency</option>
                            <option value="BTC">Bitcoin (BTC)</option>
                            <option value="USDT">USDT (TRC20)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Withdrawal Address</label>
                    <input type="text" id="address" name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Enter your wallet address" required>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium py-3 px-4 rounded-lg hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Request Withdrawal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Processing and Approval Modal -->
<div id="withdrawalModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full hidden transition-opacity duration-300 p-4">
    <div class="relative top-20 mx-auto p-4 sm:p-8 border w-full max-w-sm sm:max-w-md shadow-2xl rounded-xl bg-white transition-all duration-300 ease-in-out transform">
        <div id="confirmationContent" class="mt-3 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Confirm Withdrawal</h3>
            <p id="confirmationMessage" class="text-gray-600 mb-6"></p>
            <div class="flex justify-center space-x-4">
                <button onclick="closeWithdrawalModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
                <button onclick="proceedWithWithdrawal()" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Confirm
                </button>
            </div>
        </div>
        <div id="processingContent" class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 mb-4">
                <svg class="h-8 w-8 text-blue-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Processing Withdrawal</h3>
            <p class="text-gray-600 mb-6">
                Your withdrawal request is being processed. Please wait...
            </p>
        </div>
        <div id="approvalContent" class="mt-3 text-center hidden">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                <svg class="h-8 w-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Withdrawal Pending Approval</h3>
            <p id="approvalMessage" class="text-gray-600 mb-6"></p>
            <button onclick="closeWithdrawalModal()" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Close
            </button>
        </div>
    </div>
</div>

<script>
document.getElementById('withdrawForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const amount = document.getElementById('amount').value;
    const currency = document.getElementById('currency').value;
    const address = document.getElementById('address').value;

    if (amount && currency && address) {
        // Show confirmation modal
        showConfirmationModal(amount, currency, address);
    } else {
        alert('Please fill in all fields.');
    }
});

function showConfirmationModal(amount, currency, address) {
    const modal = document.getElementById('withdrawalModal');
    const confirmationMessage = document.getElementById('confirmationMessage');
    
    if (currency === 'USDT') {
        confirmationMessage.innerHTML = `Are you sure you want to withdraw <span>$</span>${amount} USDT to the wallet address ${address}?`;
    } else if (currency === 'BTC') {
        confirmationMessage.innerHTML = `Do you want to withdraw <span>$</span>${amount} in BTC to your BTC wallet address ${address}?`;
    }
    
    document.getElementById('confirmationContent').classList.remove('hidden');
    document.getElementById('processingContent').classList.add('hidden');
    document.getElementById('approvalContent').classList.add('hidden');
    
    modal.classList.remove('hidden');
    modal.classList.add('opacity-100');
}

function proceedWithWithdrawal() {
    document.getElementById('confirmationContent').classList.add('hidden');
    document.getElementById('processingContent').classList.remove('hidden');
    setTimeout(() => {
        callajax()
    }, 5000);
    
}
function callajax(){
    const amount = document.getElementById('amount').value;
    const currency = document.getElementById('currency').value;
    const address = document.getElementById('address').value;
    // Send AJAX request
    $.ajax({
        url: 'process_withdrawal.php',
        type: 'POST',
        data: {
            amount: amount,
            currency: currency,
            address: address
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.success) {
                document.getElementById('processingContent').classList.add('hidden');
                showWithdrawalPendingApproval(amount, currency, address);
            } else {
                alert('Error: ' + response.error);
                closeWithdrawalModal();
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('An error occurred. Please try again.');
            closeWithdrawalModal();
        }
    });
}
function showWithdrawalPendingApproval(amount, currency, address) {
    const approvalContent = document.getElementById('approvalContent');
    const approvalMessage = document.getElementById('approvalMessage');
    
    approvalMessage.textContent = `Your withdrawal request of ${amount} ${currency} to ${address} has been submitted and is pending approval.`;
    
    approvalContent.classList.remove('hidden');
    approvalContent.classList.add('animate-fade-in-down');
    
    document.getElementById('withdrawForm').reset();
}

function closeWithdrawalModal() {
    const modal = document.getElementById('withdrawalModal');
    modal.classList.add('opacity-0');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.getElementById('processingContent').classList.remove('hidden');
        document.getElementById('approvalContent').classList.add('hidden');
        window.location.href = 'index.php?page=history';
    }, 300);
}
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
}
</style>
