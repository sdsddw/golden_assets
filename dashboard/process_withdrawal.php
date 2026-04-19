<?php
session_start();
include('../config.php');

if (!isset($_SESSION['customer_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit;
}

$customer_id = $_SESSION['customer_id'];
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$currency = filter_input(INPUT_POST, 'currency', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

if (!$amount || !$currency || !$address) {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
    exit;
}

if (!in_array($currency, ['BTC', 'USDT'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid currency']);
    exit;
}

// Check user's balance
$balance_stmt = $connect->prepare("SELECT Balance FROM customer WHERE Customer_ID = ?");
$balance_stmt->bind_param("s", $customer_id);
$balance_stmt->execute();
$balance_result = $balance_stmt->get_result();
$user_balance = $balance_result->fetch_assoc()['Balance'];
$balance_stmt->close();

if ($amount > $user_balance) {
    echo json_encode(['success' => false, 'error' => 'Insufficient balance']);
    exit;
}

try {
    $stmt = $connect->prepare("INSERT INTO withdrawals (customer_id, amount, currency, address, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sdss", $customer_id, $amount, $currency, $address);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database error']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}

$connect->close();
