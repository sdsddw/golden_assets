<?php
// Include database configuration
include('../config.php');

// Ensure logs directory exists
if (!file_exists(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0777, true);
}

function logError($message, $level = 'ERROR') {
    $date = date('Y-m-d H:i:s');
    $logMessage = "[$date][$level] $message\n";
    file_put_contents(__DIR__ . '/logs/investment.log', $logMessage, FILE_APPEND);
}

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

// Function to fetch investment plans
function getInvestmentPlans($connect) {
    global $response;
    $query = 'SELECT * FROM investments';
    $result = mysqli_query($connect, $query);
    if (!$result) {
        $response['message'] = 'Query failed: ' . mysqli_error($connect);
        return false;
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function validateInvestmentAmount($connect, $investmentType, $amount) {
    logError("Validating investment amount: $amount for type: $investmentType", 'INFO');
    
    $stmt = mysqli_prepare($connect, 'SELECT min_investment, max_investment FROM investments WHERE investment_type =?');
    if (!$stmt) {
        logError("Failed to prepare validation statement: " . mysqli_error($connect), 'ERROR');
        return false;
    }
    
    mysqli_stmt_bind_param($stmt,'s', $investmentType);
    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute validation statement: " . mysqli_stmt_error($stmt), 'ERROR');
        return false;
    }
    
    $result = mysqli_stmt_get_result($stmt);
    $investment = mysqli_fetch_assoc($result);

    if ($investment) {
        $minInvestment = $investment['min_investment'];
        $maxInvestment = $investment['max_investment'];
        
        logError("Investment limits - Min: $minInvestment, Max: $maxInvestment, Requested: $amount", 'INFO');

        if ($amount >= $minInvestment && $amount <= $maxInvestment) {
            logError("Amount validation passed", 'SUCCESS');
            return true;
        } else {
            logError("Amount outside allowed range", 'ERROR');
            return false;
        }
    }

    logError("Investment type not found: $investmentType", 'ERROR');
    return false;
}

function checkCustomerBalance($connect, $customerId, $selectedAccount) {
    global $response;
    logError("Checking balance for customer: $customerId, account: $selectedAccount", 'INFO');
    $accountField = ($selectedAccount == 'balance') ? 'Balance' : 'Interest_Balance';
    $stmt = mysqli_prepare($connect, "SELECT $accountField, total_invest FROM customer WHERE Customer_ID = ? FOR UPDATE");
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . mysqli_error($connect));
    }
    mysqli_stmt_bind_param($stmt, 's', $customerId);
    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Failed to execute statement: ' . mysqli_stmt_error($stmt));
    }
    $result = mysqli_stmt_get_result($stmt);
    $customer = mysqli_fetch_assoc($result);
    if (!$customer) {
        logError("No customer found with ID: $customerId", 'ERROR');
        throw new Exception('Customer not found.');
    }
    return [
        'currentBalance' => $customer[$accountField],
        'currentTotalInvest' => $customer['total_invest']
    ];
}

function deductBalanceAndInvest($connect, $customerId, $selectedAccount, $investmentAmount, $currentBalance, $currentTotalInvest) {
    global $response;
    logError("Deducting balance and investing for customer: $customerId, account: $selectedAccount, amount: $investmentAmount", 'INFO');
    $accountField = ($selectedAccount == 'balance') ? 'Balance' : 'Interest_Balance';
    $newBalance = $currentBalance - $investmentAmount;
    $newTotalInvest = $currentTotalInvest + $investmentAmount;
    $updateStmt = mysqli_prepare($connect, "UPDATE customer SET $accountField = ?, total_invest = ? WHERE Customer_ID = ?");
    mysqli_stmt_bind_param($updateStmt, 'dds', $newBalance, $newTotalInvest, $customerId);
    if (!mysqli_stmt_execute($updateStmt)) {
        throw new Exception('Failed to update balance.');
    }
    return true;
}

function createInvestment($connect, $userId, $investment_type, $amount) {
    global $response;
    
    // Cast amount to float for proper calculation
    $amount = floatval($amount);
    
    $stmt = mysqli_prepare($connect, 'SELECT total_roi, duration, daily_roi FROM investments WHERE investment_type = ?');
    mysqli_stmt_bind_param($stmt, 's', $investment_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $plan = mysqli_fetch_assoc($result);
    
    if ($plan) {
        // Use the plan's daily_roi instead of calculating
        $dailyRoi = number_format(($amount * ($plan['daily_roi'] / 100)), 2, '.', '');
        $totalRoi = number_format(($amount * ($plan['total_roi'] / 100)), 2, '.', '');
        $endDate = date('Y-m-d', strtotime("+{$plan['duration']} days"));

        // Use prepared statement with proper type binding
        $stmt = mysqli_prepare($connect, 
            'INSERT INTO user_investments (user_id, plan_type, amount, start_date, end_date, total_roi, daily_roi) 
             VALUES (?, ?, ?, CURDATE(), ?, ?, ?)'
        );
        mysqli_stmt_bind_param($stmt, 'ssdsdd', 
            $userId, 
            $investment_type, 
            $amount, 
            $endDate, 
            $totalRoi, 
            $dailyRoi
        );
        
        if (mysqli_stmt_execute($stmt)) {
            $GLOBALS['dailyRoi'] = $dailyRoi;
            $GLOBALS['totalRoi'] = $totalRoi;
            $GLOBALS['endDate'] = $endDate;
            return true;
        }
        
        $response['message'] = 'Error: ' . mysqli_stmt_error($stmt);
        return false;
    }
    
    $response['message'] = 'Investment plan not found.';
    return false;
}

// Main POST handling section
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    logError("New investment request received", 'INFO');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['customer_id'])) {
        logError("User not logged in - no customer_id in session", 'ERROR');
        $response['message'] = 'User not authenticated';
        echo json_encode($response);
        exit;
    }
    $investmentType = filter_input(INPUT_POST, 'investment_type', FILTER_SANITIZE_STRING);
    $investmentAmount = filter_input(INPUT_POST, 'investment_amount', FILTER_VALIDATE_FLOAT);
    $customerId = $_SESSION['customer_id'];
    $selectedAccount = filter_input(INPUT_POST, 'selected_account', FILTER_SANITIZE_STRING);
    logError("Raw POST data: " . print_r($_POST, true), 'INFO');
    logError("Session customer_id: " . $_SESSION['customer_id'], 'INFO');
    logError("Posted customer_id: " . $customerId, 'INFO');
    if ($customerId != $_SESSION['customer_id']) {
        logError("Customer ID mismatch - Session: {$_SESSION['customer_id']}, Posted: {$customerId}", 'ERROR');
        $response['message'] = 'Invalid customer ID';
        echo json_encode($response);
        exit;
    }
    if (!$investmentAmount) {
        logError("Invalid investment amount provided", 'ERROR');
        $response['message'] = 'Invalid investment amount.';
        echo json_encode($response);
        exit;
    }
    if (!in_array($selectedAccount, ['balance', 'interest'])) {
        logError("Invalid account selection: $selectedAccount", 'ERROR');
        $response['message'] = 'Invalid account selection.';
        echo json_encode($response);
        exit;
    }
    if (empty($investmentType) || empty($investmentAmount) || empty($customerId) || empty($selectedAccount)) {
        logError("Missing required fields", 'ERROR');
        $response['message'] = 'All fields are required.';
    } else {
        $valid_min_Max = validateInvestmentAmount($connect, $investmentType, $investmentAmount);
        if ($valid_min_Max) {
            try {
                mysqli_begin_transaction($connect);
                $balanceData = checkCustomerBalance($connect, $customerId, $selectedAccount);
                if ($balanceData['currentBalance'] < $investmentAmount) {
                    throw new Exception('Insufficient balance in the selected account.');
                }
                deductBalanceAndInvest($connect, $customerId, $selectedAccount, $investmentAmount, $balanceData['currentBalance'], $balanceData['currentTotalInvest']);
                mysqli_commit($connect);
                $response['success'] = true;
                $response['message'] = "Investment of $investmentAmount created successfully. Daily ROI: {$GLOBALS['dailyRoi']}";
            } catch (Exception $e) {
                mysqli_rollback($connect);
                logError("Transaction failed: " . $e->getMessage(), 'ERROR');
                $response['message'] = $e->getMessage();
            }
        } else {
            logError("Investment amount validation failed for type '$investmentType' with amount $investmentAmount", 'ERROR');
            $response['message'] = "Investment amount for '$investmentType' does not meet the requirements.";
        }
    }
} else {
    logError("Invalid request method: " . $_SERVER['REQUEST_METHOD'], 'ERROR');
    $response['message'] = 'Invalid request method.';
}

logError("Final response: " . json_encode($response), 'INFO');
echo json_encode($response);
mysqli_close($connect);
?>