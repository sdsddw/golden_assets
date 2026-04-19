<?php
// Include database configuration
include('/config.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    $response['message'] = 'Sign in to continue';
    echo json_encode($response);
    exit;
}

// Validate session and user status
try {
    // Check if user still exists in database
    $stmt = $connect->prepare("SELECT id FROM customer WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['customer_id']);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $response['success'] = true;
        $response['message'] = "User is logged in";
    } else {
        // User no longer exists in database
        session_destroy();
        $response['message'] = 'Session expired, please sign in again';
    }
    $stmt->close();
} catch (Exception $e) {
    $response['message'] = 'Error checking login status';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($connect);