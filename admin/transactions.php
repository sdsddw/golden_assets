<?php
include('../config.php');

$sql = "SELECT 'deposit' AS type, d.id, d.amount, d.currency, d.status, d.timestamp AS Date, c.Customer_Name
        FROM deposits d
        JOIN customer c ON d.user_id = c.Customer_ID
        WHERE d.status = 'pending'
        UNION ALL
        SELECT 'withdrawal' AS type, w.id, w.amount, w.currency, w.status, w.created_at AS Date, c.Customer_Name
        FROM withdrawals w
        JOIN customer c ON w.customer_id = c.Customer_ID
        WHERE w.status = 'pending'
        ORDER BY Date DESC";

$result = $connect->query($sql);
$transactions = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="text-2xl font-bold mb-4">Transaction Management</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php foreach ($transactions as $transaction): ?>
    <div class="bg-white rounded-lg shadow-md p-4">
        <div class="flex justify-between items-center mb-2">
            <span class="text-lg font-semibold <?php echo $transaction['type'] === 'deposit' ? 'text-green-600' : 'text-red-600'; ?>">
                <?php echo ucfirst($transaction['type']); ?>
            </span>
            <span class="text-sm text-gray-500"><?php echo date('Y-m-d H:i:s', strtotime($transaction['Date'])); ?></span>
        </div>
        <div class="mb-2">
            <span class="text-2xl font-bold"><?php echo $transaction['currency'] . ' ' . number_format($transaction['amount'], 2); ?></span>
        </div>
        <div class="mb-2">
            <span class="text-gray-600">User: <?php echo $transaction['Customer_Name']; ?></span>
        </div>
        <div class="flex justify-between items-center">
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                <?php echo $transaction['status']; ?>
            </span>
            <div>
                <a href="approve_transaction.php?type=<?php echo $transaction['type']; ?>&id=<?php echo $transaction['id']; ?>" class="text-green-600 hover:text-green-900 mr-2">Approve</a>
                <a href="reject_transaction.php?type=<?php echo $transaction['type']; ?>&id=<?php echo $transaction['id']; ?>" class="text-red-600 hover:text-red-900">Reject</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>