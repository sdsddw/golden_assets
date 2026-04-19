<?php
include('../config.php');

if (!isset($_GET['type']) || !isset($_GET['id'])) {
    header("Location: dashboard.php?page=transactions&error=Invalid transaction");
    exit();
}

$type = $_GET['type'];
$transaction_id = $_GET['id'];

$connect->begin_transaction();

try {
    if ($type == 'deposit') {
        // Update deposit status
        $sql = "UPDATE deposits SET status = 'approved' WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();

        // Get deposit details
        $sql = "SELECT user_id, amount FROM deposits WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $deposit = $result->fetch_assoc();

        // Update user balance
        $sql = "UPDATE customer SET Balance = Balance + ? WHERE Customer_ID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("di", $deposit['amount'], $deposit['user_id']);
        $stmt->execute();
    } elseif ($type == 'withdrawal') {
        // Update withdrawal status
        $sql = "UPDATE withdrawals SET status = 'completed' WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();

        // Get withdrawal details
        $sql = "SELECT customer_id, amount FROM withdrawals WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $withdrawal = $result->fetch_assoc();

        
        $sql = "UPDATE customer SET Interest_Balance = Interest_Balance - ? WHERE Customer_ID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("di", $withdrawal['amount'], $withdrawal['customer_id']);
        $stmt->execute();

        $sql = "UPDATE withdrawals SET status = 'approved' WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $transaction_id);
        $stmt->execute();
        
    } else {
        throw new Exception("Invalid transaction type");
    }

    $connect->commit();
    header("Location: dashboard.php?page=transactions&message=Transaction approved successfully");
} catch (Exception $e) {
    $connect->rollback();
    header("Location: dashboard.php?page=transactions&error=" . urlencode($e->getMessage()));
}
exit();