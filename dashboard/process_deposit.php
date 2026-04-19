<?php
session_start();
require '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['customer_id'])) {  // Changed from 'user_id' to 'customer_id'
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['customer_id'];  
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$currency = filter_input(INPUT_POST, 'currency', FILTER_SANITIZE_STRING);

if (!$amount || !$currency) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Modify the check to ensure the user exists in the customer table
$check_user = "SELECT Customer_ID FROM customer WHERE Customer_ID = ?";
$check_stmt = mysqli_prepare($connect, $check_user);
mysqli_stmt_bind_param($check_stmt, "i", $user_id);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if (mysqli_stmt_num_rows($check_stmt) == 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user']);
    exit;
}
mysqli_stmt_close($check_stmt);

// Add error logging
error_log("User ID: " . $user_id . ", Amount: " . $amount . ", Currency: " . $currency);

$query = "INSERT INTO deposits (user_id, amount, currency) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "sds", $user_id, $amount, $currency);

if (mysqli_stmt_execute($stmt)) {
    $deposit_id = mysqli_insert_id($connect);
    
    // Create admin notification (implement this later)
    // createAdminNotification($deposit_id);

    echo json_encode(['success' => true, 'message' => 'Deposit request submitted successfully']);
} else {
    http_response_code(500);
    $error_message = mysqli_error($connect);
    error_log("Deposit insertion error: " . $error_message);
    echo json_encode(['error' => 'Server error: ' . $error_message]);
}

mysqli_stmt_close($stmt);