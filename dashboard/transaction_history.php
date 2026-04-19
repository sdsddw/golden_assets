<?php
include('../config.php');

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch initial set of transactions
$limit = 100;
$sql = "SELECT 'deposit' AS type, d.amount, d.currency, d.status, d.timestamp AS Date
        FROM deposits d
        WHERE d.user_id = ?
        UNION ALL
        SELECT 'withdrawal' AS type, w.amount, w.currency, w.status, w.created_at AS Date
        FROM withdrawals w
        WHERE w.customer_id = ?
        ORDER BY Date DESC
        LIMIT ?";

$stmt = $connect->prepare($sql);
$stmt->bind_param("ssi", $_SESSION['customer_id'], $_SESSION['customer_id'], $limit);
$stmt->execute();
$result = $stmt->get_result();
$transactions = $result->fetch_all(MYSQLI_ASSOC);

// Fetch user's current balance
$balanceSql = "SELECT Balance FROM customer WHERE Customer_ID = ?";
$balanceStmt = $connect->prepare($balanceSql);
$balanceStmt->bind_param("s", $_SESSION['customer_id']);
$balanceStmt->execute();
$balanceResult = $balanceStmt->get_result();
$currentBalance = $balanceResult->fetch_assoc()['Balance'];

$connect->close();
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <h3 class="text-gray-700 text-2xl md:text-3xl font-medium mb-6">Transaction History</h3>

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
        <div class="text-2xl font-bold text-gray-800 mb-4">Current Balance: 
            <span class="text-green-600">$<?php echo number_format($currentBalance, 2); ?></span>
        </div>
        <div class="flex space-x-4 mb-4">
            <button id="allTransactions" class="bg-blue-500 text-white px-4 py-2 rounded">All</button>
            <button id="deposits" class="bg-green-500 text-white px-4 py-2 rounded">Deposits</button>
            <button id="withdrawals" class="bg-red-500 text-white px-4 py-2 rounded">Withdrawals</button>
        </div>
    </div>

    <div id="transactionContainer" class="space-y-4">
        <!-- Transactions will be dynamically inserted here -->
    </div>

    <div id="loadingIndicator" class="text-center py-4 hidden">
        <div class="spinner"></div>
        Loading more transactions...
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let transactions = <?php echo json_encode($transactions); ?>;
let currentFilter = 'all';
let startDate = null;
let endDate = null;
let page = 1;
let loading = false;

function renderTransactions() {
    const container = $('#transactionContainer');
    container.empty();

    const filteredTransactions = transactions.filter(t => {
        const transactionDate = new Date(t.Date);
        return (currentFilter === 'all' || t.type === currentFilter) &&
               (!startDate || transactionDate >= startDate) &&
               (!endDate || transactionDate <= endDate);
    });

    filteredTransactions.forEach(t => {
        const card = `
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold ${t.type === 'deposit' ? 'text-green-600' : 'text-red-600'}">
                        ${t.type === 'deposit' ? 'Deposit' : 'Withdrawal'}
                    </span>
                    <span class="text-sm text-gray-500">${new Date(t.Date).toLocaleString()}</span>
                </div>
                <div class="mt-2">
                    <span class="text-2xl font-bold">${t.currency} ${parseFloat(t.amount).toFixed(2)}</span>
                </div>
                <div class="mt-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        ${t.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'}">
                        ${t.status}
                    </span>
                </div>
            </div>
        `;
        container.append(card);
    });
}

function loadMoreTransactions() {
    if (loading) return;
    loading = true;
    $('#loadingIndicator').removeClass('hidden');

    $.ajax({
        url: 'load_more_transactions.php',
        method: 'GET',
        data: { page: page + 1, limit: 10 },
        success: function(response) {
            const newTransactions = JSON.parse(response);
            if (newTransactions.length > 0) {
                transactions = transactions.concat(newTransactions);
                page++;
                renderTransactions();
            }
            loading = false;
            $('#loadingIndicator').addClass('hidden');
        },
        error: function() {
            loading = false;
            $('#loadingIndicator').addClass('hidden');
        }
    });
}

$(document).ready(function() {
    renderTransactions();

    $('#allTransactions').click(() => { currentFilter = 'all'; renderTransactions(); });
    $('#deposits').click(() => { currentFilter = 'deposit'; renderTransactions(); });
    $('#withdrawals').click(() => { currentFilter = 'withdrawal'; renderTransactions(); });

    $('#filterDate').click(() => {
        startDate = $('#startDate').val() ? new Date($('#startDate').val()) : null;
        endDate = $('#endDate').val() ? new Date($('#endDate').val()) : null;
        renderTransactions();
    });

    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            loadMoreTransactions();
        }
    });

    // Real-time updates
    function checkForNewTransactions() {
        $.ajax({
            url: 'check_new_transactions.php',
            method: 'GET',
            success: function(response) {
                const newTransactions = JSON.parse(response);
                if (newTransactions.length > 0) {
                    transactions = newTransactions.concat(transactions);
                    renderTransactions();
                }
            }
        });
    }

    setInterval(checkForNewTransactions, 30000); // Check every 30 seconds
});
</script>

<style>
@media (max-width: 640px) {
    .grid {
        grid-template-columns: 1fr;
    }
    
    input, select, button {
        font-size: 16px;
    }
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>