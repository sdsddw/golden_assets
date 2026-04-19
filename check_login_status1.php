<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once __DIR__ . '/config.php';

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set JSON header
header('Content-Type: application/json');

// Initialize response
$response = [
    'success' => false,
    'message' => '',
    'redirect' => 'login.php' // Default redirect URL
];

try {
    // Check if user is logged in
    if (empty($_SESSION['customer_id'])) {
        $response['message'] = 'Please sign in to continue';
        echo json_encode($response);
        exit;
    }
    $user_id = $_SESSION['customer_id'];
    // Check user exists
    $stmt = $connect->prepare("SELECT * FROM customer WHERE Customer_ID = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Log the error
        error_log('Session validation failed - User not found in database. User ID: ' . $user_id . '. Error ID: c78e6481-16d4-4ecc-8f0f-ff945751f220');
        
        // Destroy the session
        
        // Set response
        $response['message'] = 'Session expired, please sign in again';
        $response['error_code'] = 'c78e6481-16d4-4ecc-8f0f-ff945751f220';
        echo json_encode($response);
        exit;
    }
    $stmt->close();

    // If all checks pass
    $response['success'] = true;
    $response['message'] = 'Login status verified';
    $response['redirect'] = false;

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log('Login check error: ' . $e->getMessage());
} finally {
    echo json_encode($response);
    if ($connect) {
        $connect->close();
    }
}