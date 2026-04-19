<?php
// Include database configuration
include('../config.php');

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
    $stmt = mysqli_prepare($connect, 'SELECT min_investment, max_investment FROM investments WHERE investment_type =?');
    mysqli_stmt_bind_param($stmt,'s', $investmentType);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $investment = mysqli_fetch_assoc($result);

    if ($investment) {
        $minInvestment = $investment['min_investment'];
        $maxInvestment = $investment['max_investment'];

        if ($amount >= $minInvestment && $amount <= $maxInvestment) {
            return true;
        } else {
            return false;
        }
    }

    return false;
}

function checkAndDeductBalance($connect, $customerId, $selectedAccount, $amount) {
    global $response;
    $accountField = ($selectedAccount == 'balance') ? 'Balance' : 'Interest_Balance';

    $stmt = mysqli_prepare($connect, 'SELECT Balance, Interest_Balance, total_invest FROM customer WHERE Customer_ID =?');
    mysqli_stmt_bind_param($stmt,'s', $customerId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $customer = mysqli_fetch_assoc($result);
    
    if ($customer) {
        $currentBalance = $customer[$accountField];
        $currentTotalInvest = $customer['total_invest'];

        if ($currentBalance >= $amount) {
            $newBalance = $currentBalance - $amount;
            $newTotalInvest = $currentTotalInvest + $amount;
            $updateStmt = mysqli_prepare($connect, "UPDATE customer SET $accountField =?, total_invest =? WHERE Customer_ID =?");
            mysqli_stmt_bind_param($updateStmt, 'dds', $newBalance, $newTotalInvest, $customerId);
            if (mysqli_stmt_execute($updateStmt)) {
                mysqli_stmt_close($updateStmt);
                return true;
            } else {
                $response['message'] = 'Error: ' . mysqli_error($connect);
                return false;
            }
        } else {
            $response['message'] = 'Insufficient balance in the selected account.';
            return false;
        }
    }
    
    $response['message'] = 'Customer not found.';
    return false;
}

function createInvestment($connect, $userId, $investment_type, $amount) {
    global $response;
    $stmt = mysqli_prepare($connect, 'SELECT total_roi, duration FROM investments WHERE investment_type =?');
    mysqli_stmt_bind_param($stmt,'s', $investment_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $plan = mysqli_fetch_assoc($result);
    
    if ($plan) {

        // Calculate total ROI and daily ROI
        $totalRoi = number_format($amount * ($plan['total_roi'] / 100), 2, '.', '');
        $dailyRoi = number_format($totalRoi / $plan['duration'], 2, '.', '');
        
        // Calculate end date based on duration
        $endDate = date('Y-m-d', strtotime("+{$plan['duration']} days"));

        // Save dailyRoi, totalRoi, and endDate for later use
        $GLOBALS['dailyRoi'] = $dailyRoi;
        $GLOBALS['totalRoi'] = $totalRoi;
        $GLOBALS['endDate'] = $endDate;

        // Prepare and execute the insert statement
        $stmt = mysqli_prepare($connect, 'INSERT INTO user_investments (user_id, plan_type, amount, start_date, end_date, total_roi, daily_roi) VALUES (?,?,?, CURDATE(),?,?,?)');
        mysqli_stmt_bind_param($stmt, 'ssssss', $userId, $investment_type, $amount, $endDate, $totalRoi, $dailyRoi);
        
        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            $response['message'] = 'Error: ' . mysqli_error($connect);
            return false;
        }
    }
    
    $response['message'] = 'Investment plan not found.';
    return false;
}

$plans = getInvestmentPlans($connect);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $investmentType = $_POST['investment_type'];
    $investmentAmount = $_POST['investment_amount'];
    $customerId = $_SESSION['customer_id'];
    $selectedAccount = $_POST['selected_account'];

    if (empty($investmentType) || empty($investmentAmount) || empty($customerId) || empty($selectedAccount)) {
        $response['message'] = 'All fields are required.';
    } else {
        $valid_min_Max = validateInvestmentAmount($connect, $investmentType, $investmentAmount);
    //check to make sure the plan is possible
        if ($valid_min_Max) {
            $check = checkAndDeductBalance($connect, $customerId, $selectedAccount, $investmentAmount);
            //check balance and withdraw from balance
            if ($check) {
                $success = createInvestment($connect, $customerId, $investmentType, $investmentAmount);
                if ($success) {
                    $response['success'] = true;
                    $response['message'] = "Deposit request '{$GLOBALS['dailyRoi']}' submitted successfully ";
                    // $_SESSION['investmentType'] = $investmentType;
                    // $_SESSION['investmentAmount'] = $investmentAmount;

                } else {
                    $response['message'] = 'Investment creation failed.';
                }
            }else{$response['message'] = 'Insufficient fund.';} 
        }else {
            $response['message'] = "Investment amount for '$investmentType' does not meet the requirements.";
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Output the response as JSON
echo json_encode($response);

// Close the database connection
mysqli_close($connect);
?>
